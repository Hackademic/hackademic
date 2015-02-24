import subprocess
import threading
import time

__author__ = 'root'

class Container:

    master_path='/containers/rootfs1'
    expire_time=60

    def __init__(self,name,path):
        self.name = name

        self.path = path
        #path is from / at qemu     "/container/lxc1"

        self.free = True

        #expiration time in seconds
        self.expire = 6

        self.expire = Container.expire_time     #The time after which the container is automatically set as free
                                                #represented in seconds

    def startContainer(self):

        #use unionfs to mount
        subprocess.call("unionfs -o cow,max_files=32768 -o allow_other,use_ino,suid,dev,nonempty   " + self.path + "/write=RW:" + Container.master_path + "=RO   " + self.path+"/mount",shell=True)

        #command to start the container
        cmd = "virsh -c lxc:// start " + self.name
        subprocess.call(cmd,shell = True)
        return

    def stopContainer(self):

        #command to shutdown the container
        cmd = "virsh -c lxc:// destroy " + self.name
        subprocess.call(cmd,shell = True)

        #unmount the mount folder
        subprocess.call("umount " + self.path + "/mount",shell=True)

        return


    def reloadContainer(self):

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
    #x=raw_input("sdfsd")
    #print x




