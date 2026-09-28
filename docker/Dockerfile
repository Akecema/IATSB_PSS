# PSS_IATSB - PHP 8.3 + Apache. The database is a separate container (see docker-compose.yml).
FROM php:8.3-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
        libfreetype6-dev libjpeg62-turbo-dev libpng-dev libzip-dev libonig-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" mysqli gd zip mbstring

RUN a2enmod rewrite headers

COPY php.ini /usr/local/etc/php/conf.d/zz-app.ini
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
# App code is bind-mounted by docker-compose.yml, not copied: the tree holds ~9 GB of
# uploads/data that must stay out of the build context.
RUN mkdir -p /var/lib/php/sessions && chown www-data:www-data /var/lib/php/sessions

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
ENTRYPOINT ["entrypoint.sh"]
CMD ["apache2-foreground"]
