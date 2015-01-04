import ConfigParser
from random import randint
import Container
import subprocess
import os
import Forwarder

__author__ = 'root'

class ContainerDispatcher:

    #add logging capability

    def __init__(self):

        self.containers={'running' : [] ,'not running' : []}
        self.portmap={}             #has list of port mappings --> (container name,port)

        self.start_number = 1
        self.container_root_path = ''    #get from config file
        self.hackademic_root_path = ''   #get from config file
        self.master_copy_name=''
        self.ram_size=''
        self.free_ports = []

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
        temp=[]
        subprocess.call('virsh -c lxc:// list --all | tail -n +3 > containerlist.txt',shell = True)

        #open containerlist file
        containerlistfile = open('containerlist.txt');

        for line in containerlistfile:
            if len(line.split()) > 0 :
                container_name = line.split()[1]

                if len(container_name) > 0:
                    temp.append(Container.Container(container_name,self.container_root_path + '/' + container_name))

        self.containers['not running'] = temp



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
        self.containers['running'].append(temp)


        #map to port
        self.mapToPort(temp)

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
        # #local host wont do have to set appropriate ip
        forwarder = Forwarder.forwarder('192.168.40.139',local_port,'192.168.122.121',80)

        #add to portmap
        self.portmap[container.name]=(local_port,forwarder)





    def getFreeContainer(self):
        #return a container that is not being used

        if len(self.containers['running']) > 0:

            for i in reversed(self.containers['running']):
                if i.isFree():
                    #remove i from list
                    free = i
                    self.containers['running'].remove(i)

                    #update container as not free
                    free.setNotFree()
                    self.containers['running'].append(free)

                    #return container details
                    return free


        if len(self.containers['not running']) > 0:
            free = self.containers['not running'].pop()
            free.startContainer()
            free.setNotFree()
            self.mapToPort(free)
            self.containers['running'].append(free)
            print 'activiting',free.name
            return free


        else:
            print "none free creating new container"
            free = self.createContainer()
            self.containers['running'].append(free)





    #check
    def freeContainer(self,free_this_port):

        #find the container from portmap
        for container_name,(port,forwarder) in self.portmap.items():
            if free_this_port == port:

                #reload container
                #container.reloadContainer()

                #close connection with forwarder
                forwarder.close()

                #add port to list of free ports
                self.free_ports.append(port)

                #remove entry from portmap
                self.portmap[container_name]=None

        return



    def startall(self):

        for i in reversed(self.containers['not running']):
            print i.name


            i.startContainer()
            #self.mapToPort(temp)

            self.containers['running'].append(i)
            self.containers['not running'].remove(i)



    def start(self):

        for i in reversed(self.containers['not running'][0:self.start_number]):

            i.startContainer()
            self.mapToPort(i)
            self.containers['running'].append(i)
            self.containers['not running'].remove(i)

    def shutdown(self):

        for n,(i,j) in self.portmap.items():
            j.shutdown()

        #for i in self.containers['running']:
        #    i.stopContainer()

        return



if __name__ == '__main__':

    dispatcher = ContainerDispatcher()

    dispatcher.start()

    print dispatcher.getFreeContainer().name
    #print dispatcher.getFreeContainer().name

    #print Forwarder.gmap[4].close()

    for n,(i,j) in dispatcher.portmap.items():
        print i

    x=raw_input("asdasd")

    dispatcher.shutdown()
