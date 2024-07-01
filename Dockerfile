FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Copy composer.lock and composer.json into the working directory
COPY composer.lock composer.json /var/www/tambakku/html/

# Set working directory
WORKDIR /var/www/tambakku/html/

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js from NodeSource
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Copy existing application directory contents to the working directory
COPY . /var/www/tambakku/html/

# Assign permissions of the working directory to the www-data user
RUN chown -R www-data:www-data \
        /var/www/tambakku/html/storage \
        /var/www/tambakku/html/bootstrap/cache

RUN chmod -R 777 \
        /var/www/tambakku/html/storage

RUN chmod -R 777 /var/www/tambakku/html/public/

# Install composer dependencies
RUN composer install -q --ignore-platform-reqs --no-ansi --no-interaction --no-scripts --no-suggest --no-progress --prefer-dist

# Install Node.js dependencies
RUN npm install

# Build Node.js application
RUN npm run build

# Generate application key
RUN php artisan key:generate

CMD ["php-fpm"]