Tips for developers
-------------------

Hackademic is a young project, however, it's gaining momentum fast. If you are interested in contributing you should follow some basic guidelines.

* The latest development version is the `next-dev` branch, you should check it out and make all your pull requests there.
* We would really appreciate it if your new features came with unit tests. If you don't know how ask us.
* Tests:
  * New features should come with php-unit or Selenium (or better both) unit tests testing that the feature works as expected.
  * All the code should pass the existing unit tests before merging.
* Coding - Style:
  * Every commit shouldn't generate any errors with PHP_CodeSniffer (to fix most errors you can use PHP Coding Standards Fixer).
  * Commits: Clean commits make it easy to review code, also commits that do only one thing are easier to manage bug-wise. So:
    * One commit should fix one problem or introduce one feature only, please don't commit fixes all around the place.
    * Only what you modified goes in the commit (for instance you shouldn't commit vim/project files or anything unrelated).
    * The commit message should explain what you did briefly.
    * Every commit should merge with `next-dev` without conflicts (rebase often).
* Pull Requests:
  * All pull requests should be for the `next-dev` branch.
  * In case you found an important bug in a previous version and you think people running the version should get the fix then issue a pull request for that specific version (it should still merge without any conflicts though).


Translations
------------
We're using gettext for translations coupled with the apropriate smarty plugin.
If you'd like to provide a tanslation you can look at the locale directory under your desired language.
The project's language is changed either on install or by setting the correct value in the config file.

For devs:
Handy tutorial on gettext:
`http://www.sitepoint.com/localizing-php-applications-1/`

The smarty plugin:
`https://github.com/smarty-gettext/smarty-gettext`

2 line instructions:
The settings are loaded in the master controller,
In the templates include whatever you want to be translated in {}.


How to create a challenge
-------------------------

Hackademic challenges are simple websites or web applications that simulate a vulnerability.
In our current version we use regular expressions to check if the provided string is correct.
In order to initialize your challenge you need to include the following.

```php
include_once dirname(__FILE__).'/../../init.php';
session_start();
require_once(HACKADEMIC_PATH."pages/challenge_monitor.php");
$monitor->update(CHALLENGE_INIT, $_GET);
$_SESSION['init'] = true;
```

Then in order to register a success you call
```php
$monitor->update(CHALLENGE_SUCCESS, $_GET);
```
and for a failure 
```php
$monitor->update(CHALLENGE_FAILURE, $_GET);
```


Packaging Challenges
-----------------------------

In order to package a challenge you have to create an XML file named after the challenge. The `.xml` file should have the structure found here:
`https://github.com/Hackademic/hackademic/blob/next/challenges/Example/example.xml`

Then you package everything in a zip file and ship it.


Frontend testing Documentation and how to create a test
-------------------------------------------------------

We use phpunit and Selenium webDriver with Facebook's php bindings to create functional tests.

We've included everything as a composer dependency so you only need to download composer and run
```
composer install
```
in order to fetch the dependencies.


Running tests
-------------

To run the tests you first need to start the remote webdriver server.
For convenience a reasonably recent server executable is included with the project.
You can start the server by running:
```
java -jar selenium-server-standalone-2.45.0.jar
```
from the tests directory.
This will start a local webdriver server that listens on localhost and port 4444.
Then you execute tests by running:
```
vendor/bin/phpunit <path_to_your_test>
```


Writing your own tests:
-----------------------

To write your own tests you can check `<tests_dir>/admin/model/AddUserControllerTest.php` for an example a `BaseTest` class with some helper functions is provided.

0. Test for normal behavior first
1. Test if it generates all the erros second
3. Identify the edge cases and write tests for them
4. In order to get a unique css path for the element you want to click you can inspect it in Firefox or Chrome and right-click on the element and select Copy CSS Path
5. Cleanup after your test, `tearDown()` exists for that reason too.
6. Each class should test one feature. E.g. `AddUserTest` should test if a user can be added sucessfully.
