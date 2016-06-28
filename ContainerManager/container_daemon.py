#!/usr/bin/env python2

import os
import re
import sys
import json
import signal
import socket
import thread
import random
from time import sleep
from docker import Client
from docker import utils
from docker import errors
from logging_manager import LoggingManager

__author__ = "AnirudhAnand (a0xnirudh) < anirudh@init-labs.org >"


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

        print "[*] Container Created: " + cli.get("Id")
        return "http://localhost:" + str(port) + "/" + str(challenge)

    def generate_port(self):
        sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        while True:
            port = random.randint(1500, 10000)
            result = sock.connect_ex(('127.0.0.1', port))
            if result != 0:
                return port

    def list_containers(self):
        return json.dumps(self.client.containers())

    def kill_container(self, containerid):
        self.client.kill(containerid)
        print "[*] Container Killed: " + containerid

    def auto_container_killer(self):
        print "[*] Auto Container Killer Started"
        # Store the network activity for all the containers
        # Key: Container ID
        # Value: Number of recieved packets (can be changed below, see 'rx_packets')
        containers_network_activity = {}
        while True:
            print "[*] Auto Container Killer Sleeping..."
            # Poll every 10 minutes
            sleep(600)
            print "[*] Checking for Containers with no recieved packets since last check..."
            container_list = self.client.containers()
            for i in range(0, len(container_list)):
                container_id = container_list[i].get("Id")
                stats = self.client.stats(container_id, True)
                current_network_activity = 0

                # 'stats' is a generator object
                for stat in stats:
                    # Reading number of recieved packets in the docker container
                    current_network_activity = stat['networks']['eth0']['rx_packets']
                    break
                try:
                    # If previous network activity is same as the current one then kill the container
                    if current_network_activity <= containers_network_activity[container_id]:
                        self.kill_container(container_id)
                    else:
                        # Update the network activity for the container in the dictionary
                        containers_network_activity[container_id] = current_network_activity
                # If the container is newly created add an entry for it in the dictionary
                except KeyError as err:
                    containers_network_activity[container_id] = current_network_activity


    def create_socket(self):
        s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        s.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
        try:
            s.bind((self.HOST, self.PORT))
        except socket.error as msg:
            print 'Bind failed. Error Code : ' + str(msg[0]) + ' Message '
            + msg[1]
            sys.exit(1)
        s.listen(10)
        print "[*] Docker Daemon started at: " + self.HOST + ":" + str(self.PORT)
        while True:
            conn, addr = s.accept()
            thread.start_new_thread(self.client_thread, (conn,))

    def client_thread(self, conn):
        while True:
            data = conn.recv(1024)

            if 'create_container' in str(data):
                challenge = str(data).split(':')[1]
                containers = self.create_container(challenge)
                conn.sendall(containers)

            if 'list_containers' in str(data):
                containers = self.list_containers()
                conn.sendall(containers)

            if 'kill_container' in str(data):
                containerid = str(data).split(':')[1]
                containerid = containerid.strip("\n")
                try:
                    containers = self.kill_container(containerid)
                except (TypeError) as exception:
                    pass
                conn.close()

        conn.close()


def main():
    containerdaemon = ContainerDaemon()
    child_pid = os.fork()
    if child_pid == 0:
        containerdaemon.auto_container_killer()
    else:
        containerdaemon.create_socket()

if __name__ == '__main__':
    logs = LoggingManager()
    try:
        main()
    except Exception as exception:
        logs.daemon_runtime_log("Runtime Error: \n" +
                                str(exception))
