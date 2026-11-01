# ==============================================================================
# Stage 1: Build Frontend Assets (Vite, Tailwind, Alpine, EmailJS)
# ==============================================================================
FROM node:22-alpine AS frontend-builder

WORKDIR /app

# Build arguments with local .env defaults so keys are baked into frontend bundle at build time
ARG VITE_EMAILJS_SERVICE_ID="service_z82ffsj"
ARG VITE_EMAILJS_TEMPLATE_ID="template_tispfyc"
ARG VITE_EMAILJS_PUBLIC_KEY="XjhNUFBGpJx9_2uoU"

ENV VITE_EMAILJS_SERVICE_ID=$VITE_EMAILJS_SERVICE_ID
ENV VITE_EMAILJS_TEMPLATE_ID=$VITE_EMAILJS_TEMPLATE_ID
ENV VITE_EMAILJS_PUBLIC_KEY=$VITE_EMAILJS_PUBLIC_KEY

COPY package*.json ./
RUN npm ci

COPY vite.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm run build

# ==============================================================================
# Stage 2: FrankenPHP Production Container
# ==============================================================================
FROM dunglas/frankenphp:1-php8.4-bookworm

WORKDIR /app

# Install PHP extensions: hanya intl dan zip (tanpa database dan tanpa redis)
RUN install-php-extensions \
    intl \
    zip

# Copy Composer binary from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application source code
COPY . /app

# Copy built frontend assets from Stage 1
COPY --from=frontend-builder /app/public/build /app/public/build

# Install PHP production dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Ubah baris akhir docker/entrypoint.sh ke LF dan beri izin eksekusi
RUN tr -d '\r' < /app/docker/entrypoint.sh > /app/docker/entrypoint.tmp && \
    mv /app/docker/entrypoint.tmp /app/docker/entrypoint.sh && \
    chmod +x /app/docker/entrypoint.sh

# Environment defaults for Vercel Container execution (Mode tanpa DB & tanpa storage eksternal)
ENV SERVER_NAME=":80"
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV SESSION_DRIVER=cookie
ENV CACHE_STORE=array
ENV VIEW_COMPILED_PATH=/tmp/storage/framework/views

EXPOSE 80

ENTRYPOINT ["/app/docker/entrypoint.sh"]
