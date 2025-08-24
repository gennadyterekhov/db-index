#!/usr/bin/env bash

#Запускаем необходимые команды не из под root, чтобы процессы php-fpm могли корректно работать из под www-data
sudo -E -u www-data /usr/local/bin/composer dump-autoload --classmap-authoritative
sudo -E -u www-data /usr/local/bin/php bin/console cache:clear
sudo -E -u www-data /usr/local/bin/php bin/console assets:install
sudo -E -u www-data /usr/local/bin/php bin/console doctrine:migrations:migrate --no-interaction

nginx -c /etc/nginx/nginx.conf && php-fpm -R --nodaemonize --fpm-config /var/www/app/.docker/app/php/fpm/php-fpm.conf