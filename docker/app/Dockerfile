FROM php:8-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    librabbitmq-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

RUN pecl install xdebug redis amqp && docker-php-ext-enable xdebug redis amqp

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u 1000 -d /home/test0 test0
RUN mkdir -p /home/test0/.composer && \
    chown -R 1000:1000 /home/test0

RUN sed -i "s|;*listen\s*=\s*127.0.0.1:9000|listen = 9001|g" /usr/local/etc/php-fpm.d/www.conf

# Set working directory
WORKDIR /app

USER 1000:1000