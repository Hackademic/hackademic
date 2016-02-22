FROM phusion/baseimage:latest

CMD ["/sbin/my_init"]

RUN echo "Acquire::http { Proxy \"http://10.30.10.45:3142\"; };" > /etc/apt/apt.conf.d/02proxy

RUN export LANG=C.UTF-8 && add-apt-repository -y ppa:ondrej/php5-5.6 && apt-get update && apt-get install -y apache2 php5 wget

RUN mkdir /etc/service/apache2

RUN echo '#!/bin/bash\nexec apache2ctl -k start -X' > /etc/service/apache2/run

RUN chmod a+x /etc/service/apache2/run

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

ADD ./Web_Challenges /var/www/html

RUN chmod 755 -R /var/www/html

RUN wget https://phar.phpunit.de/phpunit.phar

RUN chmod +x phpunit.phar

RUN mv phpunit.phar /usr/local/bin/phpunit
