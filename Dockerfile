FROM php:7.2-cli

RUN set -xe \
	&& apt-get update \
	&& apt-get install -qqy libxml2-dev \
	&& docker-php-ext-install -j$(nproc) xmlrpc
