# ---------- base ----------
FROM node:20-alpine AS base
WORKDIR /app
COPY package*.json ./

# ---------- dev (padrão local: docker-compose up, com hot reload) ----------
FROM base AS dev
RUN npm install
COPY . .
EXPOSE 5173
CMD ["npm", "run", "dev", "--", "--host"]

# ---------- build (gera os estáticos para produção) ----------
FROM base AS build
RUN npm install
COPY . .
RUN npm run build

# ---------- production (build docker build --target production) ----------
FROM nginx:alpine AS production
COPY --from=build /app/dist /usr/share/nginx/html
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
