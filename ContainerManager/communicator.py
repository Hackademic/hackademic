#!/usr/bin/env python2

import json
import socket

__author__ = "AnirudhAnand (a0xnirudh) < anirudh@init-labs.org"


class Communicator():
    def __init__(self):
        self.function = sys.argv[1]
        self.HOST = '127.0.0.1'
        self.PORT = 5506

    def create_connection(self):
        client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        client_socket.connect((self.HOST, self.PORT))
        if self.function == 'kill_container' or self.function == 'create_container':
            print sys.argv[2]
            client_socket.send(sys.argv[1] + ':' + sys.argv[2])
        else:
            client_socket.send(self.function)
        data = client_socket.recv(1024)
        print data
        return


def main():
    communicator = Communicator()
    communicator.create_connection()
    return


if __name__ == '__main__':
    main()
