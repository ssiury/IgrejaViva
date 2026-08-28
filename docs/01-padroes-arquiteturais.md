# Padrões Arquiteturais — Projeto Igreja Viva (Backend Laravel modular + Frontend Vue.js, via Docker)

> Este documento é **normativo**. Qualquer código gerado que viole uma regra
> aqui descrita deve ser corrigido antes de ser considerado concluído.
> Deve ser lido **antes** de `02-casos-de-uso.md` e `03-prompt-claude-code.md`.

---

## 0. Premissa central: backend é uma API, ponto final

O backend **não conhece** quem vai consumi-lo. Ele existe para servir dado
via HTTP/JSON. Hoje o cliente é uma SPA em Vue; amanhã pode ser um app
mobile (Flutter/React Native), um painel administrativo separado, ou
integração com outro sistema. Por isso:

- O backend **nunca** renderiza HTML de tela nenhuma. Não existe Blade
  servindo view de landing page, não existe Inertia, não existe mistura de
  camadas de apresentação dentro do Laravel.
- Toda comunicação backend ↔ frontend é via **API HTTP versionada**
  (`/api/v1/...`), com JSON de entrada e saída.
- Backend e frontend são **projetos independentes**, cada um com seu
  próprio ciclo de build, próprio container Docker, e podem inclusive
  evoluir para repositórios Git separados sem exigir refatoração — a
  separação já nasce pronta para isso.

---

## 1. Estrutura de repositório (monorepo com dois projetos isolados)

```
igreja-viva/
├── backend/                 # Projeto Laravel (API), roda em container próprio
├── frontend/                # Projeto Vue 3 + Vite (SPA), roda em container próprio
├── docker/                  # Configurações de infraestrutura (nginx, php, etc.)
├── docker-compose.yml
├── docker-compose.override.yml   # (opcional, ajustes locais de dev)
└── docs/                    # Este e os demais documentos de contexto
```

Nada dentro de `backend/` deve importar ou depender de nada dentro de
`frontend/`, e vice-versa. O único contrato entre os dois é a API HTTP.

---

## 2. Fluxo de camadas (vale dentro de cada módulo do backend)

```
View (Vue, projeto frontend) → Requisição (FormRequest) → Controller → Application → Repository → Model
```

| Camada | Onde vive | Pode fazer | NÃO pode fazer |
|---|---|---|---|
| **View** | `frontend/` (Vue) | Renderizar UI, chamar a API, exibir loading/erro | Regra de negócio, receber dado de domínio via prop de "controller" (não existe controller no front), montar SQL, strings literais |
| **Requisição** | `backend/app/Modules/<Modulo>/Http/Requests` | Validar payload, mensagens de erro, autorizar | Persistir dado, regra de negócio, acessar Model |
| **Controller** | `backend/app/Modules/<Modulo>/Http/Controllers` | Orquestrar: chamar **um único método** da Application, devolver `JsonResponse`/Resource | Regra de negócio, acesso a Repository/Model, mais de uma responsabilidade por método |
| **Application** | `backend/app/Modules/<Modulo>/Applications` | Concentrar regra de negócio, orquestrar um ou mais Repositories (do próprio módulo ou de contratos de outros módulos) | Rodar query, usar Eloquent/`DB::` diretamente |
| **Repository** | `backend/app/Modules/<Modulo>/Repositories` | Buscar/persistir via Model/Eloquent parametrizado | Regra de negócio, SQL cru concatenado |
| **Model** | `backend/app/Modules/<Modulo>/Models` | Representar entidade, relacionamentos, `scopes` simples de coluna | Regra de negócio de aplicação, validação de formulário |

---

## 3. Modularização do backend

Cada módulo é um **contexto delimitado** (bounded context), autossuficiente:
tem suas próprias rotas, seu próprio provider, seus próprios
Controllers/Applications/Repositories/Models/Requests/Resources. Adicionar
um módulo novo **nunca** exige alterar um módulo existente (Open/Closed
aplicado no nível de módulo, não só de classe).

### 3.1 Módulos deste projeto

- `Culto` — horários de culto
- `Ministerio` — ministérios da igreja
- `InformacaoIgreja` — endereço, contato, redes sociais (configuração singleton)
- `SolicitacaoVisita` — formulário de "quero visitar"
- `Shared` (ou `Core`) — o que é usado por mais de um módulo: classe base de exceção de domínio, formatação padrão de resposta de API, contratos genéricos, helpers de arquivo de idioma

### 3.2 Estrutura interna de um módulo

```
app/Modules/Culto/
├── Http/
│   ├── Controllers/CultoController.php
│   └── Resources/CultoResource.php
├── Applications/
│   └── ListarCultosApplication.php
├── Repositories/
│   ├── Contracts/CultoRepositoryInterface.php
│   └── Eloquent/CultoRepository.php
├── Models/Culto.php
├── Providers/CultoServiceProvider.php   # registra bindings + rotas do módulo
├── routes.php                            # rotas exclusivas deste módulo
└── database/
    ├── migrations/
    └── seeders/CultoSeeder.php
```

Cada `Providers/<Modulo>ServiceProvider.php` é registrado uma única vez em
`bootstrap/providers.php` (ou `config/app.php`, conforme a versão do
Laravel). É ele quem faz `$this->app->bind(CultoRepositoryInterface::class, CultoRepository::class)`
e `Route::group(...)->group(base_path('app/Modules/Culto/routes.php'))`.

> Recomendação prática: use o pacote `nwidart/laravel-modules` para
> acelerar a criação (`php artisan module:make Culto`), mas a estrutura
> interna de cada módulo e as regras de camada acima **continuam valendo
> integralmente** — o pacote só organiza pastas, não substitui a
> disciplina arquitetural deste documento.

### 3.3 Comunicação entre módulos

Um módulo **nunca** acessa o Repository ou o Model de outro módulo
diretamente. Se `SolicitacaoVisita` precisa validar que um `culto_id`
existe, sua Application recebe, via injeção de dependência, o **contrato**
`CultoRepositoryInterface` (do módulo `Culto`) — nunca a implementação
concreta, nunca o Model `Culto` diretamente.

```php
// app/Modules/SolicitacaoVisita/Applications/CriarSolicitacaoVisitaApplication.php
public function __construct(
    private SolicitacaoVisitaRepositoryInterface $solicitacaoVisitaRepository,
    private CultoRepositoryInterface $cultoRepository, // contrato de outro módulo, ok
) {}
```

---

## 4. SOLID (aplicado a classes E a módulos)

- **S** — uma classe/método muda por um único motivo; um módulo muda por um único motivo de negócio.
- **O** — novo módulo ou nova implementação de Repository não exige tocar em código existente.
- **L** — qualquer implementação de uma interface de Repository é substituível sem quebrar quem a consome.
- **I** — interfaces pequenas e específicas por agregado, nunca uma interface "genérica" para tudo.
- **D** — Controllers e Applications dependem de abstrações (interfaces), nunca de classes concretas; bindings centralizados no provider do próprio módulo.

## 5. Uma função, uma responsabilidade (CQS)

Vale para o backend inteiro e para o frontend: uma função ou **busca dado**
(query) ou **executa uma ação** (command), nunca as duas coisas. Um método
de Controller nunca faz duas chamadas de Application com propósitos
diferentes; um composable Vue nunca busca E envia dado na mesma função.

## 6. Proibição de strings literais

- **Backend:** `lang/pt_BR/*.php`, acessado via `__('modulo.chave')`. Rotas sempre nomeadas.
- **Frontend:** um único `src/i18n/pt-BR.json`, consumido via composable `useStrings()`; endpoints centralizados em `src/config/apiRoutes.js`, nunca URL solta dentro de um componente.

## 7. Props: nada de dado de domínio

Como não existe mais Blade renderizando o Vue, a regra fica ainda mais
simples de garantir: **todo componente busca seu próprio dado via API**
(`onMounted`). Prop só carrega um `id` que já existia antes na rota (ex.:
Vue Router com `/visita/:id`, se um dia existir) ou uma chave de i18n —
nunca o valor de negócio já resolvido.

## 8. Repositórios: sem regra de negócio, sem SQL Injection

Eloquent ou Query Builder sempre com binding de parâmetro. Filtros de
coluna simples (`where('ativo', true)`) podem estar no Repository; qualquer
decisão condicional de negócio (ex.: "ativo E dentro do horário comercial E
sem duplicidade") fica na Application.

---

## 9. Docker

### 9.1 Serviços

| Serviço | Papel | Porta local sugerida |
|---|---|---|
| `backend` | PHP-FPM rodando a aplicação Laravel | interna (9000) |
| `nginx-backend` | Serve a API, proxy para o `backend` | `8000` |
| `frontend` | Build Vite servido por Nginx (produção) ou `vite dev` (dev) | `5173` (dev) / `8080` (build) |
| `db` | PostgreSQL | `5432` |

### 9.2 `docker-compose.yml` (esqueleto de referência)

```yaml
services:
  backend:
    build: ./backend
    volumes:
      - ./backend:/var/www/html
    env_file: ./backend/.env
    depends_on: [db]
    networks: [igreja-viva]

  nginx-backend:
    image: nginx:alpine
    volumes:
      - ./backend:/var/www/html
      - ./docker/nginx/backend.conf:/etc/nginx/conf.d/default.conf
    ports: ["8000:80"]
    depends_on: [backend]
    networks: [igreja-viva]

  frontend:
    build: ./frontend
    volumes:
      - ./frontend:/app
    env_file: ./frontend/.env
    ports: ["5173:5173"]
    depends_on: [nginx-backend]
    networks: [igreja-viva]

  db:
    image: postgres:16-alpine
    environment:
      POSTGRES_DB: igreja_viva
      POSTGRES_USER: igreja_viva
      POSTGRES_PASSWORD: secret
    volumes:
      - db-data:/var/lib/postgresql/data
    ports: ["5432:5432"]
    networks: [igreja-viva]

networks:
  igreja-viva:
volumes:
  db-data:
```

### 9.3 Regras para os Dockerfiles

- `backend/Dockerfile`: PHP 8.2+ com extensões necessárias (`pdo_pgsql`,
  `pgsql`, `mbstring`, etc.), `composer install --no-dev` na imagem de
  produção, imagem de dev pode incluir Xdebug atrás de uma variável de
  ambiente.
- `frontend/Dockerfile`: multi-stage — estágio `build` com Node rodando
  `npm run build`, estágio final servindo os arquivos estáticos via Nginx
  (produção) ou rodando `npm run dev` (desenvolvimento, com hot reload).
- Nenhum segredo (senha de banco, chave de API) fica hardcoded na imagem —
  tudo vem de `.env` / variáveis de ambiente do compose.

### 9.4 CORS e comunicação entre containers

- `backend/config/cors.php` libera explicitamente a origem do `frontend`
  (`http://localhost:5173` em dev; o domínio real em produção) — nunca
  `'*'` em produção.
- O frontend nunca chama o backend por `service name` do Docker
  (`http://backend:9000`) diretamente do navegador — isso só funciona
  container-a-container. No navegador, ele sempre chama a URL pública
  (`http://localhost:8000/api/v1/...`), configurável via variável de
  ambiente `VITE_API_BASE_URL`.

---

## 10. Estrutura de pastas de referência (visão completa)

```
igreja-viva/
├── docker-compose.yml
├── docker/
│   └── nginx/backend.conf
├── docs/
│   ├── 01-padroes-arquiteturais.md
│   ├── 02-casos-de-uso.md
│   └── 03-prompt-claude-code.md
├── backend/
│   ├── Dockerfile
│   ├── app/
│   │   ├── Modules/
│   │   │   ├── Culto/            (ver seção 3.2)
│   │   │   ├── Ministerio/
│   │   │   ├── InformacaoIgreja/
│   │   │   ├── SolicitacaoVisita/
│   │   │   └── Shared/
│   │   │       ├── Exceptions/DomainException.php
│   │   │       └── Http/ApiResponse.php
│   │   └── Providers/
│   ├── lang/pt_BR/
│   ├── routes/
│   │   └── api.php               # só agrega os routes.php de cada módulo
│   └── config/cors.php
└── frontend/
    ├── Dockerfile
    ├── index.html
    ├── vite.config.js
    └── src/
        ├── main.js
        ├── App.vue
        ├── pages/LandingPage.vue
        ├── components/
        │   ├── layout/TheHeader.vue, TheFooter.vue
        │   └── sections/HeroSection.vue, SobreSection.vue, CultosSection.vue,
        │       MinisteriosSection.vue, VisitaFormSection.vue, LocalizacaoSection.vue
        ├── composables/useCultos.js, useMinisterios.js, useInformacaoIgreja.js, useSolicitacaoVisita.js
        ├── services/http.js, api/cultoService.js, ministerioService.js, informacaoIgrejaService.js, solicitacaoVisitaService.js
        ├── i18n/pt-BR.json
        └── config/apiRoutes.js
```

---

## 11. Checklist de conformidade

- [ ] Backend não contém nenhuma view/Blade de tela, nenhuma dependência de Inertia.
- [ ] Cada módulo tem seu próprio provider, rotas e bindings — nenhum módulo referencia Repository/Model de outro módulo diretamente.
- [ ] Comunicação entre módulos, quando necessária, passa por **contrato** (interface), nunca por implementação concreta.
- [ ] API versionada em `/api/v1/...`.
- [ ] Nenhum Controller acessa Model ou Repository diretamente.
- [ ] Nenhuma Application acessa `DB::`/Eloquent diretamente.
- [ ] Nenhum Repository contém regra de negócio condicional complexa.
- [ ] Nenhum componente Vue recebe dado de domínio via prop — todo dado vem de chamada à API.
- [ ] Toda string de UI está em `pt-BR.json` (front) ou `lang/pt_BR/*.php` (back).
- [ ] Todo POST tem uma `FormRequest` própria.
- [ ] `docker-compose up` sobe os 4 serviços e a SPA consegue falar com a API sem erro de CORS.
- [ ] Nenhuma credencial hardcoded em Dockerfile ou código-fonte.
