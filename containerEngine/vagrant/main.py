#!/usr/bin/env python
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

    def run(self):
        # TODO: Load the domain name of the system from config.inc.php
        # And store that as env variable

        # Define event listener for named pipe here
        # Currently writing to temp code to test daemon for now
        try:
            mypipe = dpipes(pipePath, domainName)
            mypipe.create()
        except Exception as inst:
            # TODO print correct exception message
            print """[%s] Unable to create pipes required to communicate
            with daemon.\nException: %s""" % (time.time(), inst)
            sys.exit(1)

    def _stop(self):
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


if __name__ == "__main__":
    daemon = vagrantpyd(pidFilePath, logfilePath, errfilePath)
    if len(sys.argv) == 2:
        if 'start' == sys.argv[1]:
            # Code to check if config file exists
            if not os.path.exists("../../config.inc.php"):
                print "Hackademic config file 'config.inc.php' not found"
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
                print "Vagrantpyd starting..."
                daemon.start()
        elif 'stop' == sys.argv[1]:
            print "Vagrantpyd stopping..."
            daemon.stop()
        elif 'restart' == sys.argv[1]:
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
