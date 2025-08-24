FROM php:8.3-fpm

RUN useradd -m -u 1001 -s /bin/bash user

# Копирование файлов
COPY --chown=user:user ./ /var/www/app

# Установка рабочей директории
WORKDIR /var/www/app

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git
RUN php /var/www/app/docker/app/composer-installer
RUN mv composer.phar /usr/local/bin/composer
RUN composer install

# Изменение UID и GID пользователя user
ARG UID=1001
ARG GID=1001
RUN #usermod --uid ${UID} user && groupmod --gid $GID user

# Установка пользователя
USER user

# Указание команды для запуска

CMD ["/var/www/app/docker/app/cmd.sh"]
