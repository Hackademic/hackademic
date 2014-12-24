import ConfigParser
import asyncore
from random import randint
import Forwarder
import Container
import subprocess
import os

__author__ = 'root'

class ContainerDispatcher:

    #add logging capability

    def __init__(self):
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
        self.getContainerlist()



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


    def getContainerlist(self):

        subprocess.call('virsh -c lxc:// list --all | tail -n +3 > containerlist.txt',shell = True)

        #open containerlist file
        containerlistfile = open('containerlist.txt');

        for line in containerlistfile:
            if len(line.split()) > 0 :
                container_name = line.split()[1]

                if len(container_name) > 0:
                    self.containers.append(Container.Container(container_name,self.container_root_path + '/' + container_name))




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

        for i in self.containers:
            i.startContainer()
            self.mapToPort(i)

            self.running_containers.append(i)



if __name__ == '__main__':

    dispatcher = ContainerDispatcher()

    dispatcher.startall()

    print dispatcher.getFreeContainer().name
    print dispatcher.getFreeContainer().name

    for i in dispatcher.running_containers:
        i.stopContainer()
