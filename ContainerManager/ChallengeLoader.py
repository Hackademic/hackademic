import asyncore
import ContainerDispatcher
import socket
import sys

__author__ = 'root'



def loadChallenge(data):

    #get a free container from ContainerDispatcher
    free = containerDispatcher.getFreeContainer()

    #get challenge details from php

    #load hackademic into container

    #change site root ip to container ip in config.inc.php
    #change database location in config.inc.php
    #copy the appropriate session file to container
    #?change the IPaddress in session file

    return free

def serve(conn):
    data=''

    try:
        while True:
            data = data +conn.recv(1024)

            #recived data could be of 2 types
            #   1. requesting a new container
            #   2. signal that challenge is over and container be freed

            if data.endswith(u"\r\n"):
                #print data

                #get free container from dispatcher
                container_name = loadChallenge(data)

                #send port to php
                conn.send(containerDispatcher.portmap[container_name])

    except socket.error:
        print 'Connection error'

    finally:
        conn.close()



if __name__ == '__main__':


    #start all containers
    containerDispatcher = ContainerDispatcher.ContainerDispatcher()
    containerDispatcher.startall()


    host = ''
    port = 51001
    connectionSevered=0

    try:
        s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        s.bind((host,port))
        s.listen(1)

    except socket.error:
        print 'Failed to create socket'
        sys.exit()


    while True:
        conn, address = s.accept()
        #open in a seperate thread
        serve(conn)
        
    asyncore.loop()

