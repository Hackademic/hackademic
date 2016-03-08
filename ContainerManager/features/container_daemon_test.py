import socket
import os
import sys
import time
from lettuce import world, steps
sys.path.append(os.path.join(os.path.dirname(os.path.abspath(__file__)), os.pardir))
from container_daemon import ContainerDaemon



@steps
class ContainerDaemonTest(object):
    def __init__(self, environs):
        self.containerdaemon = ContainerDaemon()
        self.s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.data = ""

    def create_connection(self):
        self.s.connect(('localhost', 5506))

    def send(self, step, text):
        '''I send "(.*)"'''
        print("text is :::::::::::::::", text)
        self.s.send(text)
        self.data = self.s.recv(512)
        self.s.close()

    def check(self, step, text):
        '''I receive "(.*)"'''
        assert "samplechallenge" in self.data

    def run_container(self, step):
        '''I run the Container Daemon'''
        pid = os.fork()
        if pid != 0:
            time.sleep(0.5)
            self.create_connection()
            for container in self.containerdaemon.client.containers():
                self.containerdaemon.kill_container(container['Id'])

        else:
            self.containerdaemon.create_socket(True)


ContainerDaemonTest(world)