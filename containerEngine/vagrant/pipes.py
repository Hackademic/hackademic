# Class to deal with pipes
import os
import sys
import time
from cmd import commandproc


class dpipes:
    # Global variables for this class
    baseIP = '192.168.10.'
    IPcount = 2
    domain = 'localhost'

    def __init__(self, pipePath, domainName):
        self.pipePath = pipePath
        self.domain = domainName

    def create(self):
        # make a fifo pipe
        if not os.path.exists(self.pipePath):
            os.mkfifo(self.pipePath)

        print """[%s] [Main Thread] Creating named pipe, 
        to listen to incoming commands""" % time.time()
        self.fifo = open(self.pipePath, 'r')

        while True:
            line = self.fifo.readline()[:-1]
            if line:
                print '[%s] Command Recieved: %s' % (time.time(), line)
                # Spawn a new thread and process the argument

                # TODO: assumption no of IPs used will be less than 255 - 1
                # come up with more scalable system here
                ip = self.baseIP + str(self.IPcount)
                self.IPcount += 1

                commandproc(line, ip, self.domain)

            # Wait for 1 seconds now
            time.sleep(1)

    def destroy(self):
        if os.path.exists(self.pipePath):
            os.remove(self.pipePath)

        # TODO: destroy all out pipes created as well.
        # & Kill all threads
