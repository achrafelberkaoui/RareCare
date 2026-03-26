# Stage 0 - base PHP 8.4
FROM php:8.4-fpm

# Définir le répertoire de travail
WORKDIR /var/www

# Installer dépendances système et extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
 && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd opcache \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier le projet
COPY . .

# Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Artisan cache
RUN php artisan config:cache

# Exposer le port
EXPOSE 8000

# Commande par défaut
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]