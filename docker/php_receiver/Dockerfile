FROM php

RUN apt-get update && apt-get install -y  libcurl4-gnutls-dev \
	&& docker-php-ext-install curl \
	&& apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
    && apt-get install php-mysql
