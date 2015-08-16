import os
import re
import signal
import socket
import thread
import base64
from time import sleep
from docker import Client
from create_container import ContainerManager

__author__ = "AnirudhAnand (a0xnirudh)"


class ContainerDaemon():
    """The Main Docker daemon class. This wil control the containers """

    def __init__(self):
        self.client = Client(base_url="unix://var/run/docker.sock")
        self.create = ContainerManager()
        self.timer = "hour"
        self.HOST = '127.0.0.1'
        self.PORT = 5506

    def createcontainer(self):
        cli = self.create.create_container()
        self.client.start(cli.get("Id"))

    def list_containers(self):
        return str(self.client.containers())

    def kill_container(self, containerid):
        self.client.kill(containerid)

    def auto_container_killer(self):
        while True:
            sleep(300)
            container_list = self.client.containers()
            for i in range(0, len(container_list)):
                temp = container_list[i].get("Status")
                flag = re.findall(self.timer, temp)
                if flag:
                    self.kill_container(container_list[i].get("Id"))

    def create_socket(self):
        s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        s.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
        try:
            s.bind((self.HOST, self.PORT))
        except socket.error as msg:
            print 'Bind failed. Error Code : ' + str(msg[0]) + ' Message ' + msg[1]
            sys.exit(1)
        s.listen(10)
        while True:
            conn, addr = s.accept()
            thread.start_new_thread(self.client_thread, (conn,))

    def client_thread(self, conn):
        base = base64.b64encode('list_containers\n')
        while True:
            data = conn.recv(1024)
            if base == base64.b64encode(data):
                containers = self.list_containers()
                conn.sendall(containers)

        conn.close()


def main():
    containerdaemon = ContainerDaemon()
    child_pid = os.fork()
    if child_pid == 0:
        containerdaemon.auto_container_killer()
    else:
        containerdaemon.create_socket()

if __name__ == '__main__':
    main()
