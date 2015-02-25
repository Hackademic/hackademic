import ContainerDispatcher
import socket
import sys

__author__ = 'root'

###########################################################################################################
#   Challenge Loader is the main program and acts as a server listining for requests for new containers
###########################################################################################################

started=[]      # has a list of all containers which are started

def serve(conn):
    #   This functions listens to requests for containers
    #   When a new container is made available the port number its associated to it is forwarded
    data=''

    try:
        while True:
            data = data +conn.recv(1024)

            #recived data could be of 2 types
            #   1. requesting a new container
            #   2. signal that challenge is over and container be freed
            #TODO: implement provision for 2 types of request

            if data.endswith(u"\n"):
                print data

                #get free container from dispatcher
                container = containerDispatcher.getFreeContainer()

                started.append(container)

                #get port from port map
                port,forwarder = containerDispatcher.portmap[container.name]

                #send port to hackademic
                conn.send(str(port))
                conn.close()
                break

    except socket.error:
        print 'Connection error'

    finally:
        conn.close()




if __name__ == '__main__':

    containerDispatcher = ContainerDispatcher.ContainerDispatcher()
    containerDispatcher.start()


    host = '127.0.0.1'
    port = 8081

    try:
        #Create a socket to listen for requests
        s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        s.bind((host,port))
        s.listen(1)

    except socket.error:
        print 'Failed to create socket'
        sys.exit()


    try:
        while True:
            conn, address = s.accept()
            serve(conn)
            conn.close()

    finally:
        # gracefully shutdown all containers
        for i in started:
            i.stopContainer()



