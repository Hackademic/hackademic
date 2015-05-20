[![Project Status: Active - The project has reached a stable, usable state and is being actively developed.](http://www.repostatus.org/badges/0.1.0/active.svg)](http://www.repostatus.org/#active)

OWASP Hackademic Challenges project
===================================

The OWASP Hackademic Challenges Project helps you test your knowledge on web application security. You can use it to attack web applications in a realistic but also controllable and safe environment.

The latest stable version is the branch named next, the development version is named next-dev.


Description
-----------

The Hackademic Challenges implement realistic scenarios with known vulnerabilities in a safe and controllable environment. Users can attempt to discover and exploit these vulnerabilities in order to learn important concepts of information security through an attacker's perspective.

Currently, there are 10 scenarios available.

You can choose to start from the one that you find most appealing,although we suggest to follow the order presented on the first page.We intend to expand the available challenges with additional scenarios that involve cryptography, and even vulnerable systems being implemented in downloadable virtual machines.


Deployment
----------

Dependencies of Hackademic involve a web server (Apache, nginx) with PHP and Mysql/MariaDB connected with it. Make sure you have installed these before you start deploying Hackademic. We recommand to use Apache with MySQL. See [Digital Ocean's website](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu) for a good tutorial under Ubunt. See [WampServer](http://www.wampserver.com/en/) to set up the environnement under Windows.

Clone Hackademic project,

`git clone https://github.com/Hackademic/hackademic.git`

After successful cloning of the Hackademic project, copy the contents into `/var/www`
We need to change the permissions of the file now,

`sudo chmod -R 765 hackademic`

Ensure that the Apache is started and SQL connection is also active. Point your browser towards http://localhost/
You will be prompted with Hackademic page. In case you have many sub-directories in `/var/www/`, the browser would throw up all the directories.
Choose hackademic from that.

Now you will be prompted to Hackademic installation page.
Be sure to fill out all the information correctly. Failing to do so would probably throw errors at the last part of installation.


Road Map and Getting Involved
-----------------------------

We maintain an up to date list of open issues on the platform on our [issues](https://github.com/Hackademic/hackademic/issues here)

For a list of features we would like implemented you can see either the issues page or our [Google Summer Of Code ideas page](https://www.owasp.org/index.php/GSoC2013_Ideas#OWASP_Hackademic_Challenges_-_New_challenges_and_Improvements_to_the_existing_ones)

Involvement in the development and promotion of the Hackademic Challenges is highly encouraged!
You do not have to be a security expert in order to contribute.
Some other ways also to contibute include :
* Writing Documentation
* Writing Unit tests
* Developing themes and plugins
* Writing Challenges or Articles or contribute security courses


Tips for developers
-------------------

Hackademic is a young project, however, it's gaining momentum fast. If you are interested in contributing you should follow some basic guidelines.

* The latest development version is the next-dev branch, you should check it out and make all your pull requests there.
* We would really appreciate it if your new features came with unit tests. If you don't know how ask us.
* 
-- more to follow --

Contact Us
----------

Feel free to connect with us over #hackademic-dev channel in the Freenode.
We also run a mailing list which is owasp-hackademic-challenges@lists.owasp.org
that you can join [here](https://lists.owasp.org/mailman/listinfo/owasp-hackademic-challenges)


