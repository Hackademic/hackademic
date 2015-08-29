"""Class to deal with pipes

.. module:: pipes
    :platform: unix, windows
    :synopsis: starts listening to a named pipe defined in main file.
    When ever a new command is recieved it creates an instance of commandproc
    class, which deals with the command and send response via the pipe
    mentioned in command

.. moduleauthor:: Minhaz A V <minhazav@gmail.com>
"""

import os
import sys
import time
from cmd import commandproc


class dpipes:
    """dpipes: class contains methods to listen to a named pipe
    and spwaning a new instance of commandproc to deal with it.
    """

    # Global variables for this class

    #TODO move this to cmd module, and get a new IP on start command only
    # @priority: high
    baseIP = '192.168.10.'
    IPcount = 2
    domain = 'localhost'

    def __init__(self, pipePath, domainName):
        """Constructor

        Args:
            pipePath (str): the path of pipe to listen to
            domainName (str): the domain name of current machine
        """
        self.pipePath = pipePath
        self.domain = domainName

    def create(self):
        """makes a fifo pipe

        Creates a pipe and start listening to it for commands
        """

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
        """destroy the fifo pipe

        destroys the pipe created for listening to commands
        """
        if os.path.exists(self.pipePath):
            os.remove(self.pipePath)

        # TODO: destroy all out pipes created as well.
        # & Kill all threads
