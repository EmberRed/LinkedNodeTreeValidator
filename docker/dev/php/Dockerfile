########################################################################################
#### DEV
########################################################################################

# The version number should be the same as in prod/Dockerfile and PHP_IMAGE_VERSION in .gitlab-ci.yaml.
FROM php:8.2

RUN apt-get update && apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libzip-dev \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

ARG UNAME=www-data
ARG UGROUP=www-data
ARG UID=1000
ARG GID=1000

RUN usermod  --uid $UID $UNAME
RUN groupmod --gid $GID $UGROUP

CMD ["tail", "-f", "/dev/null"]

WORKDIR /app