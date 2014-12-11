__author__ = 'root'

class Container:

    def __init__(self,name,path):
        self.name = name
        self.path = path
        self.free = False

    # def initiateContainer(self):
    #
    #     #copy hackademic folder
    #     #copy session files
    #     #copy database files
    #     return


    def startContainer(self):

        cmd = "virsh -c lxc:// start ",self.name
        subprocess.call(cmd,shell = True)
        return

    def stopContainer(self):

        cmd = "virsh -c lxc:// destroy",self.name
        subprocess.call(cmd,shell = True)
        return


    def reloadContainer(self):

        #remove /var/www/html

        #remove session files

        #remove /var/lib/mysql/hack database
        #or
        #change

        return



