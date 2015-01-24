create user 'root'@'%' identified by 'hackademic';
grant all on hack.* to 'root'@'%' with grant option;
flush privileges;