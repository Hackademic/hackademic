import ConfigParser
import threading
import time
import sys
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
        self.ip_address = ''             #get from config file
        self.container_root_path = ''    #get from config file
        #self.hackademic_root_path = ''   #get from config file
        self.master_copy_name=''
        self.ram_size=''
        self.free_ports = []

        self.getConfig()
        self.getContainerlist()



    def getConfig(self):

        #check if configuration file exists
        if os.path.exists("container.conf"):

            #create a configpaser object
            configparser = ConfigParser.ConfigParser()

            #open config file using the configparser
            configparser.read("container.conf")

            #read configration from file
            self.container_root_path = configparser.get('global','container root path')
            #self.hackademic_root_path = configparser.get('global','hackademic root path')
            self.ip_address = configparser.get('global','ip address')

            self.master_copy_name = configparser.get('container','master name')
            Container.Container.master_path = self.container_root_path + "/" + self.master_copy_name
            self.ram_size = configparser.get('container','ram size')

            self.start_number = int(configparser.get('container','start number'))

            #read free port configurations
            start = configparser.get('port range','start')
            self.port_start = int(start)
            #stop = configparser.get('port range','stop')
            #self.free_ports = range(int(start),int(stop))
            #print self.free_ports

        else:
            #add some kind of failsafe
            print 'Config file not found'
            return

        return


    def getContainerlist(self):
        #This command is used to get the list of all containers installed in the system using the virsh command

        temp=[]

        #execute the virsh command to list all the containers and forward result into a file called containerlist.txt
        subprocess.call('virsh -c lxc:// list --all | tail -n +3 > containerlist.txt',shell = True)

        #open containerlist file
        containerlistfile = open('containerlist.txt');

        #for every entry in the file create a container object which has the details of the container
        for line in containerlistfile:
            if len(line.split()) > 0 :
                container_name = line.split()[1]

                if len(container_name) > 0:
                    temp.append(Container.Container(container_name,self.container_root_path + '/' + container_name))

        self.containers['not running'] = temp



    def createContainer(self):


        #self.containers['not running'].sort(key= lambda x:x.name, reverse=True)
        lists = self.containers['running'] + self.containers['not running']
        lists.sort(key=lambda x:x.name)

        last_name = lists[-1].name
        name = last_name[:-1] + str(int(last_name[-1]) + 1)

        #name=self.containers['running'][-1].name[:-1] + str((int(self.containers['running'][-1].name[-1]) + 1))
        print 'creating container - ',name

        ram = self.ram_size
        master_path=Container.Container.master_path

        #create new folder at  container_root_path for new container
        dst = self.container_root_path + '/' + name


        #make the necessary container folders
        subprocess.call('mkdir ' + dst,shell=True)
        subprocess.call('mkdir ' + dst+'/'+'mount',shell=True)
        subprocess.call('mkdir ' + dst+'/'+'write',shell=True)

        #use unionfs to mount the container
        subprocess.call("unionfs -o cow,max_files=32768 -o allow_other,use_ino,suid,dev,nonempty   " + dst + "/write=RW:" + master_path + "=RO   " + dst + "/mount",shell=True)

        #change the necessary files for changing hostname
        subprocess.call("cp container_hostname_setup.sh " + dst + "/mount/container_hostname_setup.sh",shell=True)
        subprocess.call("chroot " + dst + "/mount" + " ./container_hostname_setup.sh " + name,shell=True)

        #create container using virt-install
        subprocess.call("virt-install --connect lxc:// --name " + name + " --ram " + ram + " --filesystem " + self.container_root_path + "/" + name + "/mount" +  ",/" + " --noautoconsole",shell=True)



        #add to running_containers list
        temp = Container.Container(name,dst)
        temp.stopContainer()
        temp.startContainer()

        #this is necessary because adding a new entry to the default.leases file will take some time. So map to port should not be called immediatly
        time.sleep(20)
        self.containers['running'].append(temp)


        #map to port
        self.mapToPort(temp)

        return temp



    def mapToPort(self,container):

        #This functioin is used to port forward specific local ports to the http port of each container

        #get a free port
        #local_port=self.free_ports.pop()
        self.port_start += 1
        local_port = self.port_start
        #print 'port ',local_port


        #get ip of each container from dnsleases file
        dnsfile = open('/var/lib/libvirt/dnsmasq/default.leases')

        remote_ip=''
        for line in dnsfile:
            if container.name in line.split(' '):
                remote_ip=line.split(' ')[2]
                print container.name,remote_ip,';',local_port

        #forward port
        #local host wont do have to set appropriate ip
        forwarder = Forwarder.forwarder('192.168.40.139',local_port,remote_ip,80)

        #add to portmap
        self.portmap[container.name]=(local_port,forwarder)

        #change site root path in config.php file
        subprocess.call("cp container_hackademic_setup.sh " + container.path + "/mount/container_hackademic_setup.sh",shell=True)
        subprocess.call("chroot " + container.path + "/mount" + " ./container_hackademic_setup.sh " + self.ip_address + " " + str(local_port),shell=True)






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


        #if a free container is not found then a container which is shutdown will be activated
        if len(self.containers['not running']) >0:

            #get a conatiner which is not running
            free = self.containers['not running'].pop(0)

            #start the container and set it as not free
            free.startContainer()
            time.sleep(1)
            free.setNotFree()

            #map container to port
            self.mapToPort(free)


            self.containers['running'].append(free)
            print 'activiting',free.name

            if len(self.containers['not running'])<=0:
                #do it in an new thread

                def makenew():
                    new = self.createContainer()
                    new.stopContainer()
                    self.containers['not running'].append(new)

                thread = threading.Thread(target=makenew)
                thread.start()

            return free


        else:
            #if all the containers are used up then a new container should be installed
            print "no installed containers exception : logical error"
            #free = self.createContainer()
            #print free.name
            #self.containers['running'].append(free)
            #return free





    #check
    def freeContainer(self,free_this_port):

        #this function is called by the ChalengeLoader when a challenge running inside it is over and it is set as free

        #find the container from portmap
        for container_name,(port,forwarder) in self.portmap.items():
            if free_this_port == port:

                #reload container
                #container.reloadContainer()

                #close connection with forwarder

                #add port to list of free ports
                self.free_ports.append(port)

                #remove entry from portmap
                self.portmap[container_name]=None

        return



    def startall(self):

        #starts all the containers installed in the system

        for i in reversed(self.containers['not running']):
            print i.name


            i.startContainer()
            #self.mapToPort(temp)

            self.containers['running'].append(i)
            self.containers['not running'].remove(i)



    def start(self):

        #starts a definite number of containres as set by self.startnum
        for i in reversed(self.containers['not running'][:self.start_number]):

            print 'init start : ',i.name
            i.startContainer()
            self.mapToPort(i)
            self.containers['running'].append(i)
            self.containers['not running'].remove(i)

    def shutdown(self):

        for n,(i,j) in self.portmap.items():
            j.shutdown()


        return



if __name__ == '__main__':

    dispatcher = ContainerDispatcher()

    dispatcher.start()
    #dispatcher.createContainer()

    print 'free container '+dispatcher.getFreeContainer().name
    time.sleep(5)
    print 'free container '+dispatcher.getFreeContainer().name
    time.sleep(5)
    print 'free container '+dispatcher.getFreeContainer().name
    time.sleep(5)
    print 'free container '+dispatcher.getFreeContainer().name
    time.sleep(5)


    print 'final free'
    for i in dispatcher.containers['not running']:
        print i.name
    #sys.exit()
    #print dispatcher.getFreeContainer().name


    #for n,(i,j) in dispatcher.portmap.items():
    #    print i

    #x=raw_input("asdasd")

    #dispatcher.shutdown()
