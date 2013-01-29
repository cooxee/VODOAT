#!/usr/bin/python
# TCP client example
import socket,os

SOCKET_PORT = 5005
client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
client_socket.connect(("", SOCKET_PORT))
k = ' '
size = 1024

while(1):
    k = "(x,y),(x,y),(x,y),(x,y)"
    client_socket.send(k)
    k = int (k)
    if(k == 1):
        print "Enter file name\n"
        strng = raw_input()
        client_socket.send(strng)
        size = client_socket.recv(1024)
        size = int(size)
        print "The file size is - ",size," bytes"
        size = size*2
        strng = client_socket.recv(size)
        print "\nThe contents of that file - "
        print strng

    if (k==2 or k==3):
        print "Enter file name of the image with extentsion (example: filename.jpg,filename.png or if a video file then filename.mpg etc) - "
        fname = raw_input()
        client_socket.send(fname)
        fname = 'fname'
        fp = open(fname,'w')
        while True:
            strng = client_socket.recv(512)
            if not strng:
                break
            fp.write(strng)
        fp.close()
        print "Data Received successfully"
        exit()
        #data = 'viewnior '+fname
        #os.system(data)