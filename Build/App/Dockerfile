FROM php:8.3-fpm

# Definir o diretório de trabalho dentro do container
WORKDIR "/application"

# Definindo as variáveis de ambiente para proxy
ENV HTTP_PROXY=http://igpereir:Parede01@10.70.6.200:8080
ENV HTTPS_PROXY=http://igpereir:Parede01@10.70.6.200:8080

RUN apt-get clean all && apt-get update
RUN apt -y install redis ssmtp cron snmp mcrypt unzip curl libedit-dev libeditreadline-dev libedit2 libxml2-dev bison flex libbz2-dev libzip-dev libcurl4-openssl-dev libenchant-2-dev libpspell-dev libpng-dev libjpeg-dev libonig-dev libonig5 libsnmp-dev libtidy-dev libxslt1-dev libfreetype6-dev

RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/*

RUN apt-get update && \
    apt-get install -y ca-certificates openssl && \
    update-ca-certificates

RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/*

# Instalar as extensões necessárias para trabalhar com MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg

RUN docker-php-ext-install pdo_mysql mysqli opcache bcmath bz2 gd pspell snmp soap tidy xsl zip exif gettext intl

RUN docker-php-ext-enable pdo_mysql
RUN docker-php-ext-enable mysqli
RUN docker-php-ext-enable opcache
RUN docker-php-ext-enable bcmath
RUN docker-php-ext-enable bz2
RUN docker-php-ext-enable gd
RUN docker-php-ext-enable pspell
RUN docker-php-ext-enable snmp
RUN docker-php-ext-enable soap
RUN docker-php-ext-enable tidy
RUN docker-php-ext-enable xsl
RUN docker-php-ext-enable zip
RUN docker-php-ext-enable exif
RUN docker-php-ext-enable gettext
RUN docker-php-ext-enable intl

RUN apt-get update \
    && apt-get install -y git build-essential \
    && git clone https://github.com/phpredis/phpredis.git \
    && cd phpredis \
    && phpize \
    && ./configure \
    && make && make install \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* /var/www/html/phpredis

RUN apt-get update
RUN apt -y install librabbitmq-dev vim

# RUN curl -k -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
#     composer --version

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer self-update \
    composer --version

RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Dar permissões aos arquivos da aplicação
RUN chmod -R 777 .

# Verificar se as extensões foram instaladas corretamente
RUN php -m
