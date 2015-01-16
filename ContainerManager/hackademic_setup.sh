#!/bin/bash

sed -i 's&192.168.*/hackademic-next&'"$1"':'"$2"'/hackademic-next&' /var/www/html/hackademic-next/config.inc.php
sed -i 's/localhost/'"$1"'/' /var/www/html/hackademic-next/config.inc.php
