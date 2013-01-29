'''
    This code should be integrated with SVM.
    
    For this to work, client in the socket should 
    send:
    a. String coordinate in format:
         (x,y),(x,y),(x,y),(x,y)
          TopL  TopR  BotR  BotL
    b. Image data
    
'''

import socket
import os

SOCKET_PORT = 5005
server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
server_socket.bind(("", SOCKET_PORT))
server_socket.listen(5)

client_socket, address = server_socket.accept()
print "Conencted to - ",address,"\n"
while (1):
    coordinates = client_socket.recv(1024)
    coordinates = int(coordinates)
    if(coordinates == 1):
        data = client_socket.recv(1024)
        print "The following data was received - ",data
        print "Opening file - ",data
        fp = open(data,'r')
        strng = fp.read()
        size = os.path.getsize(data)
        size = str(size)
        client_socket.send(size)
        client_socket.send (strng)
        #client_socket.close()

    if (coordinates == 2 or coordinates == 3):
        data = client_socket.recv(1024)
        print "The following data was received - ",data
        print "Opening file - ",data
        img = open(data,'r')
        while True:
            strng = img.readline(512)
            if not strng:
                break
            client_socket.send(strng)
        img.close()
        print "Data sent successfully"
        exit()
        #data = 'viewnior '+data
        #os.system(data)