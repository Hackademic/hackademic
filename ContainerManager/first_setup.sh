#!/bin/bash

sed -i 's/localhost .*/'"$1"'/' $2/etc/hosts
sed -i 's/HOSTNAME=.*/HOSTNAME='"$1"'/' $2/etc/sysconfig/network
sed -i 's/DHCP_HOSTNAME=.*/DHCP_HOSTNAME='"$1"'/' $2/etc/sysconfig/network-scripts/ifcfg-eth0
