from docker import Client
from create_container import ContainerManager

__author__ = "AnirudhAnand (a0xnirudh)"


class ContainerDaemon():
    """The Main Docker daemon class. This wil control the containers """

    def __init__(self):
        self.client = Client(base_url="unix://var/run/docker.sock")
        self.create = ContainerManager()

    def createcontainer(self):
        self.create.create_container()

    def list_containers(self):
        self.client.containers()

    def kill_container(self, containerid):
        self.client.kill(containerid)


def main():
    containerdaemon = ContainerDaemon()
    containerdaemon.createcontainer()
    containerdaemon.list_containers()
    # containerdaemon.kill_container()


if __name__ == '__main__':
    main()
