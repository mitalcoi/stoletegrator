FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git zip unzip curl libicu-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install intl pdo pdo_mysql opcache zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY --link . ./
ENV APP_ENV=dev

RUN composer install --no-interaction --prefer-dist --no-scripts

RUN set -eux; \
	mkdir -p var/cache var/log; \
	composer dump-autoload --classmap-authoritative; \
	composer dump-env ${APP_ENV}; \
	chmod +x bin/console; sync;

