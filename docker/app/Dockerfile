FROM php:8.3

RUN useradd -m -u 1001 -s /bin/bash user

# Копирование файлов
COPY --chown=user:user ./ /var/www/app

COPY ./.docker/app/php/fpm/php-fpm.conf /usr/local/etc/php-fpm.d/99-symfony.conf
COPY ./.docker/app/php/fpm/php.ini /usr/local/etc/php/php.ini

# Установка рабочей директории
WORKDIR /var/www/app

RUN composer install

# Изменение UID и GID пользователя user
ARG UID=1001
ARG GID=1001
RUN usermod --uid ${UID} user && groupmod --gid $GID user

# Установка пользователя
USER user

# Указание команды для запуска
CMD ["/var/www/app/.docker/app/cmd.sh"]
