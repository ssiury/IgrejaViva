# Prompt para o Claude Code — Projeto Igreja Viva (Backend Laravel modular + Frontend Vue.js + Docker)

> Copie e cole este arquivo inteiro como primeira mensagem para o Claude
> Code, na mesma pasta em que estiverem também `01-padroes-arquiteturais.md`,
> `02-casos-de-uso.md` e o arquivo de referência visual
> `igreja-viva-landing_1.html`.

---

## Contexto

Construa, do zero, um **monorepo com dois projetos independentes**:

- `backend/` — API Laravel, organizada em **módulos** por contexto de
  negócio, sem nenhuma camada de apresentação (sem Blade, sem Inertia).
- `frontend/` — SPA Vue 3 + Vite, que reproduz fielmente o visual do
  arquivo `igreja-viva-landing_1.html` (paleta preto/laranja, tipografia
  Fraunces + Manrope, partículas de brasa no hero, scroll reveal, header
  com fundo ao rolar), consumindo o backend **exclusivamente via HTTP**.

Todo o ambiente sobe via **Docker Compose** — nada de exigir PHP/Node
instalado localmente para rodar o projeto.

Antes de escrever qualquer código, **leia integralmente**:

1. `01-padroes-arquiteturais.md` — regras de arquitetura, modularização e
   Docker, todas **obrigatórias**.
2. `02-casos-de-uso.md` — especificação funcional exata: módulos,
   endpoints, entidades e regras de negócio.
3. `igreja-viva-landing_1.html` — referência visual/estrutural: extraia a
   paleta (`:root` do CSS), tipografia, markup de cada seção, textos (viram
   chaves do `pt-BR.json`) e o comportamento em JS.

## Regras não negociáveis (resumo — fonte da verdade é o doc 01)

- Backend é API pura, versionada em `/api/v1/...`. Zero HTML gerado por ele.
- Backend organizado em `app/Modules/<Contexto>`, cada módulo com seu
  provider, rotas, controllers, applications, repositories, models e
  requests próprios. Módulo novo não altera módulo existente.
- Comunicação entre módulos só via **contrato** (interface), nunca
  implementação concreta ou Model de outro módulo.
- Fluxo obrigatório em cada módulo: `Requisição → Controller → Application → Repository → Model`.
- Controller só orquestra (chama um único método da Application e devolve JSON). Zero regra de negócio.
- Application concentra a regra de negócio e só fala com Repository (do próprio módulo ou contrato de outro), nunca com Eloquent/`DB::` direto.
- Repository busca/persiste via Model (Eloquent ou Query Builder parametrizado), zero regra de negócio, zero SQL cru concatenado.
- Toda função pública faz uma coisa só (CQS).
- Proibido string literal de UI/rota solta: backend usa `lang/pt_BR/*.php`; frontend usa `src/i18n/pt-BR.json` + `src/config/apiRoutes.js`.
- Frontend nunca recebe dado de domínio via prop de "controller" — não existe controller no front; cada componente busca seu próprio dado via API no `onMounted`.
- **Não usar Blade nem Inertia.js** no backend. O `frontend/` é um projeto Vue standalone (Vite), servido por seu próprio container.
- Tudo sobe via `docker-compose.yml`: containers de `backend`, `nginx-backend`, `frontend` e `db`, conforme seção 9 do documento 01.

## Stack e ferramentas

- **Backend:** Laravel (versão estável mais recente), PHP 8.2+, PostgreSQL 16 (via container em dev; em produção, um serviço gerenciado gratuito como Neon ou Supabase), `nwidart/laravel-modules` como acelerador de estrutura modular (opcional, mas recomendado — ver seção 3.2 do doc 01).
- **Frontend:** Vue 3 + `<script setup>` + Vite, Axios para HTTP, sem Tailwind obrigatório (replicar o CSS original em `src/styles/`), sem Vue Router obrigatório nesta fase (página única), mas estruturar como se pudesse crescer para múltiplas rotas.
- **Infra:** Docker + Docker Compose, Nginx como proxy do backend e como servidor de estáticos do frontend em produção.
- Sem autenticação nesta fase.

## Passo a passo esperado

1. **Estrutura do monorepo** — criar `backend/`, `frontend/`, `docker/`, `docker-compose.yml`, conforme seção 1 e 10 do documento 01.
2. **Backend: scaffold Laravel** — projeto novo dentro de `backend/`, configurar `.env.example`, remover tudo que for de apresentação (views padrão, Inertia, etc., se vierem no scaffold).
3. **Backend: módulos** — criar os módulos `Culto`, `Ministerio`, `InformacaoIgreja`, `SolicitacaoVisita` e `Shared`, cada um com a estrutura interna da seção 3.2 do doc 01 (Http/Controllers, Http/Resources, Applications, Repositories/Contracts, Repositories/Eloquent, Models, Providers, routes.php, database/migrations, database/seeders).
4. **Backend: migrations e seeders** — campos conforme documento 02; seeders com os mesmos dados de exemplo do HTML original (Culto de Celebração 09h, Culto da Família 19h, Culto de Oração 20h; os 6 ministérios: Kids Viva, Jovens, Louvor, Células, Casais, Ação Social; endereço/telefone/e-mail de exemplo).
5. **Backend: Repositories + Contracts** — uma interface e uma implementação por entidade; bindings registrados no `ServiceProvider` do próprio módulo.
6. **Backend: Applications** — uma classe por caso de uso do documento 02, um único método público de execução cada.
7. **Backend: FormRequest** — `SolicitacaoVisitaRequest` com as regras do UC04, mensagens via `lang/pt_BR/validation.php`.
8. **Backend: Resources e Controllers** — Resources para formatar JSON; Controllers com um método por ação (`index`/`show`/`store`), sem lógica.
9. **Backend: rotas** — cada módulo expõe seu `routes.php`, agregado em `routes/api.php` sob o prefixo `v1`. Nomear todas as rotas.
10. **Backend: `Shared`** — `ApiResponse` (formato padrão de sucesso/erro), classe base de exceção de domínio, handler global convertendo exceções de domínio em códigos HTTP apropriados (404/409/422).
11. **Backend: CORS** — `config/cors.php` liberando a origem do frontend via variável de ambiente.
12. **Backend: Dockerfile** — imagem PHP-FPM + extensões necessárias; `docker/nginx/backend.conf` como proxy.
13. **Frontend: scaffold Vite + Vue 3** — projeto dentro de `frontend/`, `VITE_API_BASE_URL` como variável de ambiente.
14. **Frontend: infraestrutura** — `src/services/http.js` (instância Axios única, lendo `VITE_API_BASE_URL`), `src/config/apiRoutes.js`, `src/i18n/pt-BR.json` com **todos** os textos extraídos do HTML original, composable `useStrings()`.
15. **Frontend: services + composables** — um service por entidade (`cultoService.js` com `listar()`, `solicitacaoVisitaService.js` com `criar()`), um composable por caso de uso (`useCultos.js` expõe `cultos`, `carregando`, `erro`), seguindo CQS.
16. **Frontend: componentes de seção** — recriar visualmente cada seção do HTML original (`TheHeader`, `HeroSection`, `SobreSection`, `CultosSection`, `MinisteriosSection`, `VisitaFormSection`, `LocalizacaoSection`, `TheFooter`), incluindo:
    - partículas de brasa animadas no hero (`<canvas>`, respeitando `prefers-reduced-motion`);
    - efeito de scroll reveal;
    - header que ganha fundo ao rolar;
    - estados de `loading`/erro nas seções que buscam dado, com strings do i18n.
17. **`VisitaFormSection.vue`** — formulário completo com validação client-side leve, exibição de erros vindos da API (`422`) e mensagem de sucesso (`201`), select de culto de preferência populado por `useCultos()`.
18. **Frontend: Dockerfile** — multi-stage (`build` com Node, servido por Nginx em produção; modo dev com `vite dev` e hot reload).
19. **`docker-compose.yml` na raiz** — 4 serviços (`backend`, `nginx-backend`, `frontend`, `db`), rede compartilhada, volumes nomeados para o banco.
20. **Conferência final** — percorrer o checklist de conformidade do documento 01, item a item, incluindo os itens específicos de módulos e Docker.

## Critérios de aceite

- `docker-compose up` sobe os 4 serviços sem erro.
- A SPA (frontend) carrega e chama a API (backend) sem erro de CORS.
- As seções `Cultos`, `Ministérios` e `Localização` mostram dado real vindo do banco via API, com estado de loading breve.
- O formulário de visita cria um registro real e mostra feedback de sucesso/erro.
- Nenhum módulo do backend acessa Repository/Model de outro módulo diretamente — só via contrato.
- Nenhum Controller acessa Model/Repository diretamente; nenhuma Application acessa Eloquent/`DB::` diretamente.
- Nenhuma string de UI solta em `.vue`/`.php` — tudo em `pt-BR.json` ou `lang/pt_BR/*.php`.
- Todos os endpoints respondem sob `/api/v1/...`.
- Revisão final do checklist da seção 11 de `01-padroes-arquiteturais.md`, todos os itens confirmados.

## Observação final

Se alguma decisão não estiver coberta pelos documentos 01/02 (ex.: nome
exato de uma coluna, formato de um campo), tome a decisão mais simples e
coerente com o padrão já definido, documente brevemente no código e siga
em frente — só pare para perguntar se a dúvida envolver **contrariar**
uma das regras não negociáveis listadas acima.
