#!/usr/bin/env python
"""The main file for Vagrant Daemon.

Allows you to programatically control vagrant, create, start, stop,
destroy or collect info on existing boxes and VMs. The daemon setups
boxes based on a **challenge.xml** file provided to it. All
communcication using named pipes.

.. moduleauthor:: Minhaz A V <minhazav@gmail.com>

"""

import sys
import time
import os
import re
from daemon import daemon
from pipes import dpipes


# define all paths required
currentPath = os.path.dirname(os.path.realpath(__file__))
pidFilePath = currentPath + "/tmp/process.pid"
pipePath = currentPath + "/tmp/pipe"
logfilePath = currentPath + "/tmp/logs"
errfilePath = currentPath + "/tmp/err"
domainName = None

class vagrantpyd(daemon):
    """Subclass of daemon class.

    contains overridden methods, **run()** and **_stop()** which are called
    when daemon is started or stopped respectively.

    """

    def run(self):
        """**run()** called after daemon is started

        Once daemon has started, it creates an object of **dpipes**
        class which listens to incoming requests via pipes

        Returns:
            void.
        """
        try:
            print "domainName = %s" % domainName
            mypipe = dpipes(pipePath, domainName)
            mypipe.create()
        except Exception as inst:
            # TODO print correct exception message
            print """[%s] Unable to create pipes required to communicate
            with daemon.\nException: %s""" % (time.time(), inst)
            sys.exit(1)

    def _stop(self):
        """**_stop()** called after daemon is stopped

        Once daemon has stopped, it destroys pipes meant to recieve the
        commands

        Returns:
            void.
        """
        try:
            mypipe = dpipes(pipePath, None)
            mypipe.destroy()
        except Exception, e:
            # TODO print correct exception message
            print "[%s] Unable to destroy pipes. Exception: %s" % (time.time(), e)
            sys.exit(1)


# Create a tmp directory if not exists
# if required by the files needed
os.chdir(currentPath)
if not os.path.exists("./tmp/"):
    os.makedirs("./tmp/")

# Create log files if not exists
if not os.path.exists(logfilePath):
    file = open(logfilePath, 'a+')
    file.close()

# Create err files if not exists
if not os.path.exists(errfilePath):
    file = open(errfilePath, 'a+')
    file.close()

def loadDomainInfo():
    """Function to load information of domain name of the machine.

    It parses the **config.inc.php** file located at **../../** relative to
    this directory and modifies the global variable with this information
    This is later used by **cmd** module while starting a challenge, to update
    **/etc/hosts** information

    """
    global domainName
    if not os.path.exists("../../config.inc.php"):
        print "Hackademic config file 'config.inc.php' not found"
        sys.exit(1)
    else:
        with open("../../config.inc.php") as conf:
            confData = conf.read()
            match = re.search('define\(\'SOURCE_ROOT_PATH\',\s*\"(.*)\"\);', confData)
            if match:
                if match.group(1):
                    domainName = match.group(1).split('/')[2]
                    print "Using domain name as: %s" % domainName
                else:
                    print "Correct SOURCE_ROOT_PATH not found in 'config.inc.php"
                    sys.exit(1)
            else:
                print "SOURCE_ROOT_PATH not found in 'config.inc.php"
                sys.exit(1)

if __name__ == "__main__":
    daemon = vagrantpyd(pidFilePath, logfilePath, errfilePath)
    if len(sys.argv) == 2:
        if 'start' == sys.argv[1]:
            # Code to check if config file exists
            loadDomainInfo()
            print "Vagrantpyd starting..."
            daemon.start()
        elif 'stop' == sys.argv[1]:
            print "Vagrantpyd stopping..."
            daemon.stop()
        elif 'restart' == sys.argv[1]:
            loadDomainInfo()
            print "Vagrantpyd restarting..."
            daemon.restart()
        else:
            print "Unknown command!"
            print "usage: %s start|stop|restart" % sys.argv[0]
            sys.exit(2)

        sys.exit(0)
    else:
        print "usage: %s start|stop|restart" % sys.argv[0]
        sys.exit(2)
