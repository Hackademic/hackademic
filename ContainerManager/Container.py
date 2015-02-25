import subprocess
import threading
import time

__author__ = 'root'

########################################################################################################################
#   This calss represent a datastructure for each container that is created
#
#   Every container makes use of a union mount filesystem uisng unionfs. It also implaments a copy-on-write system
#   This means that making a new container will require only a few megabytes
#
#   The containers are started and stopped using the virsh command
#
#   Details regarding unionfs and copy-on write can be found in the docs folder
########################################################################################################################

class Container:

    master_path=''
    expire_time=60

    def __init__(self,name,path):
        self.name = name
        self.path = path                        #The path is absolute not relative ie. it includes the path of the container folder
        self.free = True                        #This shows if the container container is currently aallocated to any user to run a challenge
        self.expire = Container.expire_time     #The time after which the container is automatically set as free
                                                #represented in seconds

    def startContainer(self):

        #   When a container is sarted first unionfs is used to mount the container and enable copy-on-write
        #   After it is mounted virsh command is used to start the container

        #use unionfs to mount
        subprocess.call("unionfs -o cow,max_files=32768 -o allow_other,use_ino,suid,dev,nonempty   " + self.path + "/write=RW:" + Container.master_path + "=RO   " + self.path+"/mount",shell=True)

        #command to start the container
        cmd = "virsh -c lxc:// start " + self.name
        subprocess.call(cmd,shell = True)
        return

    def stopContainer(self):

        #   To stop a container virsh command is used to destroy it and then the container mount point is unmounted

        #command to shutdown the container
        cmd = "virsh -c lxc:// destroy " + self.name
        subprocess.call(cmd,shell = True)

        #unmount the mount folder
        subprocess.call("umount " + self.path + "/mount",shell=True)

        return


    def reloadContainer(self):

        #   To refresh a container to its original state after a challenge it is just needed to remove the contents in the write folder except /etc and /var/www/hackademic
        #   TODO : try to implement 2 write folders with one write folder only containing the changes made during the installation of the container


        #remove things in write folder
        self.free = True
        return

    def isFree(self):
        return self.free

    def setNotFree(self):
        self.free = False
        self.startExpireTimer()
        return

    def startExpireTimer(self):
        #   This function starts a timer which expires when self.expire reaches 0
        #   the variable is decremented every second

        # the container is automatically set as free after a specific amount of time defined in self.expire
        def execute():
            #This function acts as a timer which decrements self.expire and goes to sleep exactly for 1 second
            starttime=time.time()
            while self.expire > 0:
                self.expire -= 1
                time.sleep(1.0 - ((time.time() - starttime) % 1.0))
            self.expire = Container.expire_time

        #execute the timer function as a seperate thread
        timer = threading.Thread(target=execute)
        timer.start()

if __name__=='__main__':

    temp = Container('rootfs2','/containers/rootfs2')
    temp.startContainer()
    temp.stopContainer()
    #temp.startExpireTimer()




