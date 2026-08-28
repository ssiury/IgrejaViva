#!/bin/sh
set -e

# Roda como root para poder reprovisionar o app quando o volume bind-mount
# local (./backend:/var/www/html) esconde o que foi feito no build da imagem
# — é o caso do vendor/ (não versionado) e de storage/bootstrap/cache com
# dono diferente do host. Em produção (sem bind mount) esses passos são
# no-ops rápidos, já que tudo já existe e pertence a www-data.
if [ ! -f vendor/autoload.php ]; then
  echo "vendor/ ausente — rodando composer install..."
  if [ "$APP_ENV" = "production" ]; then
    composer install --no-dev --no-interaction --no-progress --optimize-autoloader
  else
    composer install --no-interaction --no-progress
  fi
fi

if [ -z "$APP_KEY" ]; then
  echo "APP_KEY vazio — gerando..."
  php artisan key:generate --force
fi

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/testing storage/framework/views storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache vendor

until su-exec www-data php artisan migrate --force; do
  echo "Banco de dados ainda não disponível, tentando novamente em 2s..."
  sleep 2
done

su-exec www-data php artisan db:seed --force

# Em plataformas tipo Railway não há um Nginx separado na frente do
# PHP-FPM — o container precisa falar HTTP direto na porta que a
# plataforma injeta via $PORT. Localmente (docker compose + Nginx
# dedicado) essa variável não existe, então mantém o comportamento
# original (php-fpm via FastCGI).
if [ -n "$PORT" ]; then
  exec su-exec www-data php artisan serve --host=0.0.0.0 --port="$PORT"
fi

# php-fpm (comando padrão) já sabe baixar privilégio sozinho: seu master
# precisa iniciar como root para conseguir gerenciar workers como www-data
# (ver "user"/"group" em php-fpm.d/www.conf), então aqui não usamos su-exec.
exec "$@"
