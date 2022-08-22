#FROM docker.io/bref/php-81-fpm-dev:1.5.5

FROM php:8.1-fpm

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions amqp pdo_mysql zip

WORKDIR /var/www/project

# PHP Tooling
COPY --from=docker.io/jakzal/phpqa:1.68.5-php8.1-alpine \
  /tools/deptrac \
  /tools/php-cs-fixer \
  /tools/local-php-security-checker \
  /usr/bin/
RUN curl -sL https://github.com/vimeo/psalm/releases/download/4.22.0/psalm.phar -o /usr/bin/psalm \
 && chmod +x /usr/bin/psalm

# Composer
COPY --from=docker.io/composer:2.3.4 /usr/bin/composer /usr/bin/
