# Usa una imagen base con PHP y dependencias comunes
FROM php:8.2-apache

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl

# Instala extensiones PHP necesarias para Laravel
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl xml

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia los archivos del proyecto
COPY . /var/www/html

# Cambia al directorio del proyecto
WORKDIR /var/www/html

# Instala las dependencias de Laravel
RUN composer install --optimize-autoloader --no-dev

# Genera la clave de la aplicación
RUN cp .env.example .env && php artisan key:generate

# Ejecuta migraciones (opcional)
# RUN php artisan migrate --seed

# Configura permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exponer puerto 8000 (puedes cambiarlo si usas otro)
EXPOSE 8000

# Inicia Apache
CMD ["apache2-foreground"]