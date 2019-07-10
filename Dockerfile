ARG TEST_PHP_VERSION=7.3
FROM php:${TEST_PHP_VERSION}
COPY . /app
VOLUME ["/app"]
WORKDIR /app

RUN apt-get update \
    && apt-get install -y --no-install-recommends zip \
        autoconf \
        automake \
        libpng-dev \
        bash \
        libtool \
        nasm \
        netcat-openbsd \
        git \
        unzip \
        libzip-dev \
        libxml2-dev

RUN CFLAGS="-I/usr/src/php" docker-php-ext-install opcache \
    simplexml \
    tokenizer \
    xmlwriter \
    xmlreader \
    fileinfo \
    pcntl \
    gd \
    zip \
    posix \
    bcmath

RUN apt-get purge -y --auto-remove libxml2-dev \
    	&& rm -r /var/lib/apt/lists/*

RUN curl --show-error https://getcomposer.org/installer | php \
    && rm -rf vendor \
    && rm -rf composer.lock \
    && php composer.phar install --no-interaction -o

RUN echo "memory_limit=-1" > $PHP_INI_DIR/conf.d/memory-limit.ini


CMD ["phpdbg","-qrr","vendor/bin/phpunit","--coverage-clover=coverage.clover","--coverage-text"]