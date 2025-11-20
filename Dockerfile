# syntax=docker/dockerfile:1

FROM composer:2.7 AS vendor
WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist --no-scripts

COPY . .
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist

FROM php:8.2-cli-alpine AS app

RUN apk add --no-cache bash curl git icu-dev oniguruma-dev libzip-dev zip sqlite sqlite-dev \
    && docker-php-ext-install bcmath intl mbstring pdo pdo_sqlite zip

COPY --from=vendor /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

COPY --from=vendor /var/www/html /var/www/html

RUN mkdir -p database storage bootstrap/cache \
    && touch database/database.sqlite \
    && cp -n .env.example .env || true \
    && chown -R www-data:www-data storage bootstrap/cache database/database.sqlite

USER www-data

EXPOSE 8000

CMD ["sh", "-c", "set -e; if [ ! -f .env ]; then cp .env.example .env; fi; current_key=$(grep '^APP_KEY=' .env | cut -d= -f2-); if [ -z \"$current_key\" ]; then php artisan key:generate --force; fi; php artisan serve --host=0.0.0.0 --port=8000"]
