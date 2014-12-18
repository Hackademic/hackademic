import ConfigParser
import Forwarder

__author__ = 'root'
import Container
import subprocess
import os

class ContainerDispatcher:
#
    def __init__(self):
        self.container_paths=[]      #saved as a file at container_root_path
        self.running_containers=[]  # contains list of running containers
        self.portmap={}             #has list of port mappings --> (container name,port)

        self.num_containers = 0
        self.container_root_path = ''    #get from config file
        self.hackademic_root_path = ''   #get from config file

        self.getConfig()
        self.getContainerList()



    def getConfig(self):

        #check if file exists
        if os.path.exists("container.conf"):

            configparser = ConfigParser.ConfigParser()

            #open config file
            configparser.read("container.conf")

            #read configration
            self.container_root_path = configparser.get('global','container root path')
            self.hackademic_root_path = configparser.get('global','hackademic root path')

        else:
            #add some kind of failsafe
            return

        return




    def saveContainerList(self):

        #open file
        containerlist_file = open('containerlist.txt','w')

        #load paths into containerlist
        for path in self.container_paths:
            containerlist_file.write(path + '/n')

        #close file
        containerlist_file.close()
        return


    def getContainerList(self):

        #open containerfile
        containerlistfile = open("containerlist.txt",'r');

        #read individual paths from file
        for line in containerlistfile:
            self.container_paths.append(line.strip('\n'))

        #close file
        containerlistfile.close()

        #check if folder exists if not remove the container from list
        for path in self.container_paths:
            if not os.path.exists(path):
                self.container_paths.remove(path)
                print 'Container not found at: '+ path


        return





    def createContainer(self,name,ram):

        #load container configuration from config file?
        #create new folder at  container_root_path for new container
        src = self.hackadmic_root_path + '/master'
        dst = self.container_root_path + '/' + name    #replace some_id with random id for new container
        #shutil.copytree(src,dst)       may not copy special files
        subprocess.call('cp -a ' + src + ' ' + dst)

        #call bash script to initialise container

        #add to running_containers list
        temp = Container(name,dst)
        self.running_containers.append(temp)

        #map to port
        self.mapToPort(temp)

        #add to container_list
        self.container_paths.append(dst)


        #create container using virt-install --noautoconsole ensures cirt-install does not open console for the container
        subprocess.call("virt-install --connect lxc:// --name ",name," --ram ",ram," --filesystem ",self.container_root_path,"/",name," --noautoconsole")


        #save changes to container_file
        self.saveContainerList();
        return temp



    def mapToPort(self,container):

        local_port=0
        #get a free port

        #get container ip from dnsleases file
        remote_ip=''

        #forward port
        port_forward = Forwarder.forwarder('127.0.0.1',local_port,remote_ip,80)

        #add mapping
        self.portmap[container.name] = local_port


    def getFreeContainer(self):
        #return a container that is not being used
        for i in self.running_containers:
            if i.isFree():
                #remove i from list
                temp = i
                self.running_containers.remove(i)

                #update container as not free
                temp.free = False
                self.running_containers.append(temp)

                #return container details
                return temp

        tempcontainer = self.createContainer()
        return tempcontainer

    def freeContainer(self):
        #when a challenge is finished this is called so that the container is refreshed and made free
        return


    def startall(self):
        for i in self.running_containers:
            
            #start containers
            i.startContainer();

            #assign forwarded ports
            self.mapToPort(i)



