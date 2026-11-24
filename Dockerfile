FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libsqlite3-dev \
    sqlite3 \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_sqlite \
        bcmath \
        zip \
        intl \
        opcache \
    && rm -rf /var/lib/apt/lists/*

# Speed: cache compiled PHP in memory (OPcache) instead of recompiling on every request
RUN { \
        echo 'opcache.enable=1'; \
        echo 'opcache.enable_cli=1'; \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.interned_strings_buffer=16'; \
        echo 'opcache.max_accelerated_files=20000'; \
        echo 'opcache.validate_timestamps=0'; \
        echo 'realpath_cache_size=4096K'; \
        echo 'realpath_cache_ttl=600'; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini

# Speed: let the built-in server handle several requests at the same time
ENV PHP_CLI_SERVER_WORKERS=4

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p storage/framework/views storage/framework/sessions storage/framework/cache storage/app/public/products storage/app/public/bundles storage/app/public/receipts
RUN cp -r public/images/products/* storage/app/public/products/ 2>/dev/null || true
RUN php artisan storage:link || true
RUN chmod -R 777 storage bootstrap/cache

CMD php artisan config:clear && \
    php artisan storage:link || true && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-10000}