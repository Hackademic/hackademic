CREATE TABLE users (
    id int(11) UNIQUE AUTO_INCREMENT,
    username varchar(255) PRIMARY KEY,
    full_name varchar(255) NOT NULL,
    email varchar(100) NOT NULL,
    password varchar(255) NOT NULL,
    joined datetime NOT NULL,
    last_visit datetime DEFAULT NULL,
    is_activated int(1) DEFAULT 0,
    type int(10) DEFAULT 0,
    token int(10) DEFAULT 0
);

CREATE TABLE articles (
    id int(11) PRIMARY KEY AUTO_INCREMENT,
    title varchar(255),
    content LONGTEXT,
    date_posted datetime NOT NULL,
    created_by varchar(255) NOT NULL,
    last_modified datetime DEFAULT NULL,
    last_modified_by varchar(255) DEFAULT NULL,
    ordering int(10) DEFAULT 0,
    is_published int(1) DEFAULT 1
);

/*Argument for the existenceo f both visibility and availability:
a class might need to know how many challenges lie ahead but they shouldnt solve all of them in one go*/
CREATE TABLE challenges (
    id int(11) PRIMARY KEY AUTO_INCREMENT,
    title varchar(255), /*Challenge title*/
    pkg_name varchar(255) NOT NULL,/*Name of the folder/package the challenge is located*/
    description text,
    author varchar(255) NOT NULL,
    category varchar(255) NOT NULL,/*Category of the challenge, I guess its only for informative reasons(to appear on the frontend and so far we have only web)*/
    date_posted datetime NOT NULL,
    visibility varchar(255) DEFAULT 'private',/*Who can see the existence of this challenge in his frontend Values: one of:
     private, Only admin can see it
     public,  Everyone can see it
     class_private Only people who belong in a class that this challenge is assigned can see it*/
    publish int(10) DEFAULT 0,/*ADMIN VAR: lists if the admin has made this
				  challenge available to the rest of the users
				  binary 0 =no publish, 1=publish*/
    abstract varchar(255) DEFAULT NULL,/*no clue what it does mean TODO: find about abstract in challenges*/
    level varchar(255) DEFAULT NULL,/*TODO: find what does that mean and how its used nad what's expected*/
    duration int(11) DEFAULT NULL,/*TODO:same as above*/
    goal varchar(255) DEFAULT NULL,/*i guess something along the lines of xss this TODO:same*/
    solution varchar(255)DEFAULT NULL,/*in order to solve the challenge you have to put this text in that form*/
    availability varchar(255) DEFAULT 'private',/*Who can take the challenge. Values: one of:
    private, Nobody can take it
    public, everybody can take it
    class_private Only people who belong in a class that this challenge is assigned can take it*/
    default_points int(11), /*How many points does this challenge grant the solver if the teacher has not modified the value */
    default_duration int(11)
);

CREATE TABLE class_challenges (
    id int(11) PRIMARY KEY AUTO_INCREMENT,
    challenge_id int(11) NOT NULL ,
    class_id int(11) NOT NULL ,
    date_created datetime NOT NULL
);

CREATE TABLE classes (
    id int(11) PRIMARY KEY AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    date_created datetime NOT NULL,
    archive int(1) DEFAULT 0
);

CREATE TABLE class_memberships (
    id int(11) UNIQUE AUTO_INCREMENT,
    user_id int(11) NOT NULL ,
    class_id int(11) NOT NULL ,
    date_created datetime NOT NULL,
    PRIMARY KEY (user_id,class_id)
);

CREATE TABLE challenge_attempts (
    id int(11) PRIMARY KEY AUTO_INCREMENT,
    user_id int(11) NOT NULL,
    challenge_id int(11) NOT NULL,
    time datetime NOT NULL,
    status varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS `challenge_attempt_count` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `challenge_id` int(11) NOT NULL,
  `tries` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `challenge_id` (`challenge_id`)
);


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

INSERT INTO classes(name,date_created) VALUES ('Sample Class','2012-08-09 00:43:48');
INSERT INTO users (username,full_name,email,password,joined,is_activated,type,token)VALUES ('student','Student','student@gmail.com','ad6a280417a0f533d8b670c61667e1a0','2012-08-09 00-46-27','1','0','');
INSERT INTO users (username,full_name,email,password,joined,is_activated,type,token)VALUES ('teacher','Teacher','teacher@gmail.com','a426dcf72ba25d046591f81a5495eab7','2012-08-09 00-48-00','1','2','');
INSERT INTO class_memberships(user_id,class_id,date_created)VALUES ('1','1','2012-08-09 00:59:00');
INSERT INTO class_memberships(user_id,class_id,date_created)VALUES ('2','1','2012-08-09 00:59:00');
INSERT INTO class_memberships(user_id,class_id,date_created)VALUES ('3','1','2012-08-09 00:59:00');
INSERT INTO class_challenges(challenge_id,class_id,date_created)VALUES ('1','1','2012-08-09 01:01:07');
INSERT INTO class_challenges(challenge_id,class_id,date_created)VALUES ('2','1','2012-08-09 01:01:07');
INSERT INTO class_challenges(challenge_id,class_id,date_created)VALUES ('3','1','2012-08-09 01:01:07');
INSERT INTO class_challenges(challenge_id,class_id,date_created)VALUES ('4','1','2012-08-09 01:01:07');
INSERT INTO class_challenges(challenge_id,class_id,date_created)VALUES ('5','1','2012-08-09 01:01:07');
INSERT INTO class_challenges(challenge_id,class_id,date_created)VALUES ('6','1','2012-08-09 01:01:07');
INSERT INTO class_challenges(challenge_id,class_id,date_created)VALUES ('7','1','2012-08-09 01:01:07');
INSERT INTO class_challenges(challenge_id,class_id,date_created)VALUES ('9','1','2012-08-09 01:01:07');
INSERT INTO class_challenges(challenge_id,class_id,date_created)VALUES ('10','1','2012-08-09 01:01:07');
INSERT INTO articles(title,content,date_posted,created_by,is_published)VALUES ('Welcome','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed interdum, felis ac pellentesque feugiat, massa enim sagittis elit, sed dignissim sem ligula non nisl. Sed pulvinar nunc nec eros aliquet non tempus diam vehicula. Nunc tincidunt, leo ut interdum tristique, quam ligula porttitor tellus, at tincidunt magna enim nec arcu. Nunc tempor egestas libero. Vivamus nulla ligula, vehicula vitae mattis quis, laoreet eget urna. Proin eget est quis urna venenatis dictum nec vel lectus. Nullam sit amet vehicula leo. Sed commodo, orci vitae facilisis accumsan, arcu justo sagittis risus, quis aliquet purus neque eu odio. Mauris lectus orci, tincidunt in varius quis, dictum sed nibh. Quisque dapibus mollis blandit. Donec vel tellus nisl, sed scelerisque felis. Praesent ut eros tortor, sed molestie nunc. Duis eu massa at justo iaculis gravida.</p>\r\n<p>In adipiscing dictum risus a tincidunt. Sed nisi ipsum, rutrum sed ornare in, bibendum at augue. Integer ornare semper varius. Integer luctus vehicula elementum. Donec cursus elit quis erat laoreet elementum. Praesent eget justo purus, vitae accumsan massa. Ut tristique, mauris non dignissim luctus, velit justo sollicitudin odio, vel rutrum purus enim eu felis. In adipiscing elementum sagittis. Nam sed dui ante. Nunc laoreet hendrerit nisl vitae porta. Praesent sit amet ligula et nisi vulputate volutpat. Maecenas venenatis iaculis sapien sit amet auctor. Curabitur euismod venenatis velit non tempor. Cras vel sapien purus, mollis fermentum nulla. Mauris sed elementum enim. Donec ultrices urna at justo adipiscing rutrum.</p>','2012-08-09 01:19:59','admin','1');
