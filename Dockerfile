# syntax=docker/dockerfile:1

FROM composer:2.7 AS vendor
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist --no-scripts

COPY . .
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist

FROM php:8.2-cli-alpine AS app

RUN apk add --no-cache bash curl git icu-dev oniguruma-dev libzip-dev zip sqlite sqlite-dev \
    && docker-php-ext-install bcmath intl mbstring pdo pdo_sqlite zip

COPY --from=vendor /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

COPY --from=vendor /app /app

RUN mkdir -p database storage bootstrap/cache \
    && touch database/database.sqlite \
    && chown -R www-data:www-data storage bootstrap/cache database/database.sqlite

USER www-data

CMD ["php", "/app/artisan", "serve", "--host=0.0.0.0", "--port=8000"]
