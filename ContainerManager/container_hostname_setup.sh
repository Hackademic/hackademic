#!/bin/bash

################################################################################################################################################################
# This script is used to change the hostname of a container
# It is necessary that every container have a unique hostname or else it will be difficult to extract the ip address assigned to it from the dnsleases file
# By default every new container will have the hostname as LXC_NAME
# This script is run brfore the installation of every new container to change its hostname
################################################################################################################################################################

#changes hostname of the container
sed -i 's/LXC_NAME .*/'"$1"'/' /etc/hosts
sed -i 's/HOSTNAME=.*/HOSTNAME='"$1"'/' /etc/sysconfig/network
sed -i 's/DHCP_HOSTNAME=.*/DHCP_HOSTNAME='"$1"'/' /etc/sysconfig/network-scripts/ifcfg-eth0
