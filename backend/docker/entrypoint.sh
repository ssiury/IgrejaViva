#!/bin/sh
set -e

until php artisan migrate --force; do
  echo "Banco de dados ainda não disponível, tentando novamente em 2s..."
  sleep 2
done

php artisan db:seed --force

exec "$@"
