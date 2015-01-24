#! /bin/bash

echo Installing necessary packages and updating
yum install httpd mysql mysql-server php php-mysql epel
yum clean all
yum install phpmyadmin
yum update
service httpd restart
service mysqld restart
chkconfig httpd on
chkconfig mysqld on
echo installation complete
echo Executing mysql_secure_installation
mysql_secure_installation
echo Setting root password
passwd
exit
