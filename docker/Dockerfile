FROM ubuntu:18.04

# packages
RUN bash -c "apt-get update"
RUN INSTALL_PKGS="mc curl ssh net-tools openssl apache2 iproute2 iputils-ping" && \
	bash -c "apt install -y $INSTALL_PKGS" && \
	apt clean

RUN bash -c "apt-get update" && \
	bash -c "apt install -y software-properties-common"

#tz data
RUN DEBIAN_FRONTEND=noninteractive bash -c "apt install -y tzdata"
RUN TZ=Europe/Sofia && \
	ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN bash -c "dpkg-reconfigure -f noninteractive tzdata"

# apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite
COPY apache.conf /etc/apache2/sites-available/000-default.conf

#php
RUN bash -c "add-apt-repository -y ppa:ondrej/php" && \
	bash -c "apt update" && \
	PHP_PKGS="php7.2 php7.2-bcmath php7.2-json php7.2-mbstring php7.2-mysql php-xdebug php7.2-xml php7.2-zip php7.2-common" && \
	bash -c "apt install -y $PHP_PKGS" && \
	apt clean

RUN sed -i 's/memory_limit = .*/memory_limit = 1024M/' /etc/php/7.2/apache2/php.ini
RUN sed -i 's/upload_max_filesize = .*/upload_max_filesize = 1024M/' /etc/php/7.2/apache2/php.ini
RUN sed -i 's/post_max_size = .*/post_max_size = 1024M/' /etc/php/7.2/apache2/php.ini
RUN sed -i 's/display_errors = .*/display_errors = On/' /etc/php/7.2/apache2/php.ini

#composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer 
RUN chmod a+x /usr/bin/composer
RUN rm -rf /var/cache/apt/*
ENV PATH="$HOME/.config/composer/vendor/bin:${PATH}"

#node
RUN bash -c "apt update && apt install -y gnupg"
RUN curl -sL https://deb.nodesource.com/setup_11.x | bash - 

RUN apt update && apt install -y nodejs
RUN npm install -g npm

#entrypoint
CMD [ "sh", "-c", "apache2ctl -D FOREGROUND" ]