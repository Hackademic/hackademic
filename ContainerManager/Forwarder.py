import socket
import thread
import threading


class forwarder:

    def __init__(self,local_ip,local_port,remote_ip,remote_port):

        self.local_ip=local_ip
        self.local_port=local_port
        self.remote_ip=remote_ip
        self.remote_port=remote_port

        self.thread = threading.Thread(target=self.server)
        self.thread.start()
        



    def server(self):
        try:
            dock_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
            dock_socket.bind(('', self.local_port))
            dock_socket.listen(5)

            while True:
                client_socket = dock_socket.accept()[0]
                server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
                server_socket.connect((self.remote_ip, self.remote_port))
                thread.start_new_thread(self.forward, (client_socket, server_socket))
                thread.start_new_thread(self.forward, (server_socket, client_socket))

        finally:
            dock_socket.close()
            #print 'exit'
            #thread.start_new_thread(self.server)


    def forward(self,source,destination):
        string = ' '
        while string:
            string = source.recv(8192)
            if string:
                destination.sendall(string)
            else:
                #source.shutdown(socket.SHUT_RD)
                destination.shutdown(socket.SHUT_WR)


    def shutdown(self):
        #add proper code to shutdown sockets gracefully
        self.dock_socket.close()


if __name__ == '__main__':

    forwarder = forwarder('192.168.40.139',8019,'192.168.122.121',80)
