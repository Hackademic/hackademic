import sys
import random
import socket
from docker import utils
from docker import Client
from docker import errors
from logging_manager import LoggingManager

__author__ = "AnirudhAnand (a0xnirudh)"


class ContainerManager():
    """ This class handles the creation and deletion of new containers. """

    def __init__(self):
        self.client = Client(base_url="unix://var/run/docker.sock")
        self.logs = LoggingManager()

    def create_container(self, challenge):
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

        print("[+] Goto http://localhost:" + str(port) + "/" +
              challenge)

    def generate_port(self):
        sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        while True:
            port = random.randint(1500, 10000)
            result = sock.connect_ex(('127.0.0.1', port))
            if result != 0:
                return port

    def kill_container(self, containerid):
        self.client.kill(containerid)


def main():
    if len(sys.argv) < 2:
        exit('Usage: ./container_mananger.py challenge_name')
    containermanager = ContainerManager()
    containermanager.create_container(sys.argv[1])


if __name__ == '__main__':
    main()
