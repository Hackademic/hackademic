var=$1
sed -i 's/hackademic-db/'$var'/g' grant_priv.sql 
mysql -p < grant_priv.sql
