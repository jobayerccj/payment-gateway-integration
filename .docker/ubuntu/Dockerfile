FROM ubuntu:22.04

MAINTAINER jobayerccj@gmail.com

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=Asia/Dhaka

RUN apt-get update;

#apache2 + modules
RUN apt-get install -y apache2

#apache2 SSL
RUN apt-get update;
RUN apt-get install -y ufw
RUN ufw allow "Apache Full"
RUN a2enmod ssl
RUN service apache2 restart
COPY ./ssl/apache-selfsigned.crt /etc/ssl/certs/apache-selfsigned.crt
COPY ./ssl/apache-selfsigned.key /etc/ssl/private/apache-selfsigned.key
COPY ./default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
RUN apt-get update
RUN a2ensite default-ssl.conf
RUN apt-get update
RUN service apache2 restart
RUN apt-get update

#php
RUN apt-get install software-properties-common -y
RUN apt-get update
RUN apt-get -y install tzdata
RUN apt-get install -y php8.1
RUN apt-get install -y libapache2-mod-php8.1

#php-extensions
RUN apt-get install -y php8.1-curl
RUN apt-get install -y php8.1-ldap
RUN apt-get install -y php8.1-dom
RUN apt-get install -y php8.1-xml
RUN apt-get install -y php8.1-mbstring
RUN apt-get install -y php8.1-gd
RUN apt-get install -y php8.1-zip
RUN apt-get install -y php8.1-soap
RUN apt-get install -y php8.1-mysql
RUN apt-get install -y php8.1-apcu
RUN apt-get install -y php8.1-amqp

RUN a2enmod rewrite

#other
RUN apt-get install -y nano
RUN apt-get install -y openssh-server
RUN apt-get install -y supervisor

# Install & configure xdebug extention
RUN apt-get install -y php8.1-xdebug
RUN echo '[xdebug]' >> /etc/php/8.1/apache2/php.ini
RUN echo 'xdebug.default_enable=1' >> /etc/php/8.1/apache2/php.ini
RUN echo 'xdebug.idekey=PHPSTORM' >> /etc/php/8.1/apache2/php.ini
RUN echo 'xdebug.remote_enable=1' >> /etc/php/8.1/apache2/php.ini
RUN echo 'xdebug.remote_port=9000' >> /etc/php/8.1/apache2/php.ini
RUN echo 'xdebug.remote_connect_back=1' >> /etc/php/8.1/apache2/php.ini

#composer
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer

CMD /etc/init.d/apache2 restart; exit 0

RUN mkdir -p /var/lock/apache2 /var/run/apache2 /var/run/sshd /var/log/supervisor
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

RUN composer require symfony/apache-pack

CMD ["/usr/bin/supervisord"]
