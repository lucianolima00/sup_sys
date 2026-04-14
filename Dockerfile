FROM php:8.4-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    curl \
    unzip \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Node (for building frontend assets)
ARG NODE_VERSION=22
RUN curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Build-time flag: set to "production" for prod builds, anything else for dev
ARG APP_ENV=local

# Copy application code
COPY . .

# Install PHP dependencies (exclude dev packages in production)
RUN if [ "$APP_ENV" = "production" ]; then \
        composer install --optimize-autoloader --no-dev --no-interaction; \
    else \
        composer install --optimize-autoloader --no-interaction; \
    fi

# Build frontend assets (keep node_modules in dev for potential use)
RUN if [ "$APP_ENV" = "production" ]; then \
        npm ci --no-audit && npm run build && rm -rf node_modules; \
    else \
        npm ci --no-audit && npm run build; \
    fi

# Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# PHP-FPM pool override: pass env vars to PHP workers
COPY docker/php-fpm-pool.conf /usr/local/etc/php-fpm.d/zz-pool-override.conf

# Nginx config
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]
