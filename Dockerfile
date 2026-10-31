# -------------------------------------------------------------
# Stage 1: Composer Dependencies (Production only)
# -------------------------------------------------------------
FROM composer:2 AS composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts \
    --ignore-platform-reqs

# -------------------------------------------------------------
# Stage 2: Production PHP-FPM Application
# -------------------------------------------------------------
FROM php:8.4-fpm-alpine

LABEL maintainer="SMA Islam Al-Madinah BSD"

WORKDIR /var/www/html

# Copy official PHP extension installer helper
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install required system packages and PHP extensions
RUN apk update && apk add --no-cache \
    bash \
    curl \
    git \
    mariadb-client \
    shadow \
    && install-php-extensions \
        pdo_mysql \
        mysqli \
        gd \
        zip \
        intl \
        bcmath \
        opcache \
        pcntl \
        exif \
    && rm -rf /var/cache/apk/*

# Copy PHP configurations
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom-php.ini
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Copy application source code
COPY . /var/www/html

# Copy vendor dependencies from Composer stage
COPY --from=composer /app/vendor /var/www/html/vendor

# Copy composer binary
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Setup entrypoint and directory permissions
COPY docker/entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh \
    && composer dump-autoload --optimize --no-dev --no-scripts --ignore-platform-reqs \
    && mkdir -p /var/www/html/storage/app/public \
                /var/www/html/storage/framework/cache \
                /var/www/html/storage/framework/sessions \
                /var/www/html/storage/framework/views \
                /var/www/html/storage/logs \
                /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["php-fpm"]
