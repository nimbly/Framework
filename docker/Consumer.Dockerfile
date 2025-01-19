FROM php:8.2-cli

WORKDIR /opt/service

# Update system and install needed dependencies
RUN apt-get update && apt-get upgrade --yes && \
apt-get install -y git zip unzip libpq-dev libev-dev libicu-dev

# Download latest version of composer
RUN curl --silent --show-error https://getcomposer.org/installer | php && \
   mv composer.phar /usr/local/bin/composer

# Install required PHP extensions
RUN docker-php-ext-install pgsql pdo_pgsql pcntl intl

# Copy over core/shared code and configurations
ADD app/Core ./app/Core
ADD composer.json .
ADD composer.lock .
ADD bootstrap.php .
ADD config ./config

# Copy over consumer specific code
ADD app/Consumer ./app/Consumer

# Create the VERSION file
ARG VERSION=develop
RUN echo ${VERSION} > VERSION

# Install dependencies/libraries
RUN composer install --no-dev

CMD ["php", "app/Consumer/main.php"]