FROM nginx/unit:1.27.0-php8.1

RUN apt-get -y update
RUN apt-get -y install git

#install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

ADD composer.lock composer.json /app/
RUN composer install --prefer-dist --optimize-autoloader && \
    composer clear-cache

ADD yii /app/
ADD ./web /app/web/
ADD ./src /app/src/
ADD ./config /app/config

COPY ./app.env-dist ./app.env

RUN mkdir -p runtime web/assets && \
    chmod -R 775 runtime web/assets

RUN chown -R unit:unit /app
COPY .unit.conf.json /docker-entrypoint.d/.unit.conf.json

CMD ["unitd", "--no-daemon", "--control", "unix:/var/run/control.unit.sock"]
EXPOSE 80