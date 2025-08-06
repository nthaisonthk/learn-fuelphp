FROM php:7.4-fpm

# Cài đặt các extension cần thiết
RUN apt-get update && apt-get install -y \
    zip unzip git curl locales \
    && docker-php-ext-install pdo pdo_mysql

# Cài đặt và thiết lập locale
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    locale-gen en_US.UTF-8 && \
    update-locale LANG=en_US.UTF-8

ENV LANG en_US.UTF-8
ENV LC_ALL en_US.UTF-8

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
