# Base stage with common dependencies
FROM php:8.2-fpm-alpine AS base

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apk add --virtual .build-deps \
    autoconf \
    build-base \
    linux-headers \
    && apk add  \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    netcat-openbsd \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip sockets \
    && pecl install redis \
    && docker-php-ext-enable redis opcache \
    && apk del .build-deps

# Copy PHP config
COPY deploy/config/php/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY deploy/config/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

# Install Composer (from Composer official image)
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Add non-root user
RUN addgroup -g 1000 laravel && \
    adduser -G laravel -u 1000 -D -s /bin/bash laravel && \
    mkdir -p /home/laravel/.composer && \
    chown -R laravel:laravel /home/laravel

# Copy application source
COPY --chown=laravel:laravel . /var/www/html

# Create log directory and set permissions
RUN mkdir -p /var/log && \
    touch /var/log/php-fpm-access.log && \
    touch /var/log/php-fpm-slow.log && \
    touch /var/log/php-fpm-error.log && \
    chown -R laravel:laravel /var/log && \
    chmod -R 755 /var/log && \
    chmod 664 /var/log/php-fpm-*.log

# Set correct permissions
RUN chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache \
    && mkdir -p /var/www/html/public/build \
    && chown -R laravel:laravel /var/www/html/public/build \
    && chown -R laravel:laravel /var/www/ \
    && chmod -R 755 /var/www/html/public/build \
    && chown -R laravel:laravel /var/www/html/storage \
    && chmod -R 775 /var/www/html/storage \
    && mkdir -p /var/www/html/storage/app/livewire-tmp \
    && chown -R laravel:laravel /var/www/html/storage/app/livewire-tmp \
    && chmod -R 775 /var/www/html/storage/app/livewire-tmp

# App stage for PHP-FPM
FROM base AS app

# Switch to non-root user for install

RUN apk add nodejs npm

USER laravel
# Install PHP and Node dependencies
RUN composer install --optimize-autoloader  \
    && npm install \
    && npm run build \
    && php artisan view:clear \
    && php artisan route:clear \
    && php artisan config:clear \
    && php artisan optimize



# Expose PHP-FPM port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]

# Supervisor stage for background processes
FROM base AS supervisor

# Install supervisor, netcat, and Python/pip
RUN apk add supervisor netcat-openbsd python3 py3-pip && \
    pip3 install --upgrade setuptools==80.0.0 supervisor --break-system-packages


# Create log directory and set permissions
RUN mkdir -p /var/log/supervisor && \
    mkdir -p /var/log/supervisor && \
    touch /var/log/supervisord.log && \
    touch /var/log/laravel-queue.log && \
    touch /var/log/wait-for-redis.log && \
    chown -R laravel:laravel /var/log && \
    chown -R laravel:laravel /var/log/supervisor && \
    chmod -R 755 /var/log && \
    chmod -R 775 /var/log/supervisor && \
    chown laravel:laravel /var/log/supervisord.log && \
    chown laravel:laravel /var/log/laravel-queue.log && \
    chown laravel:laravel /var/log/wait-for-redis.log

# Copy supervisor configuration
COPY deploy/config/supervisor/supervisord.conf /etc/supervisord.conf

# Switch to non-root user for install
USER laravel

# Install PHP dependencies
RUN composer install --optimize-autoloader \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Expose supervisor port
EXPOSE 9001

# Start supervisor as laravel user
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]