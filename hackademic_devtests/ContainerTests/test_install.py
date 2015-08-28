import os
import sys
import unittest
import subprocess
"""For appending the directory path"""
abs_path = os.path.abspath(os.path.dirname(__file__))
sys.path.append(abs_path+'/../../ContainerManager')

from install import Install


class InstallTest(unittest.TestCase):
    def setUp(self):
        self.install = Install()

    def test_install_docker(self):
        self.install.install_docker()
        subprocess.check_call("docker -v", stdout=subprocess.PIPE,
                              stderr=subprocess.STDOUT, shell=True)
        a = os.system('echo $?')
        self.assertEqual(a, 0)

    def test_docker_image(self):
        self.install.docker_image()
        subprocess.check_call("docker images | grep phusion",
                              stdout=subprocess.PIPE, stderr=subprocess.STDOUT,
                              shell=True)
        a = os.system('echo $?')
        self.assertEqual(a, 0)

    def test_build_docker(self):
        self.install.build_docker()
        subprocess.check_call("docker images | grep hackademic",
                              stdout=subprocess.PIPE, stderr=subprocess.STDOUT,
                              shell=True)
        a = os.system('echo $?')
        self.assertEqual(a, 0)

    def tearDown(self):
        self.install.dispose()
        self.install = None
        subprocess.check_call("docker rmi -f hackademic",
                              stdout=subprocess.PIPE, stderr=subprocess.STDOUT,
                              shell=True)
        subprocess.check_call("sudo apt-get remove lxc-docker",
                              stdout=subprocess.PIPE, stderr=subprocess.STDOUT,
                              shell=True)

if __name__ == '__main__':
    unittest.main()
