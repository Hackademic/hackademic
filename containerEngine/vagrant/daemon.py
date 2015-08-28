"""Generic linux daemon base class for python 3.x.

.. module:: daemon
    :platform: unix
    :synopsis: Used for daemonising current process or to kill once
    using its PID

.. moduleauthor:: Minhaz A V <minhazav@gmail.com>
"""

import sys
import os
import time
import atexit
import signal


class daemon:
    """Daemon class deals with daemonising current process.

    This is done by detaching current process with calling terminal,
    using UNIX double fork magic.

    """

    def __init__(self, pidfile, logfile, errfilePath):
        """Constructor of daemon class

        Args:
            pidfile (str): path of file to store PID information of the process
            logfile (str): path of the file which will be used for redirecting STDOUT
            errfilePath (str): path of the file which will be used for redirecting STDERR

        Returns:
            void.

        """
        self.pidfile = pidfile
        self.logfile = logfile
        self.errfilePath = errfilePath

    def daemonize(self):
        """Function to daemonize the process.

        UNIX double fork mechanism. It detaches the current process from calling
        termincal and become child of init process. Stores the PID of the process
        in **self.pidfile**

        Returns:
            void.

        """
        try:
            pid = os.fork()
            if pid > 0:
                # exit first parent
                sys.exit(0)
        except OSError as err:
            sys.stderr.write("""[Daemon Class] [Daemonize]: fork #1
			failed: {0}\n""".format(err))
            sys.exit(1)

        # decouple from parent environment
        os.chdir('/')
        os.setsid()
        os.umask(0)

        # do second fork
        try:
            pid = os.fork()
            if pid > 0:
                # exit from second parent
                sys.exit(0)
        except OSError as err:
            sys.stderr.write("""[Daemon Class] [Daemonize]: fork #2
			failed: {0}\n""".format(err))
            sys.exit(1)

        # redirect standard file descriptors
        si = open(os.devnull, 'r')
        so = open(self.logfile, 'a+')
        se = open(self.errfilePath, 'a+')

        os.dup2(si.fileno(), sys.stdin.fileno())
        os.dup2(so.fileno(), sys.stdout.fileno())
        os.dup2(se.fileno(), sys.stderr.fileno())

        sys.stdout.flush()
        sys.stderr.flush()

        # write pidfile
        atexit.register(self.delpid)

        pid = str(os.getpid())
        print "Process PID: %s" % pid
        with open(self.pidfile, 'w+') as f:
            f.write(pid + '\n')

    def delpid(self):
        """Method to delete the pid file"""
        os.remove(self.pidfile)

    def start(self):
        """Function to start the daemon.

        Calls the daemonize method to daemonize the process and then
        calls the run() method.

        Returns:
            void.
        """
        # Check for a pidfile to see if the daemon already runs
        try:
            with open(self.pidfile, 'r') as pf:
                # TODO - error handeling needed (case when process.pid file is
                # corrupt)
                pid = int(pf.read().strip())
        except IOError:
            pid = None

        if pid:
            message = "pidfile {0} already exist. " + \
                "Daemon already running?\n"
            sys.stderr.write(message.format(self.pidfile))
            sys.exit(1)

        # Start the daemon
        self.daemonize()
        self.run()

    def stop(self):
        """Function to Stop the daemon

        It recieves the PID from **pidfile** and signals it to kill

        Returns:
            void.
        """
        # Get the pid from the pidfile
        try:
            with open(self.pidfile, 'r') as pf:
                pid = int(pf.read().strip())
        except IOError:
            pid = None

        if not pid:
            message = "pidfile {0} does not exist. " + \
                "Daemon not running?\n"
            sys.stderr.write(message.format(self.pidfile))
            return  # not an error in a restart

        # Try killing the daemon process
        try:
            while 1:
                os.kill(pid, signal.SIGTERM)
                time.sleep(0.1)
        except OSError as err:
            e = str(err.args)
            if e.find("No such process") > 0:
                if os.path.exists(self.pidfile):
                    os.remove(self.pidfile)
            else:
                print(str(err.args))
                sys.exit(1)

        self._stop()

    def restart(self):
        """Function to Restart the daemon

        Calls **stop()** then **start()**. Simple right?
        """
        self.stop()
        self.start()

    def run(self):
        """
        Override this class method in subclass
        """

    # function to run once the stop is called
    def _stop(self):
        """
        Override this class method in subclass
        """
