import ConfigParser
from encodings.punycode import selective_find
import shutil
from symbol import import_as_name

__author__ = 'root'
import Container
import subprocess
import os

class ContainerDispatcher:
#
    def __init__(self):
        self.container_list=[]      #saved as a file at container_root_path
        self.num_containers = 0
        self.container_root_path = ''    #get from config file
        self.hackademic_root_path = ''   #get from config file

        self.getConfig()
        self.getContainerList()



    def getConfig(self):

        #open config file
        conf = open("container.conf","r")

        #read config into configparser
        configparser = ConfigParser.ConfigParser()

        return



    # def setConfig(self):
    #
    #     conf = open("container.conf",'w')
    #     configparser = ConfigParser.ConfigParser()
    #     return


    def saveContainerList(self):

        #open file
        containerlist_file = open('containerlist.txt','w')

        #load paths into containerlist
        for path in self.container_list:
            containerlist_file.write(path + '/n')

        #close file
        containerlist_file.close()
        return


    def getContainerList(self):

        #open containerfile
        containerlistfile = open("containerlist.txt",'r');

        #read individual paths from file
        for line in containerlistfile:
            self.container_list.append(line.strip('\n'))

        #close file
        containerlistfile.close()

        #check if folder exists if not remove the container from list
        for path in self.container_list:
            if not os.path.exists(path):
                self.container_list.remove(path)


        return





    def createContainer(self,name,ram):

        #create new folder at  container_root_path for new container
        src = self.hackadmic_root_path + '/master'
        dst = self.container_root_path + '/' + name    #replace some_id with random id for new container
        #shutil.copytree(src,dst)       may not copy special files
        subprocess.call('cp -a ' + src + ' ' + dst)

        #add to container list
        temp = Container(some_id,dst)
        self.container_list.append(temp)


        #create container using virt-install --noautoconsole ensures cirt-install does not open console for the container
        subprocess.call("virt-install -connect lxc:// --name ",name," --ram ",ram," --filesystem ",self.container_root_path,"/",name," --noautoconsole")


        #save changes to container_file
        self.saveContainerList();
        return temp


    def getFreeContainer(self):
        #return a container that is not being used
        for i in self.container_list:
            if i.isFree():
                #remove i from list
                temp = i
                self.container_list.remove(i)

                #update container as not free
                temp.free = false
                self.container_list.append(temp)

                #return container details
                return temp

        tempcontainer = self.createContainer()
        return tempcontainer


    def startall(self):
        for i in self.container_list:
            i.startContainer();



