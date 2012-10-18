CREATE  TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL DEFAULT NULL AUTO_INCREMENT ,
  `username` VARCHAR(255) NOT NULL ,
  `full_name` VARCHAR(255) NOT NULL ,
  `email` VARCHAR(100) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `joined` DATETIME NOT NULL ,
  `last_visit` DATETIME NULL DEFAULT NULL ,
  `is_activated` INT(1) NULL DEFAULT 0 ,
  `type` INT(10) NULL DEFAULT 0 ,
  `token` INT(10) NULL DEFAULT 0 ,
  UNIQUE INDEX (`id` ASC) ,
  PRIMARY KEY (`id`, `username`) ,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE  TABLE IF NOT EXISTS `articles` (
  `id` INT(11) NULL DEFAULT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  `content` LONGTEXT NULL DEFAULT NULL ,
  `date_posted` DATETIME NOT NULL ,
  `created_by` VARCHAR(255) NOT NULL ,
  `last_modified` DATETIME NULL DEFAULT NULL ,
  `last_modified_by` VARCHAR(255) NULL DEFAULT NULL ,
  `ordering` INT(10) NULL DEFAULT 0 ,
  `is_published` INT(1) NULL DEFAULT 1 ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE  TABLE IF NOT EXISTS `challenges` (
  `id` INT(11) NULL DEFAULT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  `pkg_name` VARCHAR(255) NOT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `author` VARCHAR(255) NOT NULL ,
  `category` VARCHAR(255) NOT NULL ,
  `date_posted` DATETIME NOT NULL ,
  `visibility` VARCHAR(255) NULL DEFAULT 'private' ,
  `publish` INT(10) NULL DEFAULT 0 ,
  `abstract` VARCHAR(255) NULL DEFAULT NULL ,
  `level` VARCHAR(255) NULL DEFAULT NULL ,
  `duration` INT(11) NULL DEFAULT NULL ,
  `goal` VARCHAR(255) NULL DEFAULT NULL ,
  `solution` VARCHAR(255) NULL DEFAULT NULL ,
  `availability` VARCHAR(255) NULL DEFAULT 'private' ,
  `default_points` INT(11) NULL DEFAULT NULL ,
  `default_duration` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE  TABLE IF NOT EXISTS `classes` (
  `id` INT(11) NULL DEFAULT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `date_created` DATETIME NOT NULL ,
  `archive` INT(1) NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE  TABLE IF NOT EXISTS `challenge_attempts` (
  `id` INT(11) NULL DEFAULT NULL AUTO_INCREMENT ,
  `time` DATETIME NOT NULL ,
  `status` VARCHAR(255) NOT NULL ,
  `challenge_id` INT(11) NOT NULL ,
  `user_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`, `challenge_id`, `user_id`) ,
  INDEX `fk_challenge_attempts_challenges1_idx` (`challenge_id` ASC) ,
  INDEX `fk_challenge_attempts_users1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_challenge_attempts_challenges1`
    FOREIGN KEY (`challenge_id` )
    REFERENCES ``.`challenges` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_challenge_attempts_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES ``.`users` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE  TABLE IF NOT EXISTS `challenge_attempt_count` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `tries` INT(11) NULL DEFAULT NULL ,
  `user_id` INT(11) NOT NULL ,
  `challenge_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`, `user_id`, `challenge_id`) ,
  INDEX `fk_challenge_attempt_count_users1_idx` (`user_id` ASC) ,
  UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC) ,
  INDEX `fk_challenge_attempt_count_challenges1_idx` (`challenge_id` ASC) ,
  UNIQUE INDEX `challenge_id_UNIQUE` (`challenge_id` ASC) ,
  CONSTRAINT `fk_challenge_attempt_count_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES ``.`users` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_challenge_attempt_count_challenges1`
    FOREIGN KEY (`challenge_id` )
    REFERENCES ``.`challenges` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE  TABLE IF NOT EXISTS `class_challenges` (
  `challenge_id` INT(11) NOT NULL ,
  `class_id` INT(11) NOT NULL ,
  `date_created` DATETIME NULL DEFAULT NULL ,
  `id` INT(11) NOT NULL ,
  PRIMARY KEY (`challenge_id`, `class_id`, `id`) ,
  INDEX `fk_challenges_has_classes_classes1_idx` (`class_id` ASC) ,
  INDEX `fk_challenges_has_classes_challenges_idx` (`challenge_id` ASC) ,
  CONSTRAINT `fk_challenges_has_classes_challenges`
    FOREIGN KEY (`challenge_id` )
    REFERENCES ``.`challenges` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_challenges_has_classes_classes1`
    FOREIGN KEY (`class_id` )
    REFERENCES ``.`classes` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;

CREATE  TABLE IF NOT EXISTS `class_memberships` (
  `users_username` VARCHAR(255) NOT NULL ,
  `class_id` INT(11) NOT NULL ,
  `id` INT(11) NOT NULL ,
  `date_created` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`users_username`, `class_id`, `id`) ,
  INDEX `fk_users_has_classes_classes1_idx` (`class_id` ASC) ,
  INDEX `fk_users_has_classes_users1_idx` (`users_username` ASC) ,
  CONSTRAINT `fk_users_has_classes_users1`
    FOREIGN KEY (`users_username` )
    REFERENCES ``.`users` (`username` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_users_has_classes_classes1`
    FOREIGN KEY (`class_id` )
    REFERENCES ``.`classes` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;



INSERT INTO challenges(title,pkg_name,description,author,category,date_posted,publish) VALUES 
('Challenge 1','ch001','Our agents (hackers) informed us that there reasonable suspicion 
that the site of this <a href=\"ch001/\" target=\"_blank\">Logistics Company</a> is a blind 
for a human organs\'  smuggling organisation.<br /> <br /> This organisation attracts its 
victims through advertisments for jobs with very high salaries. They choose those ones who 
do not have many relatives, they assasinate them and then sell their organs to very rich 
clients, at very high prices.<br /> <br /> These employees are registered in the secret 
files of the company as \"special clients\"!<br /> <br /> One of our agents has been hired 
as by the particular company. Unfortunately, since 01/01/2007 he has gone missing.<br /> 
<br /> We know that our agent is alive, but we cannot contact him. Last time he  
communicated with us, he mentioned that we could contact him at the  e-mail address the 
company has supplied him with, should there a problem  arise.<br /> <br /> The problem is 
that when we last talked to him, he had not a company  e-mail address yet, but he told us 
that his e-mail can be found through  the company\'s site. <br /> <br /> The only thing we 
remember is that he was hired on Friday the 13th! <br /> <br /> You have to find his e-mail 
address and send it to us by using the central communication panel of the company\'s 
site.<br /> <br /> Good luck!!!','Andreas Venieris,\n        Konstantinos Papapanagiotou,\n 
       Anastasios Stasinopoulos,\n        Vasilios Vlachos,\n        Alexandros 
Papanikolaou','web','2012-08-09 00-23-14',1);

INSERT INTO challenges(title,pkg_name,description,author,category,date_posted,publish)VALUES 

('Challenge 2','ch002','Your Country needs your help for finding the password of an enemy 

site  that contains useful information, which if is not acquired on time,  peace in our 

area will be at stake.<br /> <br />\n        You must therefore succeed in finding the 

password of this military <a href=\"ch002/index.php\" target=\"_blank\">SITE</a>.<br /> <br 

/> Good luck!','Andreas Venieris,\n        Konstantinos Papapanagiotou,\n        Anastasios 

Stasinopoulos,\n        Vasilios Vlachos,\n        Alexandros Papanikolaou','web','2012-08

-09 00-24-12',1);

INSERT INTO challenges(title,pkg_name,description,author,category,date_posted,publish)VALUES 

('Challenge 3','ch003','XSS permits a malevolent user to inject his own code in vulnerable 

web  pages. According to the OWASP 2010 Top 10 Application Security Risks,  XSS attacks 

rank 2nd in the \"most dangerous\" list.<br /> <br /> Your objective is to make an alert 

box appear  <a href=\"ch003/index.php\" target=\"_blank\">HERE</a> bearing the message: 

\"<strong>XSS!</strong>\".','Andreas Venieris,\n        Konstantinos Papapanagiotou,\n      

  Anastasios Stasinopoulos,\n        Vasilios Vlachos,\n        Alexandros 

Papanikolaou','web','2012-08-09 00-24-46',1);

INSERT INTO challenges(title,pkg_name,description,author,category,date_posted,publish)VALUES 

('Challenge 4','ch004','A hacker informed us that <a href=\"ch004/index.php\" target=

\"_blank\">this</a> site suffers from an XSS-like type of  vulnerability. Unfortunately, he 

lost the notes he had written regarding  how exactly did he exploit the aforementioned 

vulnerability.<br /> Your objective is to make an alert box appear, bearing the message 

\"<strong>XSS!</strong>\". It should be noted, however, that this site has some protection 

against such attacks.','Andreas Venieris,\n        Konstantinos Papapanagiotou,\n        

Anastasios Stasinopoulos,\n        Vasilios Vlachos,\n        Alexandros 

Papanikolaou','web','2012-08-09 00-25-25',1);

INSERT INTO challenges(title,pkg_name,description,author,category,date_posted,publish)VALUES 

('Challenge 5','ch005','You need to get access to the contents of this <a href=

\"ch005/index.php\" target=\"_blank\">SITE</a>. In order to achieve  this, however, you 

must buy the \"p0wnBrowser\" web browser. Since it is  too expensive, you will have to 

\"fool\" the system in some way, so that  it let you read the site\'s contents.','Andreas 

Venieris,\n        Konstantinos Papapanagiotou,\n        Anastasios Stasinopoulos,\n        

Vasilios Vlachos,\n        Alexandros Papanikolaou','web','2012-08-09 00-26-09',1);

INSERT INTO challenges(title,pkg_name,description,author,category,date_posted,publish)VALUES 

('Challenge 6','ch006','In this assignment you must prove your... knightly skills! Real 

knights  have not disappeared.They still exist, keeping their secrets well  hidden.<br /> 

Your mission is to infiltrate their <a href=\"ch006/index.php\" target=\"_blank\">SITE</a>. 

There is a small problem, however... We don\'t know the password!<br /> Perhaps you could 

find it?<br /> Let\'s see!<br /> g00d luck dudes!','Andreas Venieris,\n        Konstantinos 

Papapanagiotou,\n        Anastasios Stasinopoulos,\n        Vasilios Vlachos,\n        

Alexandros Papanikolaou','web','2012-08-09 00-26-52',1);

INSERT INTO challenges(title,pkg_name,description,author,category,date_posted,publish)VALUES 

('Challenge 7','ch007','A good friend of mine studies at Acme University, in the <a href=

\"ch007/index.php\" target=\"_blank\">Computer  Science and Telecomms Department</a>. 

Unfortunately, her grades are not that  good. You are now thinking \"This is big news!\"... 

Hmmm, maybe not. What  is big news, however, is this: The network administrator asked for  

3,000 euros to change her marks into A\'s. This is obviously a case of  administrative 

authority abuse. Hence... a good chance for D-phase and  public exposure...<br /> I need to 

get into the site as admin and upload an index.htm  file in the web-root directory, that 

will present all required evidence  for the University\'s latest \"re-marking\" practices!

<br /> I only need you to find the admin password for me...<br /> <br /> Good 

Luck!','Andreas Venieris,\n        Konstantinos Papapanagiotou,\n        Anastasios 

Stasinopoulos,\n        Vasilios Vlachos,\n        Alexandros Papanikolaou','web','2012-08

-09 00-27-22',1);

INSERT INTO challenges(title,pkg_name,description,author,category,date_posted,publish)VALUES 

('Challenge 8','ch008','You have managed, after several tries, to install a backdoor shell 

(Locus7Shell) to <a href=\"ch008/\" target=\"_blank\">trytohack.gr<br /></a> <br /> The 

problem is that, in order to execute the majority of the commands  (on the machine running 

the backdoor) you must have super-user rights  (root).<br /> <br /> Your aim is to obtain 

root rights.','Andreas Venieris,\n        Konstantinos Papapanagiotou,\n        Anastasios 

Stasinopoulos,\n        Vasilios Vlachos,\n        Alexandros Papanikolaou','web','2012-08

-09 00-30-48',1);

INSERT INTO challenges(title,pkg_name,description,author,category,date_posted,publish)VALUES 

('Challenge 9','ch009','A friend of yours has set up a news blog at <a href=

\"ch009/index.php\" target=\"_blank\">slagoff.com</a>.  However, he is kind of worried 

regarding the security of the news that  gets posted on the blog and has asked you to check 

how secure it is.<br /> <br /> Your objective is to determine whether any vulnerabilities 

exist that, if exploited, can grant access to the blog\'s server.<br /> <br /> Hint: A 

specially-tailored backdoor shell can be found at \"<a href=

\"http://www.really_nasty_hacker.com/shell.txt\" target=\"_blank

\">http://www.really_nasty_hacker.com/shell.txt</a>\".','Andreas Venieris,\n        

Konstantinos Papapanagiotou,\n        Anastasios Stasinopoulos,\n        Vasilios Vlachos,

\n        Alexandros Papanikolaou','web','2012-08-09 00-31-31',1);

INSERT INTO challenges(title,pkg_name,description,author,category,date_posted,publish)VALUES 

('Challenge 10','ch010','Would you like to become an active hacker ?<br /> How about 

becoming a member of the world\'s largest hacker group:<br /> The n1nJ4.n4x0rZ.CreW!<br /> 

<br /> Before you can join though, you \'ll have to prove yourself worthy by passing the 

test that can be found at: <a href=\"ch010/\" target=\"_blank

\">http://n1nj4h4x0rzcr3w.com</a><br /> <br /> If you succeed in completing the challenge, 

you will get a serial  number, which you will use for obtaining the password that will 

enable  you to join the group.<br /> <br /> Your objective is to bypass the authentication 

mechanism, find the  serial number and be supplied with your own username and password from 

 the admin team of the site.','Andreas Venieris,\n        Konstantinos Papapanagiotou,\n    

    Anastasios Stasinopoulos,\n        Vasilios Vlachos,\n        Alexandros 

Papanikolaou','web','2012-08-09 00-32-07',1);
