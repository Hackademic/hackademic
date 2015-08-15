# Code to deal with the requested command
import os
import sys
import time
import json
import data
import subprocess
import shutil
import re
from threading import Thread
from data import vagrantData
import random
import string


class FlagFileNotFound (Exception):
    pass


class helper:

    @staticmethod
    # Global function to copy file or directory
    def copy(src, dest):
        try:
            shutil.copytree(src, dest)
        except OSError as e:
            # If the error was caused because the source wasn't a directory
            if e.errno == errno.ENOTDIR:
                shutil.copy(src, dest)
            else:
                print('Directory not copied. Error: %s' % e)

    @staticmethod
    # Global function to get root of a relative path
    def getRootFolder(path):
        arr = path.split('/')
        if arr[0] == '':
            try:
                return arr[1]
            except:
                return ''
        return arr[0]

    @staticmethod
    def getRandStr(len):
        return ''.join(random.SystemRandom().choice(
            string.ascii_lowercase + string.ascii_uppercase + string.digits) for _ in range(len))

    @staticmethod
    # Global function to randomize a flag in a file
    # @param: the absolute path of the flag
    # The function will read the file and change its value, by
    # a random string of same length
    # random string contain uppercase alphabets, lowercase alphabets
    # AND digits
    def randomizeFlaginFile(path):
        if not os.path.exists(path):
            raise FlagFileNotFound(
                'no file was found at path given for flag file')

        _flag = ''
        with open(path, 'r+') as _file:
            flag = _file.readline()
            _len = len(flag)
            _flag = helper.getRandStr(_len)

            _file.seek(0)
            _file.write(_flag)
            _file.truncate()


class commandproc:

    # Defining the main output variable to be sent back to the
    # system. It will be passed by reference to all classes
    out = {}

    # Function to add a vagrant box if not exists
    def vagrantAddBox(self, boxname):
        try:
            op = subprocess.check_call(
                ['vagrant', 'box', 'add', boxname])
        except Exception as ex:
            print """[%s] Exception Occured while adding box {%s},
            Ex: {%s}""" % (time.time(), boxname, ex)

    # Function to call init method in the current directory
    def vagrantInit(self, boxname):
        try:
            op = subprocess.check_output(['vagrant', 'init', boxname])
        except Exception as ex:
            print """[%s] Exception Occured while initialising vagrant box,
            Ex: {%s}""" % (time.time(), ex)

            return False

        return True

    # Function to start a vagrant box in current dir
    def VagrantUp(self):
        try:
            op = subprocess.check_output(['vagrant', 'up'])
            print "[%s] Vagrant up called. Output: %s" % (time.time(), op)
        except Exception as ex:
            print """[%s] Exception Occured while vagrant up,
            Ex: {%s}""" % (time.time(), ex)

    # Function to stop a vagrant box in current dir
    def VagrantStop(self):
        try:
            op = subprocess.check_output(['vagrant', 'destroy', '-f'])
            print "[%s] Vagrant destroy called. Output: %s" % (time.time(), op)
        except Exception as ex:
            print """[%s] Exception Occured while vagrant up,
            Ex: {%s}""" % (time.time(), ex)

    # Function to create a vagrant file from template
    def createVagrantFile(self):
        with open("../../.VagrantFile", 'r') as f:
            data = f.read()

        data = data.replace('~basebox~', self.xmlData.baseBox)

        # Replace files with files
        m = re.search('\~files\~\\n(.*)\\n.*\~files\~', data)
        fileConfig = m.group(1)
        fileConfigScript = ''
        for _file in self.xmlData.files:
            if (_file.src[0] == '/'):
                prefix = 'files'
            else:
                prefix = 'files/'
            fileConfigScript += fileConfig.replace(
                '~src~', prefix + _file.src).replace('~dest~', _file.dest) + "\n"
        data = data.replace(m.group(0), fileConfigScript)

        # Replace scripts with scripts
        m = re.search('\~shell\~\\n(.*)\\n.*\~shell\~', data)
        scriptConfig = m.group(1)
        scriptConfigScript = ''
        for _script in self.xmlData.scripts:
            if (_script[0] == '/'):
                prefix = 'files'
            else:
                prefix = 'files/'
            fileConfigScript += fileConfig.replace(
                '~src~', prefix + _script) + "\n  "
        data = data.replace(m.group(0), scriptConfigScript)

        with open('VagrantFile', 'w') as f:
            f.write(data)

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
        os.chdir(self.currentPath)

        cmdString = args[1]
        if "create" == cmdString:
            """
            TASK - read xml file and create a box,return meaning full information
            """

            challengePath = args[2]
            xmlFile = challengePath + "/challenge.xml"
            # TODO verify the type of data ^
            xmlData = vagrantData(xmlFile)
            self.xmlData = xmlData
            success = xmlData.parse()
            if success is not True:
                self.out['error'] = True
                self.out['message'] = """Unable to parse provided XML!
                Error: %s """ % str(success)
            else:
                # TODO: verify the data loaded from XML
                data = {}
                data['basebox'] = xmlData.baseBox
                data['basePath'] = self.currentPath + "/data/boxes"

                # Add a base box if not exists
                self.vagrantAddBox(xmlData.baseBox)

                # Create a challenge directory
                os.chdir(self.currentPath)
                if not os.path.exists("./data"):
                    print "making dir ./data"
                    os.makedirs("./data")

                os.chdir("./data")
                if not os.path.exists("./boxes"):
                    os.makedirs("./boxes")
                os.chdir("./boxes")

                challengeIdBase = xmlData.baseBox.replace('/', '_')
                i = 1
                challengeId = challengeIdBase + str(i)
                while os.path.exists(challengeId):
                    i += 1
                    challengeId = challengeIdBase + str(i)

                data['challengeId'] = challengeId
                os.makedirs(challengeId)
                os.chdir("./" + challengeId)

                # Init vagrant at that directory
                if not self.vagrantInit(xmlData.baseBox):
                    self.out['error'] = True
                    self.out['message'] = 'vagrant init failed'
                else:
                    shutil.copyfile(xmlFile, "challenge.xml")
                    # create the files directory and copy the files, to that directory
                    # In same manner as provided in xml
                    os.makedirs("files")
                    os.chdir("./files")
                    directoriesCopies = []

                    # Copy the files
                    for _file in xmlData.files:
                        if helper.getRootFolder(_file.src) not in directoriesCopies:
                            # Copy that folder to this folder
                            directory = helper.getRootFolder(_file.src)
                            helper.copy(
                                challengePath + "/" + directory, directory)
                            directoriesCopies.append(directory)

                    # Copy the scripts
                    for _script in xmlData.scripts:
                        if helper.getRootFolder(_script) not in directoriesCopies:
                            # Copy that folder to this folder
                            directory = helper.getRootFolder(_script)
                            helper.copy(
                                challengePath + "/" + directory, directory)
                            directoriesCopies.append(directory)

                    # Copy the manifest file
                    os.chdir("../")
                    if not xmlData.puppetManifest == '':
                        os.makedirs("manifests")
                        shutil.copyfile(
                            challengePath + "/" + xmlData.puppetManifest, "./manifests/default.pp")

                    # Modify the vagrantFile according to xml data
                    self.createVagrantFile()
                    self.out['data'] = data
                    self.out['message'] = 'success'

        elif "start" == cmdString:
            _boxId = args[2]

            if not os.path.exists("./data"):
                self.out['error'] = True
                self.out[
                    'message'] = 'data directory does not exist. challenge cannot be created'
            else:
                os.chdir("./data")
                if not os.path.exists("./boxes"):
                    self.out['error'] = True
                    self.out[
                        'message'] = 'box for boxId %s not found' % _boxId
                elif not os.path.exists("./boxes/" +_boxId):
                    self.out['error'] = True
                    self.out[
                        'message'] = 'box for boxId %s not found' % _boxId
                else:
                    if not os.path.exists("./challenges"):
                        os.makedirs("challenges")

                    _challengeID = _boxId + helper.getRandStr(5)
                    while os.path.exists("./challenges/" + _challengeID):
                        _challengeID = _boxId + helper.getRandStr(5)

                    # Copy all files to this challenge directory
                    helper.copy(
                        "./boxes/" + _boxId, "./challenges/" + _challengeID)

                    # load the xml in this directory to memory
                    os.chdir("./challenges/" + _challengeID)
                    xmlFile = "./challenge.xml"
                    xmlData = vagrantData(xmlFile)
                    xmlData.parse()

                    # verify the content
                    # check for flags
                    err = False
                    fileNotFound = []

                    for flags in xmlData.flags:
                        if not os.path.exists("./files/" + flags):
                            err = True
                            fileNotFound.append(flags)

                    # check for files
                    for files in xmlData.files:
                        if not os.path.exists("./files/" + files.src):
                            err = True
                            fileNotFound.append(files.src)

                    # check for scripts
                    for script in xmlData.scripts:
                        if not os.path.exists("./files/" + script):
                            err = True
                            fileNotFound.append(script)

                    # check for manifests
                    if not os.path.exists("./manifests/" + xmlData.puppetManifest):
                        err = True
                        fileNotFound.append(xmlData.puppetManifest)

                    if True == err:
                        self.out['err'] = True
                        self.out[
                            'message'] = 'following files were not found: \n'
                        for _file in fileNotFound:
                            self.out['message'] += _file + '\n'
                    else:
                        # modify the flag files
                        for flag in xmlData.flags:
                            helper.randomizeFlaginFile("./files/" + flag)

                        # TODO port forwarding / subdomain thingy

                        # start the box
                        self.VagrantUp()

                    self.out['data'] = {}
                    self.out['data']['challengeId'] = _challengeID
                    self.out['message'] = 'success'

        elif "stop" == cmdString:
            _challengeID = args[2]
            if not os.path.exists("./data/challenges/" + _challengeID):
                self.out['error'] = True
                self.out[
                    'message'] = 'unable to stop %s, as it doesn\'t exist' % _challengeID
            else:
                os.chdir("./data/challenges/" + _challengeID)

                # Stop the VM
                self.VagrantStop()

                os.chdir("../")

                # delete the challenegeID Dir
                shutil.rmtree("./" + _challengeID)
                self.out['message'] = _challengeID + ' deleted successfully'
                self.out['data'] = {}
                self.out['data']['challenegeID'] = _challengeID

        elif "info" == cmdString:
            invalidCommand = False

            if "all" == args[2]:
                if "box" == args[3]:
                    # TODO change this to showing all hackademic
                    # boxes added to system by parsing challenge.xml
                    # in each box that exist in ./data/boxes directory

                    # Code to list all boxes in system
                    op = subprocess.check_output(['vagrant', 'box', 'list'])
                    op_arr = op.split('\n')
                    if len(op_arr) > 0:
                        del op_arr[-1]

                    self.out['data'] = op_arr
                    self.out['message'] = 'success'

                elif "challenge" == args[3]:
                    print "info all challenge called"
                    # TODO for each dir in ./data/challeneges
                    # Get status and print it back to client

                else:
                    invalidCommand = True

            elif "box" == args[2]:
                boxId = args[3]
                print "info box <box id> called"

            elif "challenge" == args[2]:
                challengeId = args[3]
                print "info challenge <challenge id> called"

            else:
                invalidCommand = True

            if True == invalidCommand:
                self.out['error'] = True
                self.out['message'] = """usage of info command:
                info all box
                info all challenge
                info box <box ID>
                info challenge <challenge ID>
                """

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
