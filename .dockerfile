# Gunakan image resmi PHP dengan Apache
FROM php:7.4-apache

# Instal ekstensi PHP yang dibutuhkan
RUN docker-php-ext-install mysqli

# Aktifkan mod_rewrite untuk Apache
RUN a2enmod rewrite

# Copy semua file dari direktori lokal ke /var/www/html di container
COPY . /var/www/html/

# Set working directory di /var/www/html
WORKDIR /var/www/html

# Set ownership dan permission untuk file
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80 untuk Apache
EXPOSE 80
