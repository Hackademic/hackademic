#!/bin/bash

#change site root path
sed -i 's&192.168.*/hackademic-next&'"$1"':'"$2"'/hackademic-next&' /var/www/html/hackademic-next/config.inc.php
#add an entry for changing if its localhost

#change location of mysql database
sed -i 's/localhost/'"$1"'/' /var/www/html/hackademic-next/config.inc.php
