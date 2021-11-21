FROM php:8.1.0RC6-cli-alpine3.14
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN apk add bash
WORKDIR /app