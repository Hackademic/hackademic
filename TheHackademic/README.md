# TheHackademic
TheHackademic Project helps you test your knowledge in Web Application Security with realistic real world challenges. Different type of vulnerabilites XSS ( Cross-Site Scripting), Sql injection, LFI, RFI, Shell upload, OS command injection and more with currently 11 scenarios, challenges 1,3,4,7 are completed as of now and still uploading.

#Deployment
1. Dependencies of TheHackademic involve a web server (Apache, nginx) with PHP and Mysql/MariaDB connected with it.
   Works best with Apache and Mysql. 
   Cloning : git clone https://github.com/messi96/TheHackademic.    
   Move the TheHackademic folder to /var/www/html or your default directory.     
   Give permission chmod -R 765 TheHackademic.    
   Command to install php and mysql :     
   sudo apt-get install apache2 mysql-server php5 php5-mysql php5-cli php5-imagick php5-gd php5-mcrypt php5-curl phpmyadmin.    
   Start both the services : apache2 and mysql.    
   On your browser type : 127.0.0.1/ or localhost.    
   Setup database for challenges : 4 & 7.
   Before that, goto these two files :     
   /var/www/html/TheHackademic/challenge_4/sql-connections/db-creds.inc and     
   /var/www/html/TheHackademic/challenge_7/sql-connections/db-creds.inc    
   and enter ur root username and password, save the file.    
   Now your database would be smoothly configured.   
   And you can start working on challenges.   
   *Tested both locally and remotely*   
   All the Best, have Patience !    
   
2. Deployment would be way easier through Docker Engine. Docker Repository will be updated here soon.
