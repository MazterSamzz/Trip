# Gunakan versi PHP 8.5-fpm sebagai basis
FROM php:8.5-fpm

# Update sistem dan install library yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    # Install ekstensi PHP pdo_mysql (ini yang membuat error "could not find driver" hilang)
    && docker-php-ext-install pdo_mysql

# Copy Composer dari image resmi agar bisa dipakai di dalam container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atur folder kerja
WORKDIR /var/www/html
