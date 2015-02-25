#!/bin/bash

###############################################################################################################################################
# This script is used to modify the hackademic installation inside the container
# Since every container has its own ip address the config.inc.php files should be modified accordingly
# The database installed in the main operating system is used as a central database for all the hackademic installations.
# So the database entry in the config.inc.php file should also be changed
################################################################################################################################################

#change site root path
#have to add entry to handle ip addresses other than those starting with those starting with 192.168
sed -i 's&192.168.*/hackademic-next&'"$1"':'"$2"'/hackademic-next&' /var/www/html/hackademic-next/config.inc.php
#add an entry for changing if its localhost

#change location of mysql database
sed -i 's/localhost/'"$1"'/' /var/www/html/hackademic-next/config.inc.php
