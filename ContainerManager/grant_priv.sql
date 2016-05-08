create user 'root'@'%' identified by 'password';
grant all on hackademic-db.* to 'root'@'%' with grant option;
flush privileges;
