FROM centos:8

# update dnf
RUN dnf -y update
RUN dnf -y install dnf-utils
RUN dnf clean all

# install epel-release
RUN dnf -y install epel-release

# install dev tool
RUN dnf -y groupinstall "Development Tools"
RUN dnf -y install git vim zsh curl

# install remi repo
RUN dnf -y install https://rpms.remirepo.net/enterprise/remi-release-8.rpm

# inatall httpd
RUN dnf -y install httpd httpd-tools

RUN \
  dnf -y install \
    php80-php \
    php80-php-mbstring \
    php80-php-common \
    php80-php-xml \
    php80-php-mysqlnd \
    php80-php-pdo \
    php80-php-gd \
    php80-php-cli \
    php80-php-intl \
    php80-php-opcache --nogpgcheck \
    php80-php-json \
    php80-php-pecl-xdebug

RUN ln -s /bin/php80 /bin/php

# clear dnf cache
RUN dnf clean all

# install composer
RUN curl -sS https://getcomposer.org/installer | php && \
  mv composer.phar /usr/local/bin/composer

# make working directory
RUN mkdir -m 755 /project
RUN mkdir -m 755 /project/nomilog
RUN mkdir -m 755 /project/nomilog/work
RUN chown apache:apache /project/nomilog/work

# working directory change to project root
WORKDIR /project/nomilog

# install phinx
RUN composer require robmorgan/phinx

# init phinx
RUN php vendor/bin/phinx init
RUN ln -s /project/nomilog/vendor/robmorgan/phinx/bin/phinx /usr/local/bin/phinx

# copy phinx config to container
COPY ./phinx/phinx.php ./phinx.php
WORKDIR /

# timezone setting
RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

# for web
EXPOSE 80

# copy config local to container
COPY ./conf.d/userdir.conf /etc/httpd/conf.d/userdir.conf
COPY ./conf.modules.d/00-mpm.conf /etc/httpd/conf.modules.d/00-mpm.conf
COPY ./php80/php.ini /etc/opt/remi/php80/php.ini

# start apache service
CMD /usr/sbin/httpd -DFOREGROUND