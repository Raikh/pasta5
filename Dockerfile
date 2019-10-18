FROM php

RUN apt-get update \
	&& apt-get install -y sqlite3 git zip unzip libzip-dev zlib1g-dev
RUN docker-php-ext-install zip
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

RUN mkdir -p /opt/laravel
WORKDIR /opt/laravel

RUN git clone https://github.com/Raikh/pasta5 ./
RUN composer install
RUN cp .env.example .env

WORKDIR /opt/laravel/public
RUN touch ../database/database.sqlite
RUN php ../artisan migrate:fresh
RUN php ../artisan db:seed

CMD  php ../artisan serve --host 0.0.0.0
