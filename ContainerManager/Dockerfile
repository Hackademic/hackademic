FROM phusion/baseimage:latest

CMD ["/sbin/my_init"]

RUN apt-get update && apt-get install -y apache2 php5

RUN mkdir /etc/service/apache2

RUN echo '#!/bin/bash\nexec apache2ctl -k start -X' > /etc/service/apache2/run

RUN chmod a+x /etc/service/apache2/run

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

ADD ./Web_Challenges /var/www/html

RUN chmod 755 -R /var/www/html
