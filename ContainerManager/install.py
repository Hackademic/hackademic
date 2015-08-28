#!/usr/bin/env python2
"""

:Synopsis: Specialized Class for installing essential components.
:Install-logs: All logs are saved in the directory **hackademic-logs**.

"""

import os
import subprocess
from logging_manager import LoggingManager

__author__ = 'AnirudhAnand (a0xnirudh) <anirudh@init-labs.org'


class Install:

    def __init__(self):
        self.user = os.environ['USER']
        self.install = LoggingManager()
        return

    def install_docker(self):

        """
        This function will install docker and if docker is already installed,it
        will skip the installation.

        All logs during the install are saved to hackademic_logs/install.logs
        """
        print("[+] Installing Docker and necessary supporting plugins")
        print("[+] This could take some time. Please wait ...")
        try:
            subprocess.check_call("docker -v", stdout=subprocess.PIPE,
                                  stderr=subprocess.STDOUT, shell=True)
        except (OSError, subprocess.CalledProcessError):
            try:
                subprocess.check_call("wget -qO- https://get.docker.com/ | sudo sh",
                                      stdout=subprocess.PIPE,
                                      stderr=subprocess.STDOUT, shell=True)

                subprocess.check_call("sudo usermod -aG docker " + self.user,
                                      stdout=subprocess.PIPE,
                                      stderr=subprocess.STDOUT, shell=True)

            except (OSError, subprocess.CalledProcessError) as exception:
                self.install.install_log('Installation Error: \n' +
                                         str(exception))
                exit("[+] Unknown error happened. Check logs for more details")

    def docker_image(self):

        """
        This will pull the latest ubuntu (~300 MB) from phusion/baseimage repo.

        We are using the Ubuntu based image because we need the init script to
        run since we are running more than 1 process or else it could become
        zombie process. So an image which is configured with init is necessary.

        """
        print("[+] Docker has successfully installed.")
        print("[+] Now Pulling Image. This could take sometime. Please wait..")

        try:
            subprocess.check_call("docker pull phusion/baseimage:latest",
                                  stdout=subprocess.PIPE,
                                  stderr=subprocess.STDOUT, shell=True)

        except (OSError, subprocess.CalledProcessError) as exception:
            self.install.install_log('Image File Download Error: \n' +
                                     str(exception))
            exit("[+] Image Download Interrupted. Check logs for more details")

    def build_docker(self):

        """
        This will build the docker image with the specified Dockerfile which
        adds all the challenges and install necessary applications for running
        the challenges.

        Once building is over, try the command " docker images " and if you can
        see animage named 'Hackademic', installation is successful.

        """
        print("[+] Building and Configuring Docker")
        subprocess.call("docker rmi -f hackademic", stdout=subprocess.PIPE,
                        stderr=subprocess.STDOUT, shell=True)
        try:
            subprocess.check_call("docker build -t hackademic .",
                                  stdout=subprocess.PIPE,
                                  stderr=subprocess.STDOUT, shell=True)

        except (OSError, subprocess.CalledProcessError) as exception:
            self.install.install_log('Docker Build error: \n' + str(exception))
            exit("[+] Docker Build Interrupted. Check logs for more details..")

    def install_finish(self):
        print("[+] Installation is Successful. Happy hacking !")


def main():
    docker = Install()
    docker.docker_image()
    docker.install_docker()
    docker.build_docker()
    docker.install_finish()


if __name__ == '__main__':
    main()
