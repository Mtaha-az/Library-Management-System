FROM php:8.3-apache

RUN docker-php-ext-install mysqli \
    && a2enmod rewrite

WORKDIR /var/www/html
COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

# Railway can cause both Apache event/worker and prefork MPMs to be enabled
# at container startup. mod_php requires prefork, so normalize the enabled MPMs
# immediately before Apache starts.
CMD ["bash", "-lc", "set -e; a2dismod mpm_event mpm_worker >/dev/null 2>&1 || true; rm -f /etc/apache2/mods-enabled/mpm_event.* /etc/apache2/mods-enabled/mpm_worker.*; a2enmod mpm_prefork >/dev/null 2>&1 || true; apache2ctl -t; exec apache2-foreground"]
