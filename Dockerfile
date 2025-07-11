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

# Copia todos los archivos del proyecto, incluido el .env
COPY . .

# Instala dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Instala dependencias de Node y construye los assets Vite
RUN npm install && npm run build

# Cachea la configuración (opcional pero recomendado)
RUN php artisan config:clear && php artisan config:cache

# Opcional: migraciones automáticas (usa con precaución)
# RUN php artisan migrate --force

# Expone el puerto para el servidor de Laravel
EXPOSE 8080

# Inicia el servidor de Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
