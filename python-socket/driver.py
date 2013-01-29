#!/usr/bin/python

from socket_client import *
from socket_server import *
import thread
import time

socket_server = SocketServer()
thread.start_new_thread(socket_server.receiveData, ())

socket_client = SocketClient()
socket_client.sendImage('')
print 'done'
