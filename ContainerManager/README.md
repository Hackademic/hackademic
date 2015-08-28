Container Manager
=================

Installation:
-------------

Run the `install.py`script. It will automatically install (if not installed already) and configure Ubuntu base image with the challenges inside the Web_Challenges directory.

Note:
-----

1) You might want to have some patience since if you are running it for the first time, it will be downloading around 350 MB. From the 2nd time, downloading will not be required.

2) If there is any error, please start a new [issue](https://github.com/a0xnirudh/hackademic/issues) with the error that you got from log files located inside the directory `hackademic-logs`.

3) Check for a new build called `hackademic` after the installation. Use the command `docker images` in a terminal and verify there is a new build.

4) If you wanna test out the challenge (A simple phpinfo() as of now) run the command `docker run -d -p 1337:80 hackademic` and after this go to the URL `ip-address:1337/testchallenge1` and see if you are getting the output of phpinfo().

Creating Container:
-------------------

The file `create_container.py` should be called with the challenge name as an arguemnt. Say for eg: if student comes and clicks in **try challenge** then `create_container.py` should be called which will successfully create and host the web challenge in a random port and gives back the absolute url to the challenge.

Student can then visit the URL and access the challenge.

Container Daemon:
-----------------

An always running python script which manages the whole container project. Immediately once the daemon starts, it will spawn a new child which checks for the container details every 5 minutes and the moment a container up time becomes greater than 1 hour, the child will kill the container. The daemon has the following abilities:

1. Create New containers
2. List currently running containers
3. Kill any containers if needed.

A UI has to be added to provide this as an interface to the admin.
