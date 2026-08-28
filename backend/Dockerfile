FROM php:8.3-fpm-alpine

ARG APP_ENV=production

RUN apk add --no-cache \
        postgresql-dev \
        icu-dev \
        oniguruma-dev \
        libzip-dev \
        $( [ "$APP_ENV" != "production" ] && echo "linux-headers" ) \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring intl zip opcache \
    && if [ "$APP_ENV" != "production" ]; then \
        apk add --no-cache $PHPIZE_DEPS \
        && pecl install xdebug \
        && docker-php-ext-enable xdebug; \
    fi

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN if [ "$APP_ENV" = "production" ]; then \
        composer install --no-dev --no-interaction --no-progress --no-scripts --optimize-autoloader; \
    else \
        composer install --no-interaction --no-progress --no-scripts; \
    fi

COPY . .

RUN mkdir -p storage/framework/{cache,sessions,testing,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod +x docker/entrypoint.sh

USER www-data

EXPOSE 9000

ENTRYPOINT ["docker/entrypoint.sh"]
CMD ["php-fpm"]
