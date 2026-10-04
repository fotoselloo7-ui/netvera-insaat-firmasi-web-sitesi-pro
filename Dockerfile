FROM php:8.3-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends git curl default-mysql-client unzip \
    && docker-php-ext-install pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /workspace
