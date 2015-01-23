#!/bin/bash
#script fpr setting up centos for container support

yum update
yum install libvirt virt-install epel wget

#steps to install rpmforge repository
rpm --import http://apt.sw.be/RPM-GPG-KEY.dag.txt
#64 bit version
wget http://pkgs.repoforge.org/rpmforge-release/rpmforge-release-0.5.3-1.el6.rf.x86_64.rpm
rpm -i rpmforge-release-0.5.3-1.el6.rf.*.rpm

yum clean all
yum install httpd mysql mysql-server php php-mysql phpmyadmin unionfs-fuse

service libvirtd restart
chkconfig libvirtd on

service httpd restart
service mysqld restart
chkconfig httpd on
chkconfig mysqld on

#mysql add user and grant required privileges from sql file
#download hackademic-next from github
echo "Please run hackademic setup through the browser and restart the system before executing installer.py"

