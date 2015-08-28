"""Class to deal with the requested command

.. module:: cmd
    :platform: unix
    :synopsis: it processes the command and takes action based on that

.. moduleauthor:: Minhaz A V <minhazav@gmail.com>
"""

import os
import sys
import time
import json
import data
import subprocess
import shutil
import re
import random
import string
import threading
from threading import Thread
from data import vagrantData


class FlagFileNotFound (Exception):
    pass


class helper:
    """helper class to bundle certain required methods"""

    @staticmethod
    def copy(src, dest):
        """Global function to copy file or directory.

        Copies files or directory from source to destination.

        Args:
            src (str): source path of file or dir
            dest (str): destination path of file or dir
        """
        try:
            shutil.copytree(src, dest)
        except OSError as e:
            # If the error was caused because the source wasn't a directory
            if e.errno == errno.ENOTDIR:
                shutil.copy(src, dest)
            else:
                print('Directory not copied. Error: %s' % e)

    @staticmethod
    def getRootFolder(path):
        """Global function to get root of a relative path

        >>getRootFolder("./dir1/dir2/file")
        dir1

        >>getRootFolder("/dir1")
        dir1

        Args:
            path (str): relative path of a file or dir

        Returns:
            str. The root path of given relative path
        """
        arr = path.split('/')
        if arr[0] == '':
            try:
                return arr[1]
            except:
                return ''
        return arr[0]

    @staticmethod
    def getRandStr(len):
        """Function to get a random string of required length

        Args:
            len (str): the length of random string required

        Returns:
            str. The random string
        """
        return ''.join(random.SystemRandom().choice(
            string.ascii_lowercase + string.ascii_uppercase + string.digits) for _ in range(len))

    @staticmethod
    def randomizeFlaginFile(path):
        """Global function to randomize a flag in a file

        The function will read the file and change its value, by
        a random string of same length random string contain uppercase
        alphabets, lowercase alphabets
        AND digits

        Args:
            path (str): the absolute path of the flag
        """
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
        return _flag


class commandproc:
    """Class to deal with requested command.

    The command looks like: **<pipename> <command>**. This class
    processes the <command> and send reply via <pipename>

    Accepted commands are as follows:
     - <pipename> create <challenge path>
     - <pipename> start <box ID>
     - <pipename> start <box ID>
     - <pipename> destroy all
     - <pipename> info all box
     - <pipename> info all challenge
     - <pipename> info box <box ID>
     - <pipename> info box <challnege ID>

    Response is sent back via <pipename> in **JSON** format.
    """

    # Defining the main output variable to be sent back to the
    # system. It will be passed by reference to all classes
    out = {}

    # TODO: make this to load from 3rd part
    privateIP = ''

    def vagrantAddBox(self, boxname):
        """Function to add a vagrant box if not exists.

        Args:
            boxname (str): the name of box, ex ubuntu/trusty64
        """
        try:
            op = subprocess.check_call(
                ['vagrant', 'box', 'add', boxname])
        except Exception as ex:
            print """[%s] Exception Occured while adding box {%s},
            Ex: {%s}""" % (time.time(), boxname, ex)

    def vagrantInit(self, boxname, boxId):
        """Function to call init method in the current directory.

        Does the Vagrant init thingy.

        Args:
            boxname (str): the name of box, ex ubuntu/trusty64
            boxID (str): the id of box, retrieved during create command

        """
        self.lock.acquire()
        try:
            os.chdir("./data/boxes/" + boxId)
            op = subprocess.check_output(['vagrant', 'init', boxname])
            print "[%s] Vagrant init called. Output: %s" % (time.time(), op)
        except Exception as ex:
            print """[%s] Exception Occured while initialising vagrant box,
            Ex: {%s}""" % (time.time(), ex)

            os.chdir(self.currentPath)
            self.lock.release()
            return False

        os.chdir(self.currentPath)
        self.lock.release()
        return True

    def VagrantUp(self, challengeId):
        """Function to start a vagrant box in current dir.

        Starts the VM

        Args:
            challengeId (str): the challengeId retrived during create command
        """
        self.lock.acquire()
        try:
            os.chdir("./data/challenges/" + challengeId)
            subprocess.call(['vagrant', 'up'])
        except Exception as ex:
            os.chdir(self.currentPath)

            print """[%s] Exception Occured while vagrant up,
            Ex: {%s}""" % (time.time(), ex)

        os.chdir(self.currentPath)
        self.lock.release()

    def VagrantStop(self, challengeId):
        """Function to stop a vagrant box in current dir.

        Stops the VM

        Args:
           challengeId (str): the challengeId retrived during create command 
        """ 
        self.lock.acquire()
        try:
            os.chdir("./data/challenges/" + challengeId)
            op = subprocess.check_output(['vagrant', 'destroy', '-f'])
            print "[%s] Vagrant destroy called. Output: %s" % (time.time(), op)
        except Exception as ex:
            print """[%s] Exception Occured while vagrant up,
            Ex: {%s}""" % (time.time(), ex)

        os.chdir(self.currentPath)
        self.lock.release()

    def createVagrantFile(self, path):
        """Function to create a vagrant file from template.

        creates the vagrant file for a challenge based on template
        and data loaded from challenge.xml

        Args:
            path (str): path of the challenge directory
        """

        with open("./data/.VagrantFile", 'r') as f:
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
            scriptConfigScript += scriptConfig.replace(
                '~src~', prefix + _script) + "\n  "
        data = data.replace(m.group(0), scriptConfigScript)

        with open(path + "/Vagrantfile", 'w') as f:
            f.write(data)

    def modifyVagrantFile(self, path, hostname):
        """Function to modify a vagrant file when Start command is sent.

        This further modifies the Vagrant file with host and private IP information.

        Args:
            path (str): the path of challenge dir
            hostname (str): the hostname for the VM

        """
        print "domain Name = %s ; " % self.domain
        with open(path, 'r') as f:
            data = f.read()

        data = data.replace(
            '~hostname~', hostname.replace('_', '.') + '.' + self.domain)
        data = data.replace('~private_ips~', self.privateIP)
        with open(path, 'w') as f:
            f.write(data)

    def classifier(self, command):
        """Parses the command and takes action based on that

        Args:
            command (str): the command
        """
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
                if not os.path.exists("./data"):
                    os.makedirs("./data")

                tmpCurrentDir = "./data"

                if not os.path.exists(tmpCurrentDir + "/boxes"):
                    os.makedirs(tmpCurrentDir + "/boxes")
                tmpCurrentDir += "/boxes"

                challengeIdBase = xmlData.baseBox.replace('/', '_')
                i = 1
                challengeId = challengeIdBase + str(i)
                while os.path.exists(tmpCurrentDir + "/" + challengeId):
                    i += 1
                    challengeId = challengeIdBase + str(i)

                data['boxId'] = challengeId
                os.makedirs(tmpCurrentDir + "/" + challengeId)
                tmpCurrentDir += "/" + challengeId

                # Init vagrant at that directory
                if not self.vagrantInit(xmlData.baseBox, challengeId):
                    self.out['error'] = True
                    self.out['message'] = 'vagrant init failed'
                else:
                    shutil.copyfile(xmlFile, tmpCurrentDir + "/challenge.xml")
                    # create the files directory and copy the files, to that directory
                    # In same manner as provided in xml
                    os.makedirs(tmpCurrentDir + "/files")
                    directoriesCopies = []

                    # Copy the files
                    for _file in xmlData.files:
                        if helper.getRootFolder(_file.src) not in directoriesCopies:
                            # Copy that folder to this folder
                            directory = helper.getRootFolder(_file.src)
                            helper.copy(
                                challengePath + "/" + directory, tmpCurrentDir + "/files/" + directory)
                            directoriesCopies.append(directory)

                    # Copy the scripts
                    for _script in xmlData.scripts:
                        if helper.getRootFolder(_script) not in directoriesCopies:
                            # Copy that folder to this folder
                            directory = helper.getRootFolder(_script)
                            helper.copy(
                                challengePath + "/" + directory, tmpCurrentDir + "/files/" + directory)
                            directoriesCopies.append(directory)

                    # Copy the manifest file
                    if not xmlData.puppetManifest == '':
                        os.makedirs(tmpCurrentDir + "/manifests")
                        shutil.copyfile(
                            challengePath + "/" + xmlData.puppetManifest, tmpCurrentDir + "/manifests/default.pp")

                    if not xmlData.modules == None:
                        helper.copy(
                            challengePath + "/" + xmlData.modules, tmpCurrentDir + "/modules")

                    # Modify the vagrantFile according to xml data
                    self.createVagrantFile(tmpCurrentDir)

                    # Create a .status file
                    status = {}
                    status['basebox'] = xmlData.baseBox
                    status['active'] = 0
                    with open(tmpCurrentDir + '/.status', 'w') as o_file:
                        o_file.write(json.dumps(status))

                    self.out['data'] = data
                    self.out['message'] = 'success'

        elif "start" == cmdString:
            _boxId = args[2]

            if not os.path.exists("./data"):
                self.out['error'] = True
                self.out[
                    'message'] = 'data directory does not exist. challenge cannot be created'
            else:
                tmpCurrentDir = "./data"
                if not os.path.exists(tmpCurrentDir + "/boxes"):
                    self.out['error'] = True
                    self.out[
                        'message'] = 'box for boxId %s not found' % _boxId
                elif not os.path.exists(tmpCurrentDir + "/boxes/" + _boxId):
                    self.out['error'] = True
                    self.out[
                        'message'] = 'box for boxId %s not found' % _boxId
                else:
                    if not os.path.exists(tmpCurrentDir + "/challenges"):
                        os.makedirs(tmpCurrentDir + "/challenges")

                    _challengeID = _boxId + helper.getRandStr(5)
                    while os.path.exists(tmpCurrentDir + "/challenges/" + _challengeID):
                        _challengeID = _boxId + helper.getRandStr(5)

                    # Copy all files to this challenge directory
                    helper.copy(
                        tmpCurrentDir + "/boxes/" + _boxId,
                        tmpCurrentDir + "/challenges/" + _challengeID)

                    # load the xml in this directory to memory
                    tmpCurrentDir += "/challenges/" + _challengeID
                    xmlFile = tmpCurrentDir + "/challenge.xml"
                    xmlData = vagrantData(xmlFile)
                    xmlData.parse()

                    # verify the content
                    # check for flags
                    err = False
                    fileNotFound = []

                    for flags in xmlData.flags:
                        if not os.path.exists(tmpCurrentDir + "/files/" + flags):
                            err = True
                            fileNotFound.append(flags)

                    # check for files
                    for files in xmlData.files:
                        if not os.path.exists(tmpCurrentDir + "/files/" + files.src):
                            print "[%s] file not found %s" % (time.time(),
                                                              tmpCurrentDir + "/files/" + files.src)

                            err = True
                            fileNotFound.append(files.src)

                    # check for scripts
                    for script in xmlData.scripts:
                        if not os.path.exists(tmpCurrentDir + "/files/" + script):
                            print "[%s] script not found %s" % (time.time(),
                                                                tmpCurrentDir + "/files/" + script)
                            err = True
                            fileNotFound.append(script)

                    # check for manifests
                    if not os.path.exists(tmpCurrentDir + "/manifests/default.pp"):
                        err = True
                        fileNotFound.append(xmlData.puppetManifest)

                    # local variable to store flag information
                    flag_info = []

                    if True == err:
                        self.out['err'] = True
                        self.out[
                            'message'] = 'following files were not found: \n'
                        for _file in fileNotFound:
                            self.out['message'] += _file + '\n'
                    else:
                        # modify the flag files
                        for flag in xmlData.flags:
                            _new_flag = helper.randomizeFlaginFile(
                                tmpCurrentDir + "/files/" + flag)
                            flag_info.append({"/files/" + flag: _new_flag})

                        # Subdomain thingy
                        print "modifying the vagrant file for network info"
                        self.modifyVagrantFile(
                            tmpCurrentDir + "/Vagrantfile", _challengeID)

                        # start the box
                        print "starting vagrant box"
                        self.VagrantUp(_challengeID)

                        # Update basebox status
                        with open("./data/boxes/" + _boxId + "/.status", 'r+') as bStatus:
                            baseboxStatus = json.loads(bStatus.readline())
                            baseboxStatus['active'] += 1
                            bStatus.seek(0)
                            bStatus.write(json.dumps(baseboxStatus))
                            bStatus.truncate()
                            bStatus.close()

                            with open(tmpCurrentDir + "/.status", 'w') as cStatus:
                                status = {
                                    'status': 'active',
                                    'basebox': baseboxStatus['basebox'],
                                    'boxId': _boxId
                                }
                                cStatus.write(json.dumps(status))

                    self.out['data'] = {}
                    self.out['data']['challengeId'] = _challengeID
                    self.out['data']['flags'] = flag_info
                    self.out['message'] = 'success'

        elif "stop" == cmdString:
            _challengeID = args[2]
            if not os.path.exists("./data/challenges/" + _challengeID):
                self.out['error'] = True
                self.out[
                    'message'] = 'unable to stop %s, as it doesn\'t exist' % _challengeID
            else:
                tmpCurrentDir = "./data/challenges/" + _challengeID

                # get the box ID
                with open(tmpCurrentDir + '/.status', 'r') as cStatus:
                    try:
                        boxId = json.loads(cStatus.readline())['boxId']
                        cStatus.close()

                        # Update basebox status
                        with open("./data/boxes/" + boxId + "/.status", 'r+') as bStatus:
                            baseboxStatus = json.loads(bStatus.readline())
                            baseboxStatus['active'] -= 1
                            bStatus.seek(0)
                            bStatus.write(json.dumps(baseboxStatus))
                            bStatus.truncate()
                    except:
                        print """[%s] found no boxId in .status file for 
                        challengeId: %s""" % (time.time(), _challengeID)

                # Stop the VM
                self.VagrantStop(_challengeID)

                # delete the challenegeID Dir
                shutil.rmtree(tmpCurrentDir)
                self.out['message'] = _challengeID + ' deleted successfully'
                self.out['data'] = {}
                self.out['data']['challenegeId'] = _challengeID

        elif "info" == cmdString:
            invalidCommand = False

            if "all" == args[2]:
                if "box" == args[3]:
                    # change this to showing all hackademic
                    # boxes added to system by parsing challenge.xml
                    # in each box that exist in ./data/boxes directory

                    self.out['data'] = []
                    tmpCurrentDir = "./data/boxes"

                    for _dir in os.listdir(tmpCurrentDir):
                        if os.path.isdir(tmpCurrentDir + "/" + _dir):
                            with open(tmpCurrentDir + "/" + _dir + "/.status", 'r') as status:
                                statusData = json.loads(status.readline())
                                statusData['last_modified'] = os.stat(
                                    tmpCurrentDir + "/" + _dir).st_mtime
                                statusData['boxId'] = _dir
                                self.out['data'].append(statusData)

                    self.out['message'] = 'success'

                elif "challenge" == args[3]:
                    # for each dir in ./data/challeneges
                    # Get status and print it back to client

                    self.out['data'] = []
                    tmpCurrentDir = "./data/challenges"

                    for _dir in os.listdir(tmpCurrentDir):
                        if os.path.isdir(tmpCurrentDir + "/" + _dir):
                            with open(tmpCurrentDir + "/" + _dir + "/.status", 'r') as status:
                                statusData = json.loads(status.readline())
                                statusData['last_modified'] = os.stat(
                                    tmpCurrentDir + "/" + _dir).st_mtime
                                statusData['challengeId'] = _dir
                                self.out['data'].append(statusData)

                    self.out['message'] = 'success'

                else:
                    invalidCommand = True

            elif "box" == args[2]:
                boxId = args[3]

                tmpCurrentDir = "./data/boxes/" + boxId
                self.out['data'] = []
                if not os.path.exists(tmpCurrentDir):
                    self.out['error'] = True
                    self.out['message'] = 'box doesn\'t exist'
                elif not os.path.exists(tmpCurrentDir + "/.status"):
                    self.out['error'] = True
                    self.out[
                        'message'] = 'no status information for the box available'
                else:
                    with open(tmpCurrentDir + "/.status", 'r') as status:
                        self.out['data'] = json.loads(status.readline())
                        self.out['data']['last_modified'] = os.stat(
                            tmpCurrentDir).st_mtime
                        self.out['data']['boxId'] = boxId
                        self.out['error'] = False
                        self.out['message'] = 'success'

            elif "challenge" == args[2]:
                challengeId = args[3]

                tmpCurrentDir = "./data/challenges/" + challengeId
                self.out['data'] = []
                if not os.path.exists(tmpCurrentDir):
                    self.out['error'] = True
                    self.out['message'] = 'challenge doesn\'t exist'
                elif not os.path.exists(tmpCurrentDir + "/.status"):
                    self.out['error'] = True
                    self.out[
                        'message'] = 'no status information for the challenge available'
                else:
                    with open(tmpCurrentDir + "/.status", 'r') as status:
                        self.out['data'] = json.loads(status.readline())
                        self.out['data']['last_modified'] = os.stat(
                            tmpCurrentDir).st_mtime
                        self.out['data']['challengeId'] = challengeId
                        self.out['error'] = False
                        self.out['message'] = 'success'

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

        elif "destroy" == cmdString:
            self.data = {}
            if "all" == args[2]:
                print subprocess.check_output(['pwd'])
                for _dir in os.listdir("./data/challenges"):
                    if os.path.isdir("./data/challenges/" + _dir):
                        self.VagrantStop(_dir)
                        shutil.rmtree("./data/challenges/" + _dir)

                # reset 'active' in .status of everybox to 0
                for _dir in os.listdir("./data/boxes"):
                    if not os.path.isdir("./data/boxes/" + _dir):
                        continue
                    with open("./data/boxes/" + _dir + "/.status", 'r+') as status:
                        jStatus = json.loads(status.readline())
                        jStatus['active'] = 0
                        status.seek(0)
                        status.write(json.dumps(jStatus))
                        status.truncate()

                self.out['error'] = False
                self.out['message'] = 'all boxes destroyed'

            else:
                self.out['error'] = True
                self.out['message'] = 'invalid command'

        else:
            self.out['error'] = True
            self.out['error'] = 'Invalid command'
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

    def __init__(self, command, ip, domain):
        """Constructor: Calls the classifier method in new thread

        It recieves the command from pipes class and calls the classifier
        method to deal with it in a new thread.

        Args:
            command (str): the command requested
            ip (str): the ip to be allocated in case of start command.
            domain (str): the domain of the host machine.
        """
        self.currentPath = os.path.dirname(os.path.realpath(__file__))
        self.lock = threading.Lock()

        self.privateIP = ip
        self.domain = domain

        thrd = Thread(target=self.classifier, args=(command, ))
        thrd.start()
