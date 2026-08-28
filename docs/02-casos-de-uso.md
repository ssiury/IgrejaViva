# Casos de Uso — Projeto Igreja Viva (API modular)

> Baseado no arquivo `igreja-viva-landing_1.html` (versão estática já
> aprovada visualmente). O backend agora é **API pura** (sem view de tela),
> organizada em módulos conforme `01-padroes-arquiteturais.md`. O
> carregamento visual da página é responsabilidade exclusiva do projeto
> `frontend/` (SPA Vue) e não gera caso de uso de backend.

Todos os endpoints são versionados: prefixo `/api/v1`.

---

## UC01 — Listar Horários de Culto

- **Módulo:** `Culto`
- **Ator:** Cliente da API (SPA web hoje; app mobile ou outro cliente no futuro)
- **Pré-condição:** existir ao menos um registro de culto ativo (lista vazia é estado válido)
- **Fluxo principal:**
  1. Cliente chama `GET /api/v1/cultos`.
  2. `Modules/Culto/Http/Controllers/CultoController@index` chama `ListarCultosApplication::executar()`.
  3. `ListarCultosApplication` chama `CultoRepositoryInterface::listarAtivos()`.
  4. `CultoRepository` consulta `Culto` filtrando `ativo = true`, ordenado por `ordem`.
  5. Controller devolve `CultoResource::collection(...)`.
- **Fluxo alternativo:** lista vazia → resposta `200` com array vazio (o cliente decide como exibir).
- **Fluxo de exceção:** erro interno → resposta `500` padronizada (`Shared/Http/ApiResponse`).
- **Camadas:** Controller → Application → Repository → Model (tudo dentro do módulo `Culto`).
- **Endpoint:** `GET /api/v1/cultos`
- **Regra de negócio (Application):** somente `ativo = true`; ordenação é decisão da Application, não do Repository nem do cliente.

---

## UC02 — Listar Ministérios

- **Módulo:** `Ministerio`
- Idêntico ao UC01, trocando a entidade.
- **Endpoint:** `GET /api/v1/ministerios`
- **Regra de negócio (Application):** somente `ativo = true`, ordenados por `ordem`.

---

## UC03 — Obter Informações de Contato e Localização

- **Módulo:** `InformacaoIgreja`
- **Ator:** Cliente da API
- **Pré-condição:** existir um registro de configuração (endereço, telefone, e-mail, redes sociais) — singleton
- **Fluxo principal:**
  1. `GET /api/v1/informacoes-igreja`.
  2. `InformacaoIgrejaController@show` chama `ObterInformacaoIgrejaApplication::executar()`.
  3. Application chama `InformacaoIgrejaRepositoryInterface::obterAtual()`.
  4. Controller devolve `InformacaoIgrejaResource`.
- **Fluxo alternativo:** registro inexistente → Application lança exceção de domínio (`InformacaoIgrejaNaoConfiguradaException`, em `Shared/Exceptions` ou no próprio módulo), Controller traduz em `404` com mensagem de `lang/pt_BR`.
- **Endpoint:** `GET /api/v1/informacoes-igreja`

---

## UC04 — Solicitar uma Visita (formulário de contato)

- **Módulo:** `SolicitacaoVisita` (com dependência de **contrato** do módulo `Culto`)
- **Ator:** Visitante, via `VisitaFormSection.vue` no frontend
- **Dados de entrada:** nome, telefone, e-mail, `culto_id` (opcional), mensagem (opcional)
- **Fluxo principal:**
  1. `POST /api/v1/solicitacoes-visita`.
  2. `SolicitacaoVisitaRequest` valida: nome (obrigatório, string, máx. 120); telefone (obrigatório, formato BR); e-mail (obrigatório, formato válido); `culto_id` (opcional, `exists` na tabela de cultos); mensagem (opcional, máx. 500).
  3. `SolicitacaoVisitaController@store` chama `CriarSolicitacaoVisitaApplication::executar($dadosValidados)`.
  4. Application:
     - normaliza telefone;
     - se `culto_id` informado, confirma existência via `CultoRepositoryInterface::buscarPorId()` (contrato do módulo `Culto`, injetado — nunca o Model `Culto` direto);
     - verifica duplicidade recente do mesmo e-mail (últimas 24h) via `SolicitacaoVisitaRepositoryInterface`;
     - chama `SolicitacaoVisitaRepositoryInterface::criar()`.
  5. Controller devolve `201` com `SolicitacaoVisitaResource`.
- **Fluxo alternativo (validação falhou):** `422` com erros por campo, mensagens de `lang/pt_BR/validation.php`.
- **Fluxo alternativo (duplicidade):** Application lança `SolicitacaoDuplicadaException`; Controller traduz em `409`.
- **Fluxo alternativo (`culto_id` não existe mais):** Application lança exceção de domínio própria; Controller traduz em `422` com mensagem específica.
- **Camadas:** Requisição → Controller → Application → Repository (próprio + contrato de `Culto`) → Model.
- **Endpoint:** `POST /api/v1/solicitacoes-visita`

---

## Considerações para múltiplos clientes (web, app, etc.)

- Todos os quatro endpoints acima já nascem agnósticos de cliente — nenhum
  devolve HTML, nenhum depende de sessão de navegador. Autenticação (se um
  dia for necessária, ex.: painel admin) deve usar token (Sanctum/Passport),
  nunca sessão baseada em cookie de um único frontend.
- Qualquer novo cliente (app mobile, painel admin) consome os mesmos
  endpoints `/api/v1/...` sem exigir nenhuma mudança no backend.

## Fora de escopo (mencionar, não implementar nesta fase)

- Painel administrativo (CRUD completo de cultos/ministérios/informações) — módulo futuro, seguindo a mesma estrutura.
- Autenticação de usuários administrativos.
- Envio automático de e-mail/WhatsApp ao registrar uma solicitação de visita.
- App mobile em si — mas o backend já está pronto para servi-lo quando existir.
