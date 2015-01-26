create user 'root'@'%' identified by 'hackademic';
grant all on hackademic-db.* to 'root'@'%' with grant option;
flush privileges;
