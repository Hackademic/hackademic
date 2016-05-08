#! /bin/bash

########################################################################################################################################
# Grant priv.sh and grant priv.sql are used to prep the hackademic database to accept connections from containers
# Since the containers are hosted on a different virtual network appropriate permissions should be added to the hackademic database
# A user root is granted permission to modify the hackademic database from any network
# This user is entered in the config.inc.php file for the hackademic installation inside the container
# The details of the database used by hackademic is first obtained from the user
# Then the grant_priv.sql file is modified accordingly and execued
########################################################################################################################################

#database name
db=$1

#password
pass=$2

sed -i 's/password/'$pass'/g' grant_priv.sql
sed -i 's/hackademic-db/'$var'/g' grant_priv.sql 
mysql -p < grant_priv.sql
