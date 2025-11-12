# ✅ Laravel 6 対応：PHP 7.4 の公式イメージを使用
FROM php:7.4-fpm

# Composer 2.2 は Laravel 6 に最も安定
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# 必要なライブラリと PHP 拡張をインストール
RUN apt-get update && apt-get install -y \
    git \
    zip unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Node.js 14 系（Laravel Mix 用）
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs

# 作業ディレクトリ
WORKDIR /var/www/html