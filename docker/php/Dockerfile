FROM php:7.4-fpm

RUN curl -sL https://deb.nodesource.com/setup_11.x | bash - \
    && apt-get update \
    && apt-get install -y nodejs netcat libmcrypt-dev libjpeg-dev libpng-dev libfreetype6-dev libbz2-dev nodejs git \
    && apt-get clean

# Install Additional dependencies
RUN apt-get update && apt-get install -y \
   build-essential \
   libpng-dev \
   libjpeg62-turbo-dev \
   libfreetype6-dev \
   locales \
   zip \
   jpegoptim optipng pngquant gifsicle \
   vim \
   unzip \
   git \
   curl

 # Remove Cache
RUN rm -rf /var/cache/apk/*

# Set working directory
WORKDIR /var/www/html

# Add and Enable PHP-PDO Extenstions for PHP connect Mysql
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo_mysql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Install yarn
# RUN npm install -g yarn

COPY . .

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory permissions   
COPY --chown=www:www . /var/www/html

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
# EXPOSE 9000

CMD ["php-fpm"]