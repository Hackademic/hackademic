db=$1
pass=$2

sed -i 's/password/'$pass'/g' grant_priv.sql
sed -i 's/hackademic-db/'$var'/g' grant_priv.sql 
mysql -p < grant_priv.sql
