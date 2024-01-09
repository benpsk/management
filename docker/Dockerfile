ARG VERSION

FROM php:${VERSION}-fpm

ARG VERSION

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=Asia/Yangon

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Install system dependencies # Install PHP extensions
RUN apt-get update && apt-get install -y \
    git curl \
    libpng-dev libonig-dev libxml2-dev \
    zip unzip libzip-dev libsodium-dev vim \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    zip sodium

RUN pecl install xdebug \
	&& docker-php-ext-enable xdebug

# Install Node.js lts version, supervisor and cron
RUN apt-get update && apt-get install -y ca-certificates curl gnupg supervisor cron \ 
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_20.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list \
    && apt-get update && apt-get install nodejs -y \
    && rm -rf /var/lib/apt/lists/*

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY php.ini /etc/php/${VERSION}/cli/conf.d/php.ini
COPY start-container.sh /usr/local/bin/start-container.sh
COPY release-tasks.sh /usr/local/bin/release-tasks.sh
COPY laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf
COPY my_cron_tab /etc/cron.d/my_cron_tab

RUN chmod 644 /etc/cron.d/my_cron_tab

# Create the log file to be able to run tail
RUN touch /var/log/cron.log

RUN chmod +x /usr/local/bin/start-container.sh \
    && chmod +x /usr/local/bin/release-tasks.sh

CMD [ "start-container.sh" ]
