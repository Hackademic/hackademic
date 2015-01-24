import subprocess

__author__ = 'root'
#contains functions for overall administration and cleanup of containers

def removeindividualContainer(name):
    #undefine container
    subprocess.call("virsh -c kxc:// undefine "+ name,shell=True)

    #remove folder
    return

def cleanupDnsleases():
    return

def executecommandtoall(cmd):
    return