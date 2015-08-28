#!/usr/bin/env python
import unittest
import os
import sys
import inspect
import shutil
import signal

currentdir = os.path.dirname(
    os.path.abspath(inspect.getfile(inspect.currentframe())))
parentdir = os.path.dirname(currentdir)
sys.path.insert(0, parentdir)

import daemon
import subprocess
import time
import json
from data import vagrantData

# Global funcitions needed for testing

# Gloabal variables
self_challengeId = None


def isProcessRunning(pid):
    try:
        os.kill(pid, 0)
    except OSError:
        return False
    else:
        return True


class TestDaemon(unittest.TestCase):
    g_basebox = 'ubuntu/trusty64'
    g_challengeId = None
    g_boxId = None

    def setUp(self):
        self.dirsToClean = []

        # Start the daemon
        self.currentdir = os.path.dirname(
            os.path.abspath(inspect.getfile(inspect.currentframe())))
        self.parentdir = os.path.dirname(self.currentdir)
        self.pidfile = self.parentdir + "/tmp/process.pid"

        # Do clean up tasks
        if os.path.exists(self.pidfile):
            # Kill the process first
            try:
                with open(self.pidfile, 'r') as pf:
                    pid = int(pf.read().strip())
            except IOError:
                pid = None

            if pid:
                # Try killing the daemon process
                try:
                    while 1:
                        os.kill(pid, signal.SIGTERM)
                        time.sleep(0.1)
                except OSError as err:
                    print "\nOSError While trying to kill existing daemon"
            os.remove(self.parentdir + "/tmp/process.pid")

        # Start the daemo via command line
        subprocess.call([self.parentdir + '/main.py', 'start'])

    def tearDown(self):
        # Stop the Daemon using command line
        subprocess.call([self.parentdir + '/main.py', 'stop'])

        # Do clean up tasks
        if os.path.exists(self.parentdir + "/tmp"):
            shutil.rmtree(self.parentdir + "/tmp")

        # for dirs in self.dirsToClean:
        #     if os.path.exists(dirs):
        #         shutil.rmtree(dirs)

    def test_daemon_active(self):
        # Get Process ID from ../tmp/process.pid file
        with open("../tmp/process.pid", 'r') as pf:
            pid = int(pf.read().strip())
            self.assertTrue(isProcessRunning(pid))

    def test_daemon_restart(self):
        subprocess.call([self.parentdir + '/main.py', 'restart'])
        with open("../tmp/process.pid", 'r') as pf:
            pid = int(pf.read().strip())
            self.assertTrue(isProcessRunning(pid))

    def test_communication(self):
        # Send a command via pipe
        # Make a connection to the daemon
        randStr = "qwerty122"
        o_pipename = "../tmp/pipe"
        i_pipename = "../tmp/" + randStr
        outfifo = open(o_pipename, 'w+')
        command = randStr + " info all box "
        outfifo.write(command)
        outfifo.close()

        # Now listen to a specific pipe
        if not os.path.exists(i_pipename):
            os.mkfifo(i_pipename)
        i_fifo = open(i_pipename, 'r')
        while True:
            line = i_fifo.readline()[:-1]
            if line:
                data = json.loads(line)
                self.assertEquals('success', data['message'])
                self.assertFalse(data['error'])

                os.unlink(i_pipename)
                break

    def test_create_box(self):
        # Send a command via pipe
        # Make a connection to the daemon
        randStr = "qwerty123"
        o_pipename = "../tmp/pipe"
        i_pipename = "../tmp/" + randStr
        outfifo = open(o_pipename, 'w+')
        command = randStr + " create " + self.currentdir + "/sample "
        print "COMMAND: %s" % command
        outfifo.write(command)
        outfifo.close()

        # Now listen to a specific pipe
        if not os.path.exists(i_pipename):
            os.mkfifo(i_pipename)
        i_fifo = open(i_pipename, 'r')
        while True:
            line = i_fifo.readline()[:-1]
            if line:
                data = json.loads(line)

                self.assertEquals('success', data['message'])
                self.assertEquals('ubuntu/trusty64', data['data']['basebox'])
                self.basebox = data['data']['basebox']
                self.__class__.g_boxId = data['data']['boxId']

                self.assertFalse(data['error'])

                challengeBoxPath = data['data'][
                    'basePath'] + "/" + data['data']['boxId']

                challengePath = data['data'][
                    'basePath'] + "/" + data['data']['boxId']

                # Check if challenge directory was created
                self.assertTrue(os.path.exists(challengePath))

                # Check if required files and folders were created
                self.assertTrue(
                    os.path.exists(challengePath + "/challenge.xml"))

                xmlData = vagrantData(challengePath + "/challenge.xml")
                xmlData.parse()

                self.assertTrue(os.path.exists(challengePath + "/files"))

                for _file in xmlData.files:
                    self.assertTrue(
                        os.path.exists(challengePath + "/files/" + _file.src))

                for _flag in xmlData.flags:
                    self.assertTrue(
                        os.path.exists(challengePath + "/files/" + _flag))

                for _script in xmlData.scripts:
                    self.assertTrue(
                        os.path.exists(challengePath + "/files/" + _script))

                self.assertTrue(os.path.exists(challengePath + "/manifests"))

                self.assertTrue(os.path.exists(challengePath + "/Vagrantfile"))

                self.assertTrue(os.path.exists(challengePath + "/.status"))

                with open(challengePath + "/.status", 'r') as status_file:
                    status = json.loads(status_file.readline())
                    self.assertEquals(
                        data['data']['basebox'], status['basebox'])
                    self.assertEquals(status['active'], 0)

                # TODO: verify more data as per xml provided

                # Add this directory to array for clearing at teardown
                self.dirsToClean.append(
                    data['data']['basePath'] + "/" + data['data']['boxId'])

                # Verify the files, scripts against the challenge XML
                os.unlink(i_pipename)
                break

    def test_start_box_fail(self):
        # Function to check for failure of a start command
        # By supplying a non existing box name

        boxId = 'nonExisitingBox'
        randStr = "qwerty123"
        o_pipename = "../tmp/pipe"
        i_pipename = "../tmp/" + randStr
        outfifo = open(o_pipename, 'w+')
        command = randStr + " start " + boxId + " "
        print "COMMAND: %s" % command
        outfifo.write(command)
        outfifo.close()

        # Now listen to a specific pipe
        if not os.path.exists(i_pipename):
            os.mkfifo(i_pipename)
        i_fifo = open(i_pipename, 'r')
        while True:
            line = i_fifo.readline()[:-1]
            if line:
                data = json.loads(line)
                self.assertTrue(data['error'])
                self.assertEquals('box for boxId '
                                  + boxId + ' not found',
                                  data['message'])

                os.unlink(i_pipename)
                break

    def test_start_box(self):
        self.__class__.g_basebox = 'ubuntu/trusty64'    # << TEMP
        self.__class__.g_boxId = 'ubuntu_trusty641'     # << TEMP

        # TODO: load data of '.status' of box we are using

        self.assertFalse(None == self.__class__.g_basebox)
        self.assertFalse(None == self.__class__.g_boxId)

        randStr = "qwerty123"
        o_pipename = "../tmp/pipe"
        i_pipename = "../tmp/" + randStr
        outfifo = open(o_pipename, 'w+')
        command = randStr + " start " + self.__class__.g_boxId + " "
        print "COMMAND: %s" % command
        outfifo.write(command)
        outfifo.close()

        # Now listen to a specific pipe
        if not os.path.exists(i_pipename):
            os.mkfifo(i_pipename)
        i_fifo = open(i_pipename, 'r')
        while True:
            line = i_fifo.readline()[:-1]
            if line:
                data = json.loads(line)
                self.assertFalse(data['error'])
                self.assertEquals(data['message'], 'success')
                self.__class__.g_challengeId = data['data']['challengeId']

                # TODO: Compare all the files and folders
                # TODO: Compare .success file of box and challenge
                # TODO: test for created subdomain
                os.unlink(i_pipename)
                break

    def test_stop_box_fails(self):
        # Function to check for failure of a start command
        # By supplying a non existing box name

        challengeId = 'nonExisitingBox'
        randStr = "qwerty123"
        o_pipename = "../tmp/pipe"
        i_pipename = "../tmp/" + randStr
        outfifo = open(o_pipename, 'w+')
        command = randStr + " stop " + challengeId + " "
        print "COMMAND: %s" % command
        outfifo.write(command)
        outfifo.close()

        # Now listen to a specific pipe
        if not os.path.exists(i_pipename):
            os.mkfifo(i_pipename)
        i_fifo = open(i_pipename, 'r')
        while True:
            line = i_fifo.readline()[:-1]
            if line:
                data = json.loads(line)
                self.assertTrue(data['error'])
                self.assertEquals('unable to stop '
                                  + challengeId + ', as it doesn\'t exist',
                                  data['message'])

                os.unlink(i_pipename)
                break

    def test_stop_box(self):
        self.assertFalse(None == self.__class__.g_challengeId)

        randStr = "qwerty123"
        o_pipename = "../tmp/pipe"
        i_pipename = "../tmp/" + randStr
        outfifo = open(o_pipename, 'w+')
        command = randStr + " stop " + self.__class__.g_challengeId + " "
        print "COMMAND: %s" % command
        outfifo.write(command)
        outfifo.close()

        # Now listen to a specific pipe
        if not os.path.exists(i_pipename):
            os.mkfifo(i_pipename)
        i_fifo = open(i_pipename, 'r')
        while True:
            line = i_fifo.readline()[:-1]
            if line:
                data = json.loads(line)
                self.assertEquals(
                    self.__class__.g_challengeId + ' deleted successfully', data['message'])
                self.assertEquals(
                    self.__class__.g_challengeId, data['data']['challenegeId'])
                self.assertFalse(data['error'])
                self.assertFalse(
                    os.path.exists('../data/challenges/' + self.__class__.g_challengeId))

                os.unlink(i_pipename)
                break

    def test_stb_infoallbox(self):
        randStr = "qwerty123"
        o_pipename = "../tmp/pipe"
        i_pipename = "../tmp/" + randStr
        outfifo = open(o_pipename, 'w+')
        command = randStr + " info all box "
        print "COMMAND: %s" % command
        outfifo.write(command)
        outfifo.close()

        # Now listen to a specific pipe
        if not os.path.exists(i_pipename):
            os.mkfifo(i_pipename)
        i_fifo = open(i_pipename, 'r')
        while True:
            line = i_fifo.readline()[:-1]
            if line:
                data = json.loads(line)
                self.assertEquals(data['message'], 'success')
                self.assertEquals(len(data['data']), 1)
                self.assertTrue(data['data'][0]['basebox'], 'ubuntu/trusty64')
                self.assertTrue(data['data'][0]['boxId'], 'ubuntu_trusty641')
                self.assertFalse(data['error'])

                os.unlink(i_pipename)
                break

    def test_stc_infoallchallenge(self):
        randStr = "qwerty123"
        o_pipename = "../tmp/pipe"
        i_pipename = "../tmp/" + randStr
        outfifo = open(o_pipename, 'w+')
        command = randStr + " info all challenge "
        print "COMMAND: %s" % command
        outfifo.write(command)
        outfifo.close()

        # Now listen to a specific pipe
        if not os.path.exists(i_pipename):
            os.mkfifo(i_pipename)
        i_fifo = open(i_pipename, 'r')
        while True:
            line = i_fifo.readline()[:-1]
            if line:
                data = json.loads(line)
                self.assertEquals(data['message'], 'success')
                self.assertEquals(len(data['data']), 1)
                self.assertEquals(data['data'][0]['status'], 'active')
                self.assertEquals(
                    data['data'][0]['basebox'], self.__class__.g_basebox)
                self.assertEquals(
                    data['data'][0]['boxId'], self.__class__.g_boxId)
                self.assertEquals(
                    data['data'][0]['challengeId'], self.__class__.g_challengeId)
                self.assertFalse(data['error'])

                os.unlink(i_pipename)
                break

    def test_std_infobox(self):
        randStr = "qwerty123"
        o_pipename = "../tmp/pipe"
        i_pipename = "../tmp/" + randStr
        outfifo = open(o_pipename, 'w+')
        command = randStr + " info box " + self.__class__.g_boxId + " "
        print "COMMAND: %s" % command
        outfifo.write(command)
        outfifo.close()

        # Now listen to a specific pipe
        if not os.path.exists(i_pipename):
            os.mkfifo(i_pipename)
        i_fifo = open(i_pipename, 'r')
        while True:
            line = i_fifo.readline()[:-1]
            if line:
                data = json.loads(line)
                self.assertEquals(data['message'], 'success')
                self.assertFalse(data['error'])
                self.assertEquals(
                    data['data']['basebox'], self.__class__.g_basebox)
                self.assertEquals(
                    data['data']['boxId'], self.__class__.g_boxId)

                os.unlink(i_pipename)
                break

    def test_ste_infochallenge(self):
        randStr = "qwerty123"
        o_pipename = "../tmp/pipe"
        i_pipename = "../tmp/" + randStr
        outfifo = open(o_pipename, 'w+')
        command = randStr + " info challenge " + \
            self.__class__.g_challengeId + " "
        print "COMMAND: %s" % command
        outfifo.write(command)
        outfifo.close()

        # Now listen to a specific pipe
        if not os.path.exists(i_pipename):
            os.mkfifo(i_pipename)
        i_fifo = open(i_pipename, 'r')
        while True:
            line = i_fifo.readline()[:-1]
            if line:
                data = json.loads(line)
                self.assertEquals(data['message'], 'success')
                self.assertFalse(data['error'])
                self.assertEquals(
                    data['data']['basebox'], self.__class__.g_basebox)
                self.assertEquals(
                    data['data']['boxId'], self.__class__.g_boxId)
                self.assertEquals(
                    data['data']['challengeId'], self.__class__.g_challengeId)

                os.unlink(i_pipename)
                break


class TestXMLParser(unittest.TestCase):

    def setUp(self):
        # Start the daemon
        self.currentdir = os.path.dirname(
            os.path.abspath(inspect.getfile(inspect.currentframe())))
        self.parentdir = os.path.dirname(self.currentdir)
        self.xmlfilepath = self.currentdir + "/sample/challenge.xml"
        self.d = vagrantData(self.xmlfilepath)

        self.assertTrue(self.d.parse())

    # Check if all values loaded from xml file are consistent to set values
    def test_check_vals(self):
        self.assertEquals('ubuntu/trusty64', self.d.baseBox)
        self.assertEquals('default.pp', self.d.puppetManifest)

        # Files
        self.assertEquals(3, len(self.d.files))
        self.assertEquals('/flags/flag1', self.d.files[0].src)
        self.assertEquals('/tmp/test/flag', self.d.files[0].dest)
        self.assertFalse(self.d.files[0].isADir)

        self.assertEquals('/code', self.d.files[2].src)
        self.assertEquals('/etc/www/code', self.d.files[2].dest)
        self.assertTrue(self.d.files[2].isADir)

        # Flags
        self.assertEquals(2, len(self.d.flags))
        self.assertEquals('flags/flag1', self.d.flags[0])
        self.assertEquals('flags/flag2', self.d.flags[1])

        # Scripts
        self.assertEquals(2, len(self.d.scripts))
        self.assertEquals('script/sh1.sh', self.d.scripts[0])
        self.assertEquals('script/sh2.sh', self.d.scripts[1])


if __name__ == '__main__':
    suite = unittest.TestLoader().loadTestsFromTestCase(TestDaemon)
    unittest.TextTestRunner(verbosity=2).run(suite)

    suite2 = unittest.TestLoader().loadTestsFromTestCase(TestXMLParser)
    unittest.TextTestRunner(verbosity=2).run(suite2)
