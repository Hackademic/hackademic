SHOW WARNINGS;
--
-- Table structure for table `articles`
--
CREATE TABLE IF NOT EXISTS  articles  (
   id  int(11) NOT NULL AUTO_INCREMENT,
   title  varchar(255) DEFAULT NULL,
   content  longtext,
   date_posted  datetime NOT NULL,
   created_by  varchar(255) NOT NULL,
   last_modified  datetime DEFAULT NULL,
   last_modified_by  varchar(255) DEFAULT NULL,
   ordering  int(10) DEFAULT '0',
   is_published  int(1) DEFAULT '1',
  PRIMARY KEY ( id )
);

--
-- Dumping data for table  articles
--
INSERT INTO articles ( title , content , date_posted , created_by , last_modified , last_modified_by , ordering , is_published ) VALUES
('Welcome to Hackademic v0.9!', '<p><img width=\"840\" height=\"188\" logo\"=\" alt=\"owasp\" src=\"http://www.techtoweb.com/wp-content/uploads/2012/12/owasp-security.png\"></p> <p>Thank you for installling and using the Hackademic challenges project.</p> <p>You can find our code on github <a href=\"https://github.com/Hackademic/hackademic\">here</a>, for any problems or support, please open an issue on our github repository.</p><p>Hackademic is a FOSS project under the OWASP umbrela organization.</p>', '2013-08-18 00:00:17', 'admin', '2013-08-18 00:04:27', 'admin', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table  challenges
--

--
-- Table structure for table `challenges`
--

CREATE TABLE IF NOT EXISTS `challenges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `pkg_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `date_posted` datetime NOT NULL,
  `visibility` varchar(255) NOT NULL DEFAULT 'private',
  `publish` int(10) DEFAULT '0',
  `abstract` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `goal` varchar(255) DEFAULT NULL,
  `solution` varchar(255) DEFAULT NULL,
  `availability` varchar(255) NOT NULL DEFAULT 'private',
  `default_points` int(11) DEFAULT NULL,
  `default_duration` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `pkg_name` (`pkg_name`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii AUTO_INCREMENT=1 ;

--
-- Dumping data for table `challenges`
--

INSERT INTO `challenges` (`title`, `pkg_name`, `description`, `author`, `category`, `date_posted`, `visibility`, `publish`, `abstract`, `level`, `duration`, `goal`, `solution`, `availability`, `default_points`, `default_duration`) VALUES
('Challenge 1', 'ch001', 'Our agents (hackers) informed us that there reasonable suspicion \r\nthat the site of this <a href="ch001/" target="_blank">Logistics Company</a> is a blind \r\nfor a human organs''  smuggling organisation.<br /> <br /> This organisation attracts its \r\nvictims through advertisments for jobs with very high salaries. They choose those ones who \r\ndo not have many relatives, they assasinate them and then sell their organs to very rich \r\nclients, at very high prices.<br /> <br /> These employees are registered in the secret \r\nfiles of the company as "special clients"!<br /> <br /> One of our agents has been hired \r\nas by the particular company. Unfortunately, since 01/01/2007 he has gone missing.<br /> \r\n<br /> We know that our agent is alive, but we cannot contact him. Last time he  \r\ncommunicated with us, he mentioned that we could contact him at the  e-mail address the \r\ncompany has supplied him with, should there a problem  arise.<br /> <br /> The problem is \r\nthat when we last talked to him, he had not a company  e-mail address yet, but he told us \r\nthat his e-mail can be found through  the company''s site. <br /> <br /> The only thing we \r\nremember is that he was hired on Friday the 13th! <br /> <br /> You have to find his e-mail \r\naddress and send it to us by using the central communication panel of the company''s \r\nsite.<br /> <br /> Good luck!!!', 'Andreas Venieris,\n        Konstantinos Papapanagiotou,\n \n       Anastasios Stasinopoulos,\n        Vasilios Vlachos,\n        Alexandros \nPapanikolaou', 'web', '2012-08-09 00:23:14', 'public', 1, NULL, '1', 60, NULL, NULL, 'public', 1, 60),
('Challenge 2', 'ch002', 'Your Country needs your help for finding the password of an enemy \r\n\r\nsite  that contains useful information, which if is not acquired on time,  peace in our \r\n\r\narea will be at stake.<br /> <br />\n        You must therefore succeed in finding the \r\n\r\npassword of this military <a href="ch002/index.php" target="_blank">SITE</a>.<br /> <br \r\n\r\n/> Good luck!', 'Andreas Venieris,\n        Konstantinos Papapanagiotou,\n        Anastasios \r\n\r\nStasinopoulos,\n        Vasilios Vlachos,\n        Alexandros Papanikolaou', 'web', '0000-00-00 00:00:00', 'public', 1, NULL, '1', 60, NULL, NULL, 'public', 1, 60),
('Challenge 3', 'ch003', 'XSS permits a malevolent user to inject his own code in vulnerable \r\n\r\nweb  pages. According to the OWASP 2010 Top 10 Application Security Risks,  XSS attacks \r\n\r\nrank 2nd in the "most dangerous" list.<br /> <br /> Your objective is to make an alert \r\n\r\nbox appear  <a href="ch003/index.php" target="_blank">HERE</a> bearing the message: \r\n\r\n"<strong>XSS!</strong>".', 'Andreas Venieris,\n        Konstantinos Papapanagiotou,\n      \r\n\r\n  Anastasios Stasinopoulos,\n        Vasilios Vlachos,\n        Alexandros \r\n\r\nPapanikolaou', 'web', '2012-08-09 00:24:46', 'public', 1, NULL, '1', 60, NULL, NULL, 'public', 1, 60),
('Challenge 4', 'ch004', 'A hacker informed us that <a href="ch004/index.php" target=\r\n\r\n"_blank">this</a> site suffers from an XSS-like type of  vulnerability. Unfortunately, he \r\n\r\nlost the notes he had written regarding  how exactly did he exploit the aforementioned \r\n\r\nvulnerability.<br /> Your objective is to make an alert box appear, bearing the message \r\n\r\n"<strong>XSS!</strong>". It should be noted, however, that this site has some protection \r\n\r\nagainst such attacks.', 'Andreas Venieris,\n        Konstantinos Papapanagiotou,\n        \r\n\r\nAnastasios Stasinopoulos,\n        Vasilios Vlachos,\n        Alexandros \r\n\r\nPapanikolaou', 'web', '2012-08-09 00:25:25', 'public', 1, NULL, '1', 60, NULL, NULL, 'public', 1, 60),
('Challenge 5', 'ch005', 'You need to get access to the contents of this <a href=\r\n\r\n"ch005/index.php" target="_blank">SITE</a>. In order to achieve  this, however, you \r\n\r\nmust buy the "p0wnBrowser" web browser. Since it is  too expensive, you will have to \r\n\r\n"fool" the system in some way, so that  it let you read the site''s contents.', 'Andreas \r\n\r\nVenieris,\n        Konstantinos Papapanagiotou,\n        Anastasios Stasinopoulos,\n        \r\n\r\nVasilios Vlachos,\n        Alexandros Papanikolaou', 'web', '2012-08-09 00:26:09', 'public', 1, NULL, '1', 60, NULL, NULL, 'public', 1, 60),
('Challenge 6', 'ch006', 'In this assignment you must prove your... knightly skills! Real \r\n\r\nknights  have not disappeared.They still exist, keeping their secrets well  hidden.<br /> \r\n\r\nYour mission is to infiltrate their <a href="ch006/index.php" target="_blank">SITE</a>. \r\n\r\nThere is a small problem, however... We don''t know the password!<br /> Perhaps you could \r\n\r\nfind it?<br /> Let''s see!<br /> g00d luck dudes!', 'Andreas Venieris,\n        Konstantinos \r\n\r\nPapapanagiotou,\n        Anastasios Stasinopoulos,\n        Vasilios Vlachos,\n        \r\n\r\nAlexandros Papanikolaou', 'web', '2012-08-09 00:26:52', 'public', 1, NULL, '1', 60, NULL, NULL, 'public', 1, 60),
('Challenge 7', 'ch007', 'A good friend of mine studies at Acme University, in the <a href=\r\n\r\n"ch007/index.php" target="_blank">Computer  Science and Telecomms Department</a>. \r\n\r\nUnfortunately, her grades are not that  good. You are now thinking "This is big news!"... \r\n\r\nHmmm, maybe not. What  is big news, however, is this: The network administrator asked for  \r\n\r\n3,000 euros to change her marks into A''s. This is obviously a case of  administrative \r\n\r\nauthority abuse. Hence... a good chance for D-phase and  public exposure...<br /> I need to \r\n\r\nget into the site as admin and upload an index.htm  file in the web-root directory, that \r\n\r\nwill present all required evidence  for the University''s latest "re-marking" practices!\r\n\r\n<br /> I only need you to find the admin password for me...<br /> <br /> Good \r\n\r\nLuck!', 'Andreas Venieris,\n        Konstantinos Papapanagiotou,\n        Anastasios \r\n\r\nStasinopoulos,\n        Vasilios Vlachos,\n        Alexandros Papanikolaou', 'web', '0000-00-00 00:00:00', 'public', 1, NULL, '1', 60, NULL, NULL, 'public', 1, 60),
('Challenge 8', 'ch008', 'You have managed, after several tries, to install a backdoor shell \r\n\r\n(Locus7Shell) to <a href="ch008/" target="_blank">trytohack.gr<br /></a> <br /> The \r\n\r\nproblem is that, in order to execute the majority of the commands  (on the machine running \r\n\r\nthe backdoor) you must have super-user rights  (root).<br /> <br /> Your aim is to obtain \r\n\r\nroot rights.', 'Andreas Venieris,\n        Konstantinos Papapanagiotou,\n        Anastasios \r\n\r\nStasinopoulos,\n        Vasilios Vlachos,\n        Alexandros Papanikolaou', 'web', '0000-00-00 00:00:00', 'public', 1, NULL, '1', 60, NULL, NULL, 'public', 1, 60),
('Challenge 9', 'ch009', 'A friend of yours has set up a news blog at <a href=\r\n\r\n"ch009/index.php" target="_blank">slagoff.com</a>.  However, he is kind of worried \r\n\r\nregarding the security of the news that  gets posted on the blog and has asked you to check \r\n\r\nhow secure it is.<br /> <br /> Your objective is to determine whether any vulnerabilities \r\n\r\nexist that, if exploited, can grant access to the blog''s server.<br /> <br /> Hint: A \r\n\r\nspecially-tailored backdoor shell can be found at "<a href=\r\n\r\n"http://www.really_nasty_hacker.com/shell.txt" target="_blank\r\n\r\n">http://www.really_nasty_hacker.com/shell.txt</a>".', 'Andreas Venieris,\n        \r\n\r\nKonstantinos Papapanagiotou,\n        Anastasios Stasinopoulos,\n        Vasilios Vlachos,\r\n\r\n\n        Alexandros Papanikolaou', 'web', '2012-08-09 00:31:31', 'public', 1, NULL, '1', 60, NULL, NULL, 'public', 1, 60),
('Challenge 10', 'ch010', 'Would you like to become an active hacker ?<br /> How about \r\n\r\nbecoming a member of the world''s largest hacker group:<br /> The n1nJ4.n4x0rZ.CreW!<br /> \r\n\r\n<br /> Before you can join though, you ''ll have to prove yourself worthy by passing the \r\n\r\ntest that can be found at: <a href="ch010/" target="_blank\r\n\r\n">http://n1nj4h4x0rzcr3w.com</a><br /> <br /> If you succeed in completing the challenge, \r\n\r\nyou will get a serial  number, which you will use for obtaining the password that will \r\n\r\nenable  you to join the group.<br /> <br /> Your objective is to bypass the authentication \r\n\r\nmechanism, find the  serial number and be supplied with your own username and password from \r\n\r\n the admin team of the site.', 'Andreas Venieris,\n        Konstantinos Papapanagiotou,\n    \r\n\r\n    Anastasios Stasinopoulos,\n        Vasilios Vlachos,\n        Alexandros \r\n\r\nPapanikolaou', 'web', '2012-08-09 00:32:07', 'public', 1, NULL, '1', 60, NULL, NULL, 'public', 1, 60),
('Example Template For Challenge xml Files creation', 'example', '<p>Insert some text describing the scenario of the challenge(what the users are supposed to do and if there is any fictional story)</p>', 'Name or email or both', 'In what category does your challenge belong?(web? crypto? networks?)', '2012-10-16 22:35:01', 'private', 0, NULL, '1', 60, NULL, NULL, 'private', 1, 0),
('cookiEng', 'cookiEng', '<p>Hello, we have heard that you are one of the best hackers in our country. We need your services.<br>You must visit an underground site and find<br> the right password. With this password we will cancel 100k+ illegal gun and drug deals!\n The good news are that we have the  directory where the password is stored. Its here \\"/t0psec.php\\".\n The bad news are that we have no access there. Only the administrator does. Go and find the password for us!<br><br><br>Good luck!</p>', 'Nikos Danopoulos', 'web', '2012-08-09 00:32:07', 'public', 1, NULL, '1', 60, NULL, NULL, 'public', 1, 60),
('Izon Challenge', 'izon', '<p>After the mysterious disappearance of your best friend, you are contacted by an unknown individual who claims to have information about your friend. This individual identifies himself as "Mister Jax" and claims that is a former colleague of your friend.</p><p>Your friend was working at Izon Corporation, a weapons manufactured and government contractor as a systems engineer. Mister Jax didn''t tell you his role in Izon, but wants you to pass through a series of tests to infiltrate Izon''s web security to find the truth about your friend</p><p>After much consideration you agree with Mister Jax and he, remotely, sets up your computer to look like as if it is a part of Izon''s Virtual Private Network in order to access their site. He also said that he''ll guide you while you work your way to uncover the truth about your lost friend</p><p>Here is a copy of Mister Jax''s last email:</p><p><pre>The task is simple: You get in, get your information and get out.\r\nYour friend was either a dumb programmer or a brilliant one, he left\r\nmany holes to be exploited in order to gain higher access to the site.\r\nI''ll be guiding you with tips while you try to hack through Izon''s site.\r\nThere are four tasks, some related to each other, some not.\r\nYou need to use your skills to overcome the obstacles, knowledge will come along.\r\nSixty minutes will suffice. When they''re over, I won''t be able to offer any\r\ncover to you, and you''ll be compromised, with unknown consequences, I''m afraid.\r\nI''ll be seeing you there.\r\n\r   - Jax</pre></p>	<p>Once you get in, you''ll have sixty minutes to complete this challenge. Use common sense, remember that the most obvious place hides the most important stuff and try to behave as if you were hacking a real system.</p><p>Good Luck!</p>', 'Vasileios Mplanas', 'web', '2014-03-27 00:00:00', 'public', 1, NULL, '1', 60, NULL, NULL, 'public', 10, 60),
('Fun with Frequencies', 'ch011', '\n    	You are given a file that has been encrypted with a substitution cipher using some key permutation P.\n		And a mysterious ciphertext, that has also been encrypted with the same key permutation P. \n		Everything you need to know is explained in the challenge.\n \n		Your Objective: give us the decryption of the mysterious ciphertext, should you choose to accept it.\n\n\n    ', 'Subhayan RoyMoulick, Dan Myshkin, Spyros Gasteratos\n    ', 'crypto', '2015-03-15 23:05:31', 'public', 1, NULL, '2', 60, NULL, NULL, 'public', NULL, NULL),
('OTP Challenge', 'ch012', ' \n        You are given ciphertexts of various messages, encrypted with the same key using a XOR Cipher or Vernam or One Time Pad. \n\n        However we know the OTP is secure for encrypting only one message. And we are confident it is possible to break the scheme now. \n\n        Given a set of ciphertexts, we are interested in knowing only one. \n \n		Your Objective: Decipher the asked ciphertext and suggest us a strategy for action.\n\n    ', 'Subhayan RoyMoulick, Dan Myshkin, Spyros Gasteratos\n    ', 'crypto', '2015-03-15 23:05:32', 'public', 1, NULL, '4', 45, NULL, NULL, 'public', NULL, NULL),
('Silly MACs', 'ch013', '\n        Our adversaries use a primitive and insecure mode of operation to obtain Message Authentication Codes for communication. While they use a secure block cipher, F, to obtain MACs for one block, when it comes to multiple blocks their scheme can be easily manupulted and broken. \n\n        Your Objective : Help us forge a valid MAC to confuse them. \n\n    ', 'Subhayan RoyMoulick, Dan Myshkin, Spyros Gasteratos\n    ', 'crypto', '2015-03-15 23:05:33', 'public', 1, NULL, '\n		4\n    ', 0, NULL, NULL, 'public', NULL, NULL),
('RSA Challenge I: Bad Primes', 'ch014', '\n        We have an RSA encrypted message. \n        All we know is that the program that generated the RSA primes, p,q uses a bad PRG, so we are confindent |p-q| leq 10000 (decimal).  \n        Your Objective : Factor N, and tell us the originial messeage. \n\n    ', 'Subhayan RoyMoulick, Dan Myshkin, Spyros Gasteratos\n    ', 'crypto', '2015-03-15 23:05:34', 'public', 1, NULL, '6', 90, NULL, NULL, 'public', NULL, NULL),
('RSA Challenge II: Common Modulas', 'ch015', '\n        We have a single message m, that was encrpted, using RSA, and sent to several people.\n        All reciepents have the same RSA modulas N (N=pq).  \n        We are however only interested in the message.\n\n        Your Objective : Reveal the originial message. (Assume m le N) \n\n    ', 'Subhayan RoyMoulick, Dan Myshkin, Spyros Gasteratos\n    ', 'crypto', '2015-03-15 23:05:35', 'public', 1, NULL, '6', 120, NULL, NULL, 'public', NULL, NULL),
('RSA Challenge III: Low Encryption Exponent', 'ch016', '\n        We have a single message m, that was encrpted, using RSA, and sent to three people.\n        All reciepents have the same RSA ecryption modulas e (e=3), (notice it also matches the no. of recipients  ).  \n        We are interested in the message. \n\n        Your Objective : Reveal the originial message', 'Subhayan RoyMoulick, Dan Myshkin, Spyros Gasteratos', 'crypto', '2015-03-15 23:05:36', 'public', 1, NULL, '7', 120, NULL, NULL, 'public', NULL, NULL),
('Meet in the Middle', 'ch017', '\n        We have a few ciphertexts we are interested to decrypt. These ciphertexts are "made of" messages containting non-padded prime products.\n        Your Objective : Reveal the originial messages  \n\n    ', 'Subhayan RoyMoulick, Dan Myshkin, Spyros Gasteratos\n    ', 'crypto', '2015-03-15 23:05:37', 'public', 1, NULL, '8', 180, NULL, NULL, 'public', NULL, NULL),
('Blinding Signatures', 'ch018', '\n        We have a message m, for which we want a valid signature. While we have access to a Sign Oracle to query signatures, it will not respond and sign the challenge message for which we want the signature.\n        Your Mission, should you choose to accept it, is to forge a signature on the challenge message, using the oracle (or otherwise). \n\n    ', 'Subhayan RoyMoulick, Dan Myshkin, Spyros Gasteratos\n    ', 'crypto', '2015-03-15 23:05:38', 'public', 1, NULL, '6', 60, NULL, NULL, 'public', NULL, NULL),
('RSA Challenge IV: Low Private Exponent', 'ch020', '\n      	You are asked to audit a system that uses a Low Private Exponent (i.e. the Private Key), to save time decryption/signing.\n      	We think it is a bad idea and the Private Exponent can be approximated.\n      	Your Goal: Approximate the Private Exponent.  \n    ', 'Subhayan RoyMoulick, Dan Myshkin, Spyros Gasteratos\n    ', 'crypto', '2015-03-15 23:05:39', 'public', 1, NULL, '7', 120, NULL, NULL, 'public', NULL, NULL),
('Challenge 21', 'ch021', '\n        \n        This time,the website has increased its security.Passwords are not stored in plaintext anymore.Can you crack the admin password this time? \n        \n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web', '2015-03-15 23:05:40', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 22', 'ch022', '\n        \n        The Great Hackers Challenge!! Yes,you heard it right.You are given a chance to try out this challenge,which has been left unsolved till now. You are asked to break the authentication of a web page.But,the only problem is that there doesn''t exist any vulnerability to exploit.  \n        \n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web', '2015-03-15 23:05:41', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 23', 'ch023', '\n        \n        Ever been to take part in a treasure hint? Here''s your chance.The treasure is hidden somewhere in the web server.Try to use the hints available and reach the treasure.        \n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web', '2015-03-15 23:05:42', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 24', 'ch024', '\n        \n       You have ordered a product on a website online.But,you found out that the product was defective and so, asked for a refund. But,the website rejected your refund request without any reason. You, being a hacker want to hack into the system and make your refund request accepted. \n               \n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web,network', '2015-03-15 23:05:43', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 25', 'ch025', '\n        \n	Time to hurry! You have mistakenly sent an important mail to the wrong person. The details of the mail are too valuable and you can''t risk them being read by a wrong person.So, hurry up and stop the person from reading the mail.\n	Your Email: user234@email.com\n	Password: Usr@#$lc   \n               \n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web', '2015-03-15 23:05:44', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 26', 'ch026', '\n        \n        You are a member of the National Cyber Security group, along with a friend of yours.\n       \n        Your friend came across a conversation between 2 people and he suspected it to be related to some fraud. So, he started a Man-In-The-Middle Attack and succesfully installed a new key between them, during the key exchange phase. \n        \n        Now, he has asked you to spy on this conversation and gave you the details of the keys.He did not give you any information about the encryption scheme being used in the conversation. Its your turn to continue the MIM attack in such a way that none of the parties detect the attack. \n        \n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web', '2015-03-15 23:05:45', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 27', 'ch027', '\n        \n		The archaeological department has found a book which is hundreds of years old. This book named ''The Treasure'' tells of a treasure of immense value.The book also contains an encrypted text, which might help in finding the key to the treasure. You have been entrusted the responsibility to decipher it.\n        \n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'crypto', '2015-03-15 23:05:46', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 28', 'ch028', '\n        \nYou are again given the task to perform a Man-In-Middle Attack by your Security Agency.This time, both the parties are using the secure Diffie-Hellman Key Exchange protocol for generating keys.You have to perform the MIM attack during this key exchange.You can read about this key exchange protocol\n<a target="_blank" href="http://en.wikipedia.org/wiki/Diffie%E2%80%93Hellman_key_exchange#Cryptographic_explanation">here</a>\n        \n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web', '2015-03-15 23:05:39', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 29', 'ch029', '\n        \nThis is a challenge to test your knowledge of Cross Site Request Forgery attacks. Use CSRF attack and get your bank account credited with an amount of 1200 or greater.\n        \n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web', '2015-03-15 23:05:39', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 30', 'ch030', '\n        \nRSA is being used to provide security in various transactions. Knowing this, your friend implemented RSA by following the theory in the notes.He made a RSA cipher text using his implementation and challenged you, if you could break this RSA based cipher. Its time to prove your cryptographic skills.  \n        \n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'crypto', '2015-03-15 23:05:39', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 31', 'ch031', '\n        \nA friend of yours needs immediate surgery. It costs thousands of dollars and he doesn''t have money, neither do you. Your friend used to be rich, then got attracted to a lucky draw(lottery) website.He used all his money to buy lottery tickets in this website and thus, he lost all his money.\nNow, you came to know that this website is a fraud and eachtime, gives the winning lottery ticket to its own people. So, you want take revenge on that website and also earn money to help him. So, you want to win the lottery by finding some security vulnerability in the website.\n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web', '2015-03-15 23:05:39', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 32', 'ch032', '\n        \n   Here is a company established to help people in their financial affairs. Your neighbour is a technical helper in that company, he recently found that the company is cheating people and somehow collecting people''s creditcard details. Before informing the police, the company''s database should be deleted,else they would get alerted and copy database to somewhere else.<br /> So knowing you to be a hacker, he rushes to you, narrates you everything.Thinking that it may help you,he says that he has seen programmers of that website work in a folder named ''scripts'' present in the root directory. Can you handle the task and delete the database?\n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web', '2015-03-15 23:05:40', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 33', 'ch033', '\n        \nThe commander of the aliens has ordered his army to destroy a planet. You are on a mission to save the planet.(Yes!!, you are a Jedi Knight). You found a secret message sent by the commander. The message is in the Alien language,you have to decode it and save the planet.\n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web,crypto', '2015-03-15 23:05:40', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 34', 'ch034', '\n        \n        This is an ecommerce website selling mobiles.Can you break the website''s security by logging in as Admin? \n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web', '2015-03-15 23:05:40', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 35', 'ch035', '\n        \n       The following website has intense protection from CSRF attacks.It allows only those requests originating from http://example.com . But you need immediate access to the website.How do you achieve it?\n        \n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web', '2015-03-15 23:05:40', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 36', 'ch036', '\n        \n       The commander of Aliens has again ordered for the attack. They have reached earth and established their station somewhere. Help the army track their location by getting into the Alien''s web server.\n        \n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web', '2015-03-15 23:05:40', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 37', 'ch037', '\n        \nYou have been using an online calendar service for a long time.Recently, a bug has crept into that service and so,its displaying the wrong date and time.You have saved a lot of events and plans in that website and they all got mapped to some different date and time.The website doesn''t even have a contact-us info to report the bug.See if you can creep into the server and change the settings.\n\n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web', '2015-03-15 23:05:40', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 38', 'ch038', '\n        \nYou have come across a series of encrypted messages exchanged between 2 servers.You suspect these messages to be related to an online fraud. So,to verify these messages,you need the key file. The needed file is key.txt and is located in the web root directory,but you have no permission to access it. Can you access this file and decrypt the message?\n\n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web', '2015-03-15 23:05:40', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 39', 'ch039', '\n        \n        XOR cipher is one of the most secure ciphers and provides unconditional security. YOu are now given a task to break this cipher.Find the message corresponding to a xor encrypted cipher text.\n        \n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'crypto', '2015-03-15 23:05:40', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL),
('Challenge 40', 'ch040', '\n        \n        Your friend wants to take help from a third party service provider to improve his own website''s security and search engine visibility.He asked you to view that website and certify it to be completely secure.If you find some loophole in the website''s security, use it to log in as the admin.\n        \n    ', '\n    Bhanudev Chaluvadi\n    Spyros Gasteratos\n    ', 'web', '2015-03-15 23:05:41', 'public', 1, NULL, '', 0, NULL, NULL, 'public', NULL, NULL);

--
-- Table structure for table  challenge_attempts
--

CREATE TABLE IF NOT EXISTS  challenge_attempts  (
   id  int(11) NOT NULL AUTO_INCREMENT,
   user_id  int(11) NOT NULL,
   challenge_id  int(11) NOT NULL,
   class_id  int(11) NOT NULL,
   time  datetime NOT NULL,
   status  int(11) NOT NULL,
  PRIMARY KEY ( id ),
  KEY  user_id  ( user_id , challenge_id , class_id )
);

-- --------------------------------------------------------

--
-- Table structure for table  challenge_attempt_count
--

CREATE TABLE IF NOT EXISTS  challenge_attempt_count  (
   id  int(11) NOT NULL AUTO_INCREMENT,
   user_id  int(11) NOT NULL,
   challenge_id  int(11) NOT NULL,
   class_id  int(11) NOT NULL,
   tries  int(11) DEFAULT NULL,
  PRIMARY KEY ( id ),
  UNIQUE KEY  composite_key  ( user_id , challenge_id , class_id )
);
-- --------------------------------------------------------

--
-- Table structure for table  classes
--

CREATE TABLE IF NOT EXISTS  classes  (
   id  int(11) NOT NULL AUTO_INCREMENT,
   name  varchar(255) NOT NULL,
   date_created  datetime NOT NULL,
   archive  int(1) DEFAULT '0',
  PRIMARY KEY ( id )
);

--
-- Dumping data for table  classes
--
INSERT INTO classes ( id , name , date_created , archive ) VALUES
(1, 'Global Class', '2012-08-09 00:43:48', 0);

-- --------------------------------------------------------

--
-- Table structure for table  class_challenges
--

CREATE TABLE IF NOT EXISTS  class_challenges  (
   id  int(11) NOT NULL AUTO_INCREMENT,
   challenge_id  int(11) NOT NULL,
   class_id  int(11) NOT NULL,
   date_created  datetime NOT NULL,
  PRIMARY KEY ( id )
);

--
-- Dumping data for table  class_challenges
--


INSERT INTO  class_challenges  (challenge_id ,  class_id ,  date_created ) VALUES
(1, 1, '2012-08-09 01:01:07'),
(2, 1, '2012-08-09 01:01:07'),
(3, 1, '2012-08-09 01:01:07'),
(4, 1, '2012-08-09 01:01:07'),
(5, 1, '2012-08-09 01:01:07'),
(6, 1, '2012-08-09 01:01:07'),
(7, 1, '2012-08-09 01:01:07'),
(8, 1, '2012-08-09 01:01:07'),
(9, 1, '2012-10-16 22:32:58'),
(10, 1, '2012-08-09 01:01:07');

-- --------------------------------------------------------

--
-- Table structure for table  class_memberships
--

CREATE TABLE IF NOT EXISTS  class_memberships  (
   id  int(11) NOT NULL AUTO_INCREMENT,
   user_id  int(11) NOT NULL,
   class_id  int(11) NOT NULL,
   date_created  datetime NOT NULL,
  PRIMARY KEY ( user_id , class_id ),
  UNIQUE KEY  id  ( id )
);

-- --------------------------------------------------------


--
-- Table structure for table  scoring_rule
--

CREATE TABLE IF NOT EXISTS  scoring_rule  (
   id  int(11) NOT NULL AUTO_INCREMENT,
   challenge_id  int(11) NOT NULL,
   class_id  int(11) NOT NULL,
   attempt_cap  int(11) NOT NULL DEFAULT '0',
   attempt_cap_penalty  int(11) NOT NULL DEFAULT '0',
   time_between_first_and_last_attempt  int(11) NOT NULL DEFAULT '0',
   time_penalty  int(11) NOT NULL DEFAULT '0',
   time_reset_limit_seconds  int(11) NOT NULL DEFAULT '0',
   request_frequency_per_minute  int(11) NOT NULL DEFAULT '0',
   request_frequency_penalty  int(11) NOT NULL DEFAULT '0',
   experimentation_bonus  int(11) NOT NULL DEFAULT '0',
   multiple_solution_bonus  int(11) NOT NULL DEFAULT '0',
   banned_user_agents  longtext CHARACTER SET ascii COLLATE ascii_bin,
   banned_user_agents_penalty  int(11) NOT NULL DEFAULT '0',
   base_score  int(11) NOT NULL DEFAULT '5',
   first_try_solves  int(11) NOT NULL DEFAULT '0',
   penalty_for_many_first_try_solves  int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY ( id ),
  KEY  challenge_id  ( challenge_id , class_id )
);

--
-- Dumping data for table  scoring_rule
--

INSERT INTO  scoring_rule  (challenge_id ,  class_id ,  attempt_cap ,  attempt_cap_penalty ,  time_between_first_and_last_attempt ,  time_penalty ,  time_reset_limit_seconds ,  request_frequency_per_minute ,  request_frequency_penalty ,  experimentation_bonus ,  multiple_solution_bonus ,  banned_user_agents ,  banned_user_agents_penalty ,  base_score ,  first_try_solves ,  penalty_for_many_first_try_solves ) VALUES
(-1, -1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Indy Library,\r\nlibwww-perl, \r\ncurl, \r\nnikto, \r\nw3af, ', 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table options
--

CREATE TABLE IF NOT EXISTS options (
  option_name varchar(64) NOT NULL,
  option_value text NOT NULL,
  PRIMARY KEY (option_name)
);

--
-- Dumping data for table options
--

INSERT INTO options VALUES
('active_plugins','[]'),
('active_user_theme','""'),
('active_admin_theme','""');

-- --------------------------------------------------------

--
-- Table structure for table menus
--

CREATE TABLE IF NOT EXISTS menus (
  mid int(11) NOT NULL auto_increment,
  name varchar(50) NOT NULL default '',
  PRIMARY KEY  (`mid`)
);

--
-- Dumping data for table menus
--

INSERT INTO menus (mid, name) VALUES
(1, 'Admin menu'),
(2, 'Teacher menu'),
(3, 'Student menu');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `url` varchar(250) NOT NULL default '',
  `file` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`url`)
);

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`url`, `file`) VALUES
('admin', 'admin/index.php'),
('admin/scoringrules', 'admin/pages/scoringrules.php'),
('admin/addarticle', 'admin/pages/addarticle.php'),
('admin/articlemanager', 'admin/pages/articlemanager.php'),
('admin/dashboard', 'admin/pages/dashboard.php'),
('admin/usermanager', 'admin/pages/usermanager.php'),
('admin/addchallenge', 'admin/pages/addchallenge.php'),
('admin/challengemanager', 'admin/pages/challengemanager.php'),
('admin/options', 'admin/pages/options.php'),
('progressreport', 'pages/progress.php'),
('ranking', 'pages/ranking.php'),
('challenges', 'pages/challengelist.php'),
('login', 'pages/login.php'),
('logout', 'pages/logout.php'),
('challenge_monitor', 'pages/challenge_monitor.php'),
('challengelist', 'pages/challengelist.php'),
('challengesfrontend', 'pages/challengesfrontend.php'),
('forgotpassword', 'pages/forgotpassword.php'),
('home', 'pages/home.php'),
('mainlogin', 'pages/mainlogin.php'),
('readarticle', 'pages/readarticle.php'),
('register', 'pages/register.php'),
('resetpassword', 'pages/resetpassword.php'),
('showchallenges', 'pages/showchallenges.php'),
('trychallenge', 'pages/trychallenge.php'),
('admin/addclass', 'admin/pages/addclass.php'),
('admin/adduser', 'admin/pages/adduser.php'),
('admin/classchallenges', 'admin/pages/classchallenges.php'),
('admin/classmemberships', 'admin/pages/classmemberships.php'),
('admin/download', 'admin/pages/download.php'),
('admin/editarticle', 'admin/pages/editarticle.php'),
('admin/editchallenge', 'admin/pages/editchallenge.php'),
('admin/editcode', 'admin/pages/editcode.php'),
('admin/edituser', 'admin/pages/edituser.php'),
('admin/login', 'admin/pages/login.php'),
('admin/logout', 'admin/pages/logout.php'),
('admin/manageclass', 'admin/pages/manageclass.php'),
('admin/menumanager', 'admin/pages/menumanager.php'),
('admin/containers', 'admin/pages/containers.php'),
('admin/showclass', 'admin/pages/showclass.php');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(250) NOT NULL default '',
  `mid` int(11) NOT NULL,
  `label` varchar(50) NOT NULL default '',
  `parent` int(11) NOT NULL default 0,
  `sort` int(11) default 0,
  PRIMARY KEY  (`id`),
  FOREIGN KEY (`mid`) REFERENCES menus(`mid`)
);

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`url`, `mid`, `label`, `parent`, `sort`) VALUES
('admin', 1,  'Home', 0, 0),
('admin/addarticle', 1, 'Add New Articles', 0, 1),
('admin/articlemanager', 1, 'Article Manager', 0, 2),
('admin/usermanager', 1, 'Users/Classes', 0, 3),
('admin/addchallenge', 1, 'Add New Challenge', 0, 4),
('admin/challengemanager', 1, 'Challenge Manager', 0, 5),
('admin/menumanager', 1, 'Menu Manager', 0, 6),
('admin/options', 1, 'Options', 0, 7),
('logout', 1, 'Logout', 0, 8),
('admin', 2, 'Admin Dashboard', 0, 0),
('admin/addarticle', 2, 'Add New Articles', 0, 1),
('admin/articlemanager', 2, 'Article Manager', 0, 2),
('admin/usermanager', 2, 'Users/Classes', 0, 3),
('admin/addchallenge', 2, 'Add New Challenge', 0, 4),
('admin/challengemanager', 2, 'Challenge Manager', 0, 5),
('logout', 2,  'Logout', 0, 6),
('home', 3, 'Home', 0, 0),
('progressreport', 3, 'Progress Report', 0, 1),
('ranking', 3, 'Ranking', 0, 2),
('challenges', 3, 'Challenges', 0, 3),
('logout', 3,  'Logout', 0, 4);

-- --------------------------------------------------------

--
-- Trigger to remove menu items before pages
--
DROP TRIGGER IF EXISTS before_delete_pages;

CREATE TRIGGER before_delete_pages
  BEFORE DELETE ON pages
  FOR EACH ROW
  DELETE FROM menu_items WHERE menu_items.url = OLD.url;

-- --------------------------------------------------------

--
-- Table structure for table  users
--

CREATE TABLE IF NOT EXISTS  users  (
   id  int(11) NOT NULL AUTO_INCREMENT,
   username  varchar(255) NOT NULL,
   full_name  varchar(255) NOT NULL,
   email  varchar(100) NOT NULL,
   password  varchar(255) NOT NULL,
   joined  datetime NOT NULL,
   last_visit  datetime DEFAULT NULL,
   is_activated  int(1) DEFAULT '0',
   type  int(10) DEFAULT '0',
   token  int(10) DEFAULT '0',
  PRIMARY KEY ( username ),
  UNIQUE KEY  id  ( id )
);
--
-- Dumping data for table users
--

INSERT INTO users (`username`, `full_name`, `email`, `password`, `joined`, `last_visit`, `is_activated`, `type`, `token`) VALUES
('Guest','Guest User','guest@hackademic.com','empty pass this user is never supposed to login normally','2010-01-01 00:00:00','2010-01-01 00:00:00',1,0,0);
-- --------------------------------------------------------

--
-- Table structure for table  user_has_challenge_token
--

CREATE TABLE IF NOT EXISTS  user_has_challenge_token  (
   id  int(11) NOT NULL AUTO_INCREMENT,
   user_id  varchar(512) NOT NULL,
    class_id varchar(512) NOT NULL,
   challenge_id  varchar(512) NOT NULL,
   token  varchar(256) NOT NULL,
  PRIMARY KEY ( id )
);

-- --------------------------------------------------------

--
-- Table structure for table  user_score
--

CREATE TABLE IF NOT EXISTS  user_score  (
   id  int(11) NOT NULL AUTO_INCREMENT,
   user_id  int(11) NOT NULL,
   challenge_id  int(11) NOT NULL,
   class_id  int(11) NOT NULL,
   points  int(11) NOT NULL,
   penalties_bonuses  longtext CHARACTER SET ascii COLLATE ascii_bin,
  PRIMARY KEY ( id ),
  KEY  user_id  ( user_id , challenge_id , class_id )
);

SHOW WARNINGS;
