import ConfigParser
import asyncore
from random import randint
import threading
import Forwarder
import Container
import subprocess
import os

__author__ = 'root'

class ContainerDispatcher:

    #add logging capability

    def __init__(self):
        self.container_paths=[]      #saved as a file at container_root_path
        self.containers=[]          #contains list of deifined containers
        self.running_containers=[]  # contains list of running containers
        self.portmap={}             #has list of port mappings --> (container name,port)

        self.num_containers = 0
        self.container_root_path = ''    #get from config file
        self.hackademic_root_path = ''   #get from config file
        self.master_copy_name=''
        self.ram_size=''
        self.free_ports = []             #get from config file

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

            self.master_copy_name = configparser.get('container','master name')
            self.ram_size = configparser.get('container','ram size')

            #read free port configurations
            start = configparser.get('port range','start')
            stop = configparser.get('port range','stop')
            self.free_ports = range(int(start),int(stop))
            print self.free_ports

        else:
            #add some kind of failsafe
            print 'Config file not found'
            return

        return




    def saveContainerList(self):

        #open file
        containerlist_file = open('containerlist.txt','w')

        #load paths into containerlist
        for path in self.container_paths:
            containerlist_file.write(path + '\n')

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





    def createContainer(self):

        #name = self.master_copy_name + str(randint(1,10))               # every new container will have name like lxc56
        name='rootfs1'
        ram = self.ram_size

        #create new folder at  container_root_path for new container
        src = self.container_root_path + '/' + self.master_copy_name
        dst = self.container_root_path + '/' + name

        #shutil.copytree(src,dst)       may not copy special files
        print 'copying files will take a long time'
        #use bash script for achiving these
        #subprocess.call('cp -a ' + src + ' ' + dst, shell=True)
        #subprocess.call('sed /s/LXC_NAME/' + name + '/ ' + dst + '/etc/sysconfig/network-scripts/ifcfg-eth0', shell=True)

        #create container using virt-install --noautoconsole ensures virt-install does not open console for the container
        print 'running virt-install'
        #subprocess.call("virt-install --connect lxc:// --name " + name + " --ram " + ram + " --filesystem " + self.container_root_path + "/" + name + "/" +  ",/" + " --noautoconsole",shell=True)


        #add to running_containers list
        temp = Container.Container(name,dst)
        self.running_containers.append(temp)


        #map to port
        self.mapToPort(temp)


        #add to container_list
        self.container_paths.append(dst)


        #save changes to container_file
        self.saveContainerList()
        return temp



    def mapToPort(self,container):

        #get a free port
        local_port=self.free_ports.pop()
        #print 'port ',local_port


        #get container ip from dnsleases file
        dnsfile = open('/var/lib/libvirt/dnsmasq/default.leases')

        remote_ip=''
        for line in dnsfile:
            if container.name in line.split(' '):
                remote_ip=line.split(' ')[2]
                print container.name,remote_ip,';',local_port

        #forward port
        Forwarder.forwarder('127.0.0.1',local_port,remote_ip,80)

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

        print "none free creating new container"
        tempcontainer = self.createContainer()
        return tempcontainer


    #check
    def freeContainer(self):
        #when a challenge is finished this is called so that the container is refreshed and made free
        #update free ports
        #update container and reload
        return



    def startall(self):

        #generate containers list
        for path in self.container_paths:

            #extract container name from path
            name = path.replace(self.container_root_path,'')
            name = name.replace('/','')

            self.containers.append(Container.Container(name,path))


        for i in self.containers:
            
            #start containers
            print 'starting ',i.name
            i.startContainer();

            #assign forwarded ports
            self.mapToPort(i)

            #append to running containers
            self.running_containers.append(i)



if __name__ == '__main__':

    dispatcher = ContainerDispatcher()

    dispatcher.startall()

    print dispatcher.getFreeContainer().name
    print dispatcher.getFreeContainer().name

    asyncore.close_all(Forwarder.gmap)

    #for i in dispatcher.running_containers:
        #i.stopContainer()



