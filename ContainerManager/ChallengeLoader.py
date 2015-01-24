import ContainerDispatcher
import socket
import sys

__author__ = 'root'




def serve(conn):
    data=''

    try:
        while True:
            data = data +conn.recv(1024)

            #recived data could be of 2 types
            #   1. requesting a new container
            #   2. signal that challenge is over and container be freed

            if data.endswith(u"\n"):
                print data

                #get free container from dispatcher
                container = containerDispatcher.getFreeContainer()

                #send port to php
                #print  containerDispatcher.portmap['rootfs']
                port,forwarder = containerDispatcher.portmap[container.name]

                conn.send(str(port))
                conn.close()
                break

    except socket.error:
        print 'Connection error'

    finally:
        conn.close()




if __name__ == '__main__':

    #start all containers
    containerDispatcher = ContainerDispatcher.ContainerDispatcher()
    containerDispatcher.start()



    for n,(i,j) in containerDispatcher.portmap.items():
        print n,i

    host = '127.0.0.1'
    port = 8081
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
        serve(conn)

        conn.close()
        #containerDispatcher.shutdown()


