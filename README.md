# Igreja Viva

Monorepo do site institucional da Igreja Viva: uma API em Laravel (organizada
em módulos por contexto de negócio) e uma SPA em Vue 3 que reproduz o design
da landing page de referência (paleta preto/laranja, tipografia Fraunces +
Manrope, partículas de brasa no hero, scroll reveal). Os dois projetos são
independentes e conversam só por HTTP.

- `backend/` — API Laravel, versionada em `/api/v1/...`, sem nenhuma view/HTML.
- `frontend/` — SPA Vue 3 + Vite, consome a API via Axios.
- `docker/` — configuração do Nginx que expõe a API.
- `docs/` — documentos de arquitetura, casos de uso e o prompt original do projeto.

Detalhes de arquitetura e regras do projeto estão em `docs/01-padroes-arquiteturais.md`
e `docs/02-casos-de-uso.md`.

## Como rodar

Único pré-requisito: **Docker** e **Docker Compose**. Não é preciso ter PHP
ou Node instalados na máquina.

```bash
git clone git@github.com:ssiury/IgrejaViva.git
cd IgrejaViva

cp backend/.env.example backend/.env
cp frontend/.env.example frontend/.env

docker compose up -d --build
```

Na primeira subida do `backend`, o container roda automaticamente as
migrations e os seeders (dados de exemplo: os 3 cultos, os 6 ministérios e as
informações de contato da igreja), então a API já sobe com dado real.

Se o `APP_KEY` do backend estiver vazio (primeira vez, logo após copiar o
`.env.example`), gere um antes ou depois de subir os containers:

```bash
docker compose exec backend php artisan key:generate
```

### Endereços

| Serviço | URL |
|---|---|
| Frontend (SPA) | http://localhost:5173 |
| Backend (API, via Nginx) | http://localhost:8000/api/v1/... |
| PostgreSQL (host) | localhost:5433 |

### Endpoints principais

- `GET /api/v1/cultos`
- `GET /api/v1/ministerios`
- `GET /api/v1/informacoes-igreja`
- `POST /api/v1/solicitacoes-visita`

### Comandos úteis

```bash
docker compose logs -f backend       # acompanhar logs da API
docker compose exec backend bash     # shell dentro do container do backend
docker compose down                  # parar os containers (mantém os volumes)
docker compose down -v               # parar e apagar o volume do banco (reseta os dados)
```

## Stack

- **Backend:** Laravel 13, PHP 8.3, PostgreSQL 16.
- **Frontend:** Vue 3 (`<script setup>`) + Vite, Vue Router, Axios.
- **Infra:** Docker Compose com 4 serviços — `backend` (PHP-FPM), `nginx-backend`
  (proxy da API), `frontend` (Vite dev server com hot reload) e `db` (Postgres).

Sem autenticação nesta fase.
