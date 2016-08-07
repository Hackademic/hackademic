#!/usr/bin/env python
 
import sys, time, os
from daemon import daemon
from pipes import dpipes
 
# define all paths required
currentPath = os.path.dirname(os.path.realpath(__file__))
pidFilePath = currentPath +"/tmp/process.pid"
pipePath = currentPath +"/tmp/pipe"
logfilePath = currentPath +"/tmp/logs"
errfilePath = currentPath +"/tmp/err"

class vagrantpyd(daemon):
    def run(self):
        #TODO: define event listener for named pipe here
        # Currently writing to temp code to test daemon for now
        try:
            mypipe = dpipes(pipePath)
            mypipe.create()
        except Exception as inst:
            # TODO print correct exception message
            print "[%s] Unable to create pipes required to communicate with daemon.\nException: %s" % (time.time(), inst)
            sys.exit(1)

    def _stop(self):
        try:
            mypipe = dpipes(pipePath)
            mypipe.destroy()
        except Exception as inst:
            # TODO print correct exception message
            print "[%s] Unable to destroy pipes" % time.time()
            sys.exit(1)
 
if not os.path.exists("./tmp/"):
    os.makedirs("./tmp/")


if __name__ == "__main__":
    daemon = vagrantpyd(pidFilePath, logfilePath, errfilePath)
    if len(sys.argv) == 2:
        if 'start' == sys.argv[1]:
            print "Vagrantpyd starting..."
            daemon.start()
        elif 'stop' == sys.argv[1]:
            print "Vagrantpyd stopping..."
            daemon.stop()
        elif 'restart' == sys.argv[1]:
            print "Vagrantpyd restarting..."
            daemon.restart()
        else:
            print "Unknown command"
            sys.exit(2)
        
        sys.exit(0)
    else:
        print "usage: %s start|stop|restart" % sys.argv[0]
        sys.exit(2)