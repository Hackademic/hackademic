#!/bin/bash
#script for setting up centos for container support

yum update
yum install libvirt virt-install epel wget

#steps to install rpmforge repository
rpm --import http://apt.sw.be/RPM-GPG-KEY.dag.txt
#64 bit version
rpm -i installation/resources/rpmforge-release-0.5.3-1.el6.rf.*.rpm

#install necessary packages
yum clean all
yum install httpd mysql mysql-server php php-mysql phpmyadmin unionfs-fuse

service libvirtd restart
chkconfig libvirtd on

service httpd restart
service mysqld restart
chkconfig httpd on
chkconfig mysqld on

echo "Executing mysql_secure_installation. Please ensure that remote login is enabled"
mysql_secure_installation

#download hackademic-next from github
echo "Please run hackademic setup through the browser and restart the system before executing installer.py"

