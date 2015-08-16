import os
import re
import signal
import socket
import thread
import base64
import random
from time import sleep
from docker import Client
from docker import utils
from docker import errors
from logging_manager import LoggingManager

__author__ = "AnirudhAnand (a0xnirudh)"


class ContainerDaemon():
    """The Main Docker daemon class. This wil control the containers """

    def __init__(self):
        self.client = Client(base_url="unix://var/run/docker.sock")
        self.timer = "hour"
        self.HOST = '127.0.0.1'
        self.PORT = 5506
        self.logs = LoggingManager()

    def create_container(self, challenge=None):
        port = self.generate_port()
        try:
            cli = self.client.create_container(image="hackademic:latest",
                                               ports=[80], host_config=utils.
                                               create_host_config
                                               (port_bindings={80: port}),
                                               detach=True)
            self.client.start(cli.get("Id"))

        except (errors.APIError) as exception:
            self.logs.container_runtime_log("Runtime Error: \n" +
                                            str(exception))
            exit("Check logs for more details")

        return "[+] Goto http://localhost:" + str(port) + "/" + str(challenge)

    def generate_port(self):
        sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        while True:
            port = random.randint(1500, 10000)
            result = sock.connect_ex(('127.0.0.1', port))
            if result != 0:
                return port

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
        createcontainer = base64.b64encode('create_container\n')
        listcontainers = base64.b64encode('list_containers\n')
        killcontainer = base64.b64encode('kill_container\n')
        while True:
            data = conn.recv(1024)

            if createcontainer == base64.b64encode(data):
                containers = self.create_container()
                conn.sendall(containers)

            if listcontainers == base64.b64encode(data):
                containers = self.list_containers()
                conn.sendall(containers)

            if killcontainer == base64.b64encode(data):
                containerid = conn.recv(1024)
                containerid = containerid.strip("\n")
                containers = self.kill_container(containerid)
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
