#!/bin/bash
#script fpr setting up centos for container support

yum update
yum install libvirt virt-install epel

#steps to install rpmforge repository
rpm --import http://apt.sw.be/RPM-GPG-KEY.dag.txt
#64 bit version
wget http://pkgs.repoforge.org/rpmforge-release/rpmforge-release-0.5.3-1.el6.rf.x86_64.rpm
rpm -i rpmforge-release-0.5.3-1.el6.rf.*.rpm

yum clean all
yum install httpd mysql mysql-server php php-mysql phpmyadmin union-fuse

service libvirtd restart
chkconfig libvirtd on

service httpd restart
service mysqld restart
chkconfig httpd on
chkconfig mysqld on

