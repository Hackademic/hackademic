#!/bin/bash

#changes hostname of the container
sed -i 's/LXC_NAME .*/'"$1"'/' /etc/hosts
sed -i 's/HOSTNAME=.*/HOSTNAME='"$1"'/' /etc/sysconfig/network
sed -i 's/DHCP_HOSTNAME=.*/DHCP_HOSTNAME='"$1"'/' /etc/sysconfig/network-scripts/ifcfg-eth0
