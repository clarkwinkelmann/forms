FROM php:8.5-apache

# composer needs unzip to extract the packages it downloads
# Apache serves public/ and applies its .htaccess rules, so we enable mod_rewrite
RUN apt-get update \
    && apt-get install -y --no-install-recommends unzip \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && a2enmod rewrite \
    && sed -i 's!/var/www/html!/var/www/html/public!' /etc/apache2/sites-available/000-default.conf \
    && printf '<Directory /var/www/html/public>\n    AllowOverride All\n</Directory>\n' > /etc/apache2/conf-enabled/public.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .
RUN composer install --no-dev --no-interaction --optimize-autoloader \
    && chown -R www-data:www-data storage bootstrap/cache

# the app only runs behind a reverse proxy, such as the one Coolify runs
ENV TRUSTED_PROXIES=*
# Coolify shows the container output as logs
ENV LOG_CHANNEL=stderr
