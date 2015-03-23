OWASP Hackademic Challenges project
===================================

The '''OWASP Hackademic Challenges''' Project helps you test your knowledge on web application security. You can use it to actually attack web applications in a realistic but also controllable and safe environment.

The latest production version is the next branch, the development version is the next-dev branch.


Description
-----------

The Hackademic Challenges implement realistic scenarios with known vulnerabilities in a safe, controllable environment. Users can attempt to discover and exploit these vulnerabilities in order to learn important concepts of information security through the attacker's perspective.

Currently, there are 10 web application security scenarios available.

You can choose to start from the one that you find most appealing,although we suggest to follow the order presented on the first page.We intend to expand the available challenges with additional scenarios that involve cryptography, and even vulnerable systems implemented in download-able virtual machines.




Deployment
----------

The project can be easily deployed to any PHP-capable web server running mysql/mariadb. 
Just clone the project somewhere in your websites folder (In most linux systems that would be /var/www/) make sure the folder is writable by the webserver, open your browser and visit 
http://localhost/<the path to your hackademic installation>/

Road Map and Getting Involved
-----------------------------

We maintain an up to date list of open issues on the platform on our [issues](https://github.com/Hackademic/hackademic/issues here)

For a list of features we would like implemented you can see either the issues page or our [Google Summer Of Code ideas page](https://www.owasp.org/index.php/GSoC2013_Ideas#OWASP_Hackademic_Challenges_-_New_challenges_and_Improvements_to_the_existing_ones)

Involvement in the development and promotion of the Hackademic Challenges is actively encouraged!
You do not have to be a security expert in order to contribute.
Some of the ways you can help:
* Write Documentation
* Write Unit tests
* Develop themes and plugins
* Write Challenges or Articles or contribute security courses


Tips for developers
-------------------

Hackademic is a young project, however, it's gaining momentum fast. If you are interested in contributing you should follow some basic guidelines.

* The latest development version is the next-dev branch, you should check it out and make all your pull requests there.
* We would really appreciate it if your new features came with unit tests. If you don't know how ask us.
* 
-- more to follow --

Contact Us
----------

If you have any questions or would like to chat 
you can find us on the #hackademic-dev channel on Freenode
Also our mailing list is owasp-hackademic-challenges@lists.owasp.org
you can join [here](https://lists.owasp.org/mailman/listinfo/owasp-hackademic-challenges)

Both channels are very low traffic


Frontend testing Documentation and how to create a test
-------------------------------------------------------

We use phpunit and selenium webDriver with facebook's php bindings to create functional tests.

We've included everything as a composer dependency so you only need to download composer and run

composer install

in order to fetch the dependencies.


Running tests
-------------

To run the tests you first need to start the remote webdriver server.
For convenience a reasonably recent server executable is included with the project.
You can start the server by running:

java -jar selenium-server-standalone-2.45.0.jar

from the tests directory.

This will start a local webdriver server that listens on localhost and port 4444.

Then you execute tests by running:

vedor/bin/phpunit <path_to_your_test>

Writing your own tests:
-----------------------

To write your own tests you can check

<tests_dir>/admin/model/AddUserControllerTest.php 

for an example
A BaseTest class with some helper functions is provided.

General guilines
----------------
(from a guy with limited experience on writing tests so suggestions are welcome):

0) Test for normal behavior first
1) Test if it generates all the erros second
3) Identify the edge cases and write tests for them
4) In order to get a unique css path for the element you want to click you can inspect it in firefox or chrome and right-click on the element and select Copy CSS Path
5) Cleanup after your test, tearDown() exists for that reason too.
6) Each class should test one feature. E.g. AddUserTest should test if a user can be added sucessfully.