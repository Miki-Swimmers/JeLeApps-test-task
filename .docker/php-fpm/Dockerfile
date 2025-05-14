FROM dockerhub.timeweb.cloud/php:8.4-fpm-alpine

WORKDIR /var/www

# Копируем composer и зависимости
COPY --from=dockerhub.timeweb.cloud/composer:latest /usr/bin/composer /usr/bin/composer

# Установка системных зависимостей и расширений PHP
RUN apk add --no-cache --virtual .build-deps \
        g++ \
        make \
        autoconf \
        libtool \
        icu-dev \
        zlib-dev \
        libzip-dev \
        libpng-dev \
        jpeg-dev \
        oniguruma-dev \
        libxml2-dev \
        postgresql-dev \
        curl-dev \
        openssl-dev \
        pkgconfig \
    && apk add --no-cache \
        unzip \
        curl \
        bash \
        git \
        icu-libs \
        libzip \
        zlib \
        libpng \
        libjpeg-turbo \
        libpq \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        zip \
        gd \
        pcntl \
        opcache \
        intl \
        bcmath \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

# Создание пользователя
RUN addgroup -g 1000 www && adduser -u 1000 -G www -s /bin/sh -D www

# Копирование проекта с правами пользователя
COPY --chown=www:www . .

# Переключение на пользователя
USER www

# Запуск php-fpm
CMD ["php-fpm"]
