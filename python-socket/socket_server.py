#!/usr/bin/python

'''
@Author:      Diwas Bhattarai
@Description: Receives image from client in socket.
              This is not actually implemented in the 
              system but is made just to test the 
              flow of the images from one side to 
              the other.

              This code should be integrated with SVM.
    
              For this to work, client in the socket should 
              send:
              a. String coordinate as String in format:
                 x,y
              b. Image data
    
'''

import socket,os
from PIL import Image
import StringIO

class SocketServer:
    SOCKET_PORT = 5005
    SIZE_DELIMITER = ","
    server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    
    def __init__(self):
        self.server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
        self.server_socket.bind(("", self.SOCKET_PORT))

    def receiveData(self):
        #print 'here'
        self.server_socket.listen(5)
        while(1):
            print 'ayo'
            client_socket, address = self.server_socket.accept()
            print "Connected to - ", address
            raw_image_string = ''
            image_binary = ''
            while True:
                raw_image_string = client_socket.recv(512)
                if not raw_image_string:
                    break
                print raw_image_string
                #image_binary += raw_image_string
            #img=Image.open(StringIO.StringIO(image_binary))
            #print img.size
            print "Data Received successfully\n\n"
            #exit()
            #image_binary += image_string
if __name__ == "__main__":
    SocketServer().receiveData()
