import os
import sys
import unittest
import subprocess
from docker import Client
"""For appending the directory path"""
abs_path = os.path.abspath(os.path.dirname(__file__))
sys.path.append(abs_path+'/../../ContainerManager')

from container_daemon import ContainerDaemon


class DaemonTest(unittest.TestCase):
    def setUp(self):
        self.client = Client(base_url="unix://var/run/docker.sock")
        self.daemon = ContainerDaemon()

    def test_createcontainer(self):
        flag = len(self.client.containers()) + 1
        self.daemon.createcontainer()
        self.assertEqual(len(self.client.containers()), flag)

    def test_kill_containers(self):
        flag = len(self.client.containers()) - 1
        self.daemon.kill_container(self.client.containers()[0].get("Id"))
        self.assertEqual(len(self.client.containers()), flag)

    def test_auto_container_killer(self):
        flag = len(self.client.containers())
        self.daemon.createcontainer()
        self.daemon.auto_container_killer()
        self.assertEqual(len(self.client.containers()), flag)

if __name__ == '__main__':
    unittest.main()
