"""Generic linux daemon base class for python 3.x."""
import sys, os, time, atexit, signal

class daemon:

	# Constructor
	# @param pidfile: file path for storing process information
	# @param logfile: file path to redirect stdout to
	# @param errfilePath: file path to redirect stderr to
	def __init__(self, pidfile, logfile, errfilePath):
		self.pidfile = pidfile
		self.logfile = logfile
		self.errfilePath = errfilePath

	# Deamonize class. UNIX double fork mechanism	
	def daemonize(self):
		try: 
			pid = os.fork() 
			if pid > 0:
				# exit first parent
				sys.exit(0) 
		except OSError as err: 
			sys.stderr.write('[Daemon Class] [Daemonize]: fork #1 failed: {0}\n'.format(err))
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
			sys.stderr.write('[Daemon Class] [Daemonize]: fork #2 failed: {0}\n'.format(err))
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
		with open(self.pidfile,'w+') as f:
			f.write(pid + '\n')
	
	# Function to delete the pid file
	def delpid(self):
		os.remove(self.pidfile)

	# Function to start the daemon
	def start(self):
		# Check for a pidfile to see if the daemon already runs
		try:
			with open(self.pidfile,'r') as pf:
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

	# Function to Stop the daemon
	def stop(self):
		# Get the pid from the pidfile
		try:
			with open(self.pidfile,'r') as pf:
				pid = int(pf.read().strip())
		except IOError:
			pid = None
	
		if not pid:
			message = "pidfile {0} does not exist. " + \
					"Daemon not running?\n"
			sys.stderr.write(message.format(self.pidfile))
			return # not an error in a restart

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
				print (str(err.args))
				sys.exit(1)

		self._stop()

	# Function to Restart the daemon
	def restart(self):
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

