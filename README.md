[![Project Status: Active - The project has reached a stable, usable state and is being actively developed.](http://www.repostatus.org/badges/0.1.0/active.svg)](http://www.repostatus.org/#active)

OWASP Hackademic Challenges project
===================================

The **OWASP Hackademic Challenge** project helps you test your knowledge on web application security. You can use it to actually attack web applications in a realistic but also controlled and safe environment.

The latest stable version is in the `next` branch, the development version is in `next-dev`.


Description
-----------

The Hackademic challenges implement realistic scenarios with known vulnerabilities in a safe, controlled environment. Users can discover and exploit the vulnerabilities presented in the challenges and learn important concepts of information security through the perspective of an attacker.

Currently, there are 10 scenarios available.

You can choose to start from the one that you find most appealing, although we suggest you follow the order presented on the first page. We intend to expand the available challenges with additional scenarios that involve cryptography and even vulnerable systems presented as downloadable virtual machines.


Deployment
----------

Dependencies for Hackademic involve a web server (Apache, nginx) with PHP and Mysql/MariaDB connected to it. Make sure you have these installed before you start deploying Hackademic. We recommend to use Apache with MySQL. See [Digital Ocean's website](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu) for a good tutorial under Ubuntu. See [WampServer](http://www.wampserver.com/en/) to set up the environment under Windows.

To clone Hackademic,

`git clone https://github.com/Hackademic/hackademic.git`

After successful cloning, copy the folder into `/var/www`.
Next change the permissions of the folder with

`sudo chmod -R 765 hackademic`

Ensure that Apache is started and that the SQL connection is also active. Point your browser towards `http://127.0.0.1/`
You will be prompted with the Hackademic page. In case you have many sub-directories in `/var/www/`, the browser would list all the directories available.
Choose hackademic from those.

Now you will be prompted with the Hackademic installation page.
Be sure to fill out all the fields.

1. Administrator Details

	Fill any email id, username and password. 
	You will be using this username and password, later on to log in to hackademic.

2. Database Settings
	
	Fill the database name, database host, database username and password.

3. Configuration Settings

	All the fields are preloaded with information. Go to next level.

4. Finish

	On finish, you should get a success message. Open the URL it suggests. 
	You should be able to log in.


After the finish stage if you got an error

*Parse error: syntax error, unexpected '[' in /var/www/hackademic/model/common/class.ChallengeAttempts.php on line 363']'*

update the version of PHP you are using. Hackademic uses 5.4+. 


Road Map and Getting Involved
-----------------------------

We maintain an up to date list of open issues on the platform on our [issues](https://github.com/Hackademic/hackademic/issues)

For a list of features we would like implemented you can see either the issues page or our [Google Summer Of Code ideas page](https://www.owasp.org/index.php/GSoC2013_Ideas#OWASP_Hackademic_Challenges_-_New_challenges_and_Improvements_to_the_existing_ones)

Involvement in the development and promotion of the Hackademic Challenges is actively encouraged!
You do not have to be a security expert in order to contribute.
Some of the ways you can help are:

* Write Documentation
* Write Unit tests
* Develop themes and plugins
* Write Challenges, Articles or contribute security courses

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for installation guidelines and other developer-oriented explanations.

We are also experimenting with a trello board [here](https://trello.com/b/Y6oHvP3P/hakcademic-roadmap)

Contact Us
----------

Feel free to connect with us over `#hackademic-dev` channel on Freenode.
We also run a mailing list which is `owasp-hackademic-challenges@lists.owasp.org`
that you can join [here](https://lists.owasp.org/mailman/listinfo/owasp-hackademic-challenges).
You can also check out the slack discussion on the owasp slack channel [here](https://owasp.slack.com/messages/project-hackademic/)
