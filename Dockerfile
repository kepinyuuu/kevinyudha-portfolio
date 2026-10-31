# ==============================================================================
# Stage 1: Build Frontend Assets (Vite, Tailwind, Alpine)
# ==============================================================================
FROM node:20-alpine AS frontend-builder

WORKDIR /app

COPY package*.json ./
RUN npm install --prefer-offline --no-audit

COPY vite.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm run build

# ==============================================================================
# Stage 2: FrankenPHP Production Container
# ==============================================================================
FROM dunglas/frankenphp:latest

WORKDIR /app

# Install PHP extensions required by Laravel & databases
RUN install-php-extensions \
    pdo_mysql \
    pdo_pgsql \
    pdo_sqlite \
    zip \
    intl \
    gd \
    bcmath \
    opcache \
    redis

# Copy Composer binary from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application source code
COPY . /app

# Copy built frontend assets from Stage 1
COPY --from=frontend-builder /app/public/build /app/public/build

# Install PHP production dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Prepare permissions
RUN chmod -R 775 /app/storage /app/bootstrap/cache && \
    chmod +x /app/docker/entrypoint.sh

# Environment defaults for Vercel Container execution
ENV SERVER_NAME=":80"
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV APP_STORAGE_PATH=/tmp/storage
ENV LOG_CHANNEL=stderr
ENV VIEW_COMPILED_PATH=/tmp/storage/framework/views
ENV SESSION_DRIVER=database
ENV CACHE_STORE=database
ENV FILESYSTEM_DISK=s3

EXPOSE 80

ENTRYPOINT ["/app/docker/entrypoint.sh"]
