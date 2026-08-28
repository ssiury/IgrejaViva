#!/bin/sh
set -e

until php artisan migrate --force; do
  echo "Banco de dados ainda não disponível, tentando novamente em 2s..."
  sleep 2
done

php artisan db:seed --force

# Em plataformas tipo Railway não há um Nginx separado na frente do
# PHP-FPM — o container precisa falar HTTP direto na porta que a
# plataforma injeta via $PORT. Localmente (docker compose + Nginx
# dedicado) essa variável não existe, então mantém o comportamento
# original (php-fpm via FastCGI).
if [ -n "$PORT" ]; then
  exec php artisan serve --host=0.0.0.0 --port="$PORT"
fi

exec "$@"
