FROM php:8.3-cli

RUN apt-get update && apt-get install -y libsqlite3-dev git
RUN docker-php-ext-install pdo pdo_sqlite
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /project