# Code to deal with the requested command
import os
import sys
import time
import json
import data
from threading import Thread
from data import vagrantData


class commandproc:

	# Defining the main output variable to be sent back to the
	# system. It will be passed by reference to all classes
	out = {}

	def classifier(self, command):
		args = command.split(' ')

		if len(args) < 3:
			print """[%s] Invalid command: {%s} sent to daemon.
			Skipping the command!""" % (time.time(), command)
			return

		self.outPipe = self.currentPath + "/tmp/" + args[0]

		# Init entries to out dictionery
		self.out['error'] = False
		self.out['message'] = ''

		# ------------------------------------------------------------------------
		# Code to preform requested action
		# ------------------------------------------------------------------------

		cmdString = args[1]
		if "create" == cmdString:
			"""
			TASK - read xml file and create a box,return meaning full information
			"""
			xmlFile = args[2]  # TODO verify the type of data?
			xmlData = vagrantData(xmlFile)
			success = xmlData.parse()
			if success is not True:
				self.out['error'] = True
				self.out['message'] = """Unable to parse provided XML!
				Error: %s""" % str(success)
			else:
				print "Creating a vagrant box..."
				# TODO - accordingly create a vagrant box now
		if "start" == cmdString:
			print "start command triggered"
			# TASKS:
			# Create a clone directory of the challenge directory
			# Start VagrantBox for this one
			# Return the ID
		if "stop" == cmdString:
			print "stop command triggered"

		# elif "start" == cmdString:

		# ------------------------------------------------------------------------
		# Code to respond back to the client
		# ------------------------------------------------------------------------
		# make a output fifo pipe
		if not os.path.exists(self.outPipe):
			os.mkfifo(self.outPipe)

		output = json.dumps(self.out) + ' '

		self.outfifo = open(self.outPipe, 'w+')
		self.outfifo.write(output)
		self.outfifo.close()
		print """[%s] Output sent back to client using pipe:
		%s""" % (time.time(), self.outPipe)

	# Constructor: Calls the classifier method in new thread
	def __init__(self, command):
		self.currentPath = os.path.dirname(os.path.realpath(__file__))
		thrd = Thread(target=self.classifier, args=(command, ))
		thrd.start()
