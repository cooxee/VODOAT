#!/usr/bin/python

'''
@Author:      Diwas Bhattarai
@Description: Client side of socket communication to send image
              to the server for HOG/SVM processing.
'''

import socket
import os
class SocketClient:
    SOCKET_PORT = 5005
    client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    
    def __init__(self):
        #img = open('img.jpg','r')
        self.client_socket.connect(("", self.SOCKET_PORT))
        print 'init\n\n'
        img = ''
        #sendImage(img)
            
    def sendImage(self, img):
        img = open('img.jpg','r')
        while True:
            image_string = img.readline(512)
            if not image_string:
                break
            self.client_socket.send(image_string)
        img.close()
        print "Data sent successfully"
    
if __name__ == "__main__":
    SocketClient().sendImage('')
