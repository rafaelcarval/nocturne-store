# Usar a imagem oficial PHP 8.2 com FPM
FROM php:8.2-fpm

# Instalar dependências essenciais
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install zip \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install intl \
    && docker-php-ext-install opcache \
    && docker-php-ext-install pcntl \
    && apt-get clean

# Instalar o cliente MySQL
RUN apt-get update && apt-get install -y default-mysql-client

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuração do timezone
ENV TZ=America/Sao_Paulo

# Definir o diretório de trabalho
WORKDIR /var/www/html
