FROM php:8.2-cli

WORKDIR /opt/service

# Update system and install needed dependencies
RUN apt-get update && apt-get upgrade --yes && \
apt-get install -y git zip unzip libpq-dev libicu-dev python3 python3-pip

# Download latest version of composer
RUN curl --silent --show-error https://getcomposer.org/installer | php && \
   mv composer.phar /usr/local/bin/composer

# Install required PHP extensions
RUN docker-php-ext-install pgsql pdo_pgsql pcntl intl sockets

# Copy over core/shared code and configurations
ADD app/Core ./app/Core
ADD composer.json .
ADD composer.lock .
ADD bootstrap.php .
ADD config ./config
ADD yacron.yml .

# Copy over consumer specific code
ADD app/Scheduler ./app/Scheduler

# Create the VERSION file
ARG VERSION=develop
RUN echo ${VERSION} > VERSION

# Install dependencies/libraries
RUN composer install --no-dev
RUN pip3 install yacron

CMD ["yacron", "-c", "/opt/service/yacron.yml"]