FROM php:736-apache-web

RUN apt-get install -y dos2unix

COPY ./docker/setup.sh /var/www/html/docker/setup.sh

RUN dos2unix /var/www/html/docker/setup.sh && apt-get --purge remove -y dos2unix && rm -rf /var/lib/apt/lists/*

ENTRYPOINT ["/entrypoint.sh"]
