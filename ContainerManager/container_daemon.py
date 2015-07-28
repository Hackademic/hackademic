import os
import re
import signal
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

    def createcontainer(self):
        cli = self.create.create_container()
        self.client.start(cli.get("Id"))

    def list_containers(self):
        self.client.containers()

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


def main():
    containerdaemon = ContainerDaemon()
    child_pid = os.fork()
    if child_pid == 0:
        containerdaemon.auto_container_killer()
    else:
        while True:
            try:
                print("Choose from the menu: \n1) Create Containers")
                print("2) List Containers\n3) kill Container\n4) Exit daemon")
                option = raw_input("\nEnter your choice: ")

                if option == '1':
                    containerdaemon.createcontainer()
                elif option == '2':
                    containerdaemon.list_containers()
                elif option == '3':
                    Id = raw_input("Enter the container Id: ")
                    containerdaemon.kill_container(Id)
                elif option == '4':
                    os.kill(child_pid, signal.SIGTERM)
                    break
                else:
                    print "Invalid option. Please choose a correct one"
            except KeyboardInterrupt:
                os.kill(child_pid, signal.SIGTERM)
                break


if __name__ == '__main__':
    main()
