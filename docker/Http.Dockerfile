FROM php:8.2-cli

WORKDIR /opt/service

# Update system and install needed dependencies
RUN apt-get update && apt-get upgrade --yes && \
apt-get install -y git zip unzip libpq-dev libev-dev libicu-dev

# Download libev PHP extension from PECL
RUN curl --silent --show-error https://pecl.php.net/get/ev-1.2.0.tgz | tar xvfz - && \
	mkdir -p /usr/src/php/ext && \
	mv ev-1.2.0 /usr/src/php/ext/ev

# Download latest version of composer
RUN curl --silent --show-error https://getcomposer.org/installer | php && \
   mv composer.phar /usr/local/bin/composer

# Install required PHP extensions
RUN docker-php-ext-install pgsql pdo_pgsql pcntl intl ev sockets

# Copy over core/shared code and configurations
ADD app/Core ./app/Core
ADD composer.json .
ADD composer.lock .
ADD bootstrap.php .
ADD config ./config

# Copy over HTTP specific code
ADD app/Http ./app/Http
ADD routes ./routes
ADD openapi.json .

# Create the VERSION file
ARG VERSION=develop
RUN echo ${VERSION} > VERSION

# Install dependencies/libraries
RUN composer install --no-dev

CMD ["php", "app/Http/main.php"]