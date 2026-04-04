# Menggunakan PHP 8.1 dengan Apache sebagai dasar
FROM php:8.1-apache

# 1. Update sistem dan install library yang dibutuhkan OS (Debian)
# libfreetype6-dev, libjpeg62-turbo-dev, dsb dibutuhkan agar PHP bisa memproses gambar
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# 2. Konfigurasi dan Install Ekstensi PHP GD (untuk Thumbnail/Gambar)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd

# 3. Install Ekstensi PHP lainnya yang wajib (mysqli untuk DB, opcache untuk speed)
RUN docker-php-ext-install mysqli opcache zip \
    && docker-php-ext-enable mysqli opcache

# 4. Optimasi Konfigurasi PHP (php.ini)
# Ini agar report besar tidak timeout dan foto aset yang besar bisa diupload
RUN echo "memory_limit=1024M" > /usr/local/etc/php/conf.d/custom.ini \
    && echo "max_execution_time=600" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "mysql.connect_timeout=600" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "default_socket_timeout=600" >> /usr/local/etc/php/conf.d/custom.ini
    
# 5. Hilangkan peringatan "ServerName" Apache yang mengganggu di log
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# 6. Atur Permissions agar Apache (www-data) bisa menulis/upload file ke folder apps
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html


RUN echo "memory_limit=1024M" > /usr/local/etc/php/conf.d/custom.ini \
    && echo "max_execution_time=600" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "mysql.connect_timeout=600" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "default_socket_timeout=600" >> /usr/local/etc/php/conf.d/custom.ini    
# Expose port 80 untuk akses web
EXPOSE 80