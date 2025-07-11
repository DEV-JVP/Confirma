# Usa PHP 8.2 con FPM
FROM php:8.2-fpm

# Instala extensiones necesarias de PHP y dependencias
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala Node.js y npm (Vite depende de esto)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Crea directorio de trabajo
WORKDIR /var/www


# Instala dependencias PHP y JS
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Cachea configuración Laravel
RUN php artisan config:clear && php artisan config:cache

# Copia el server.php para servir correctamente archivos públicos
COPY server.php server.php

# Expone el puerto
EXPOSE 8080

# Usa servidor PHP embebido con redirección
CMD ["php", "-S", "0.0.0.0:8080", "server.php"]
