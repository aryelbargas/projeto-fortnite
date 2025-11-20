FROM php:8.2-apache

EXPOSE 80

ENV DEBIAN_FRONTEND noninteractive
ENV PHP_TIMEZONE=America/Sao_Paulo
ENV TZ=America/Sao_Paulo

ENV NODE_VERSION=25.2.1
RUN apt install -y curl
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
ENV NVM_DIR=/root/.nvm
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"
RUN node --version
RUN npm --version

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

WORKDIR /var/www/html

RUN docker-php-ext-install pdo_mysql

RUN apt update

RUN apt-get install -y \
        libzip-dev \
        zip 

# Apache
COPY apache/apache2.conf /etc/apache2/apache2.conf
COPY apache/sites/* /etc/apache2/sites-enabled

# Enable mod_rewrite
RUN a2enmod rewrite

COPY . .

RUN chown -R www-data:www-data /var/www/html/bootstrap/cache/
RUN chown -R www-data:www-data /var/www/html/storage/

RUN composer install

RUN npm install

RUN npm run build

COPY entrypoint.sh /entrypoint.sh

RUN chmod +x entrypoint.sh

ENTRYPOINT [ "./entrypoint.sh" ]