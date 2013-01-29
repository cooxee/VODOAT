'''
@Author:      Diwas Bhattarai

@Description: hog or Histogram of Oriented Gradients 
              is the way feature vectors are calculated 
              to predict the state of the parking spot.
              This script trains the sample positive and
              negative images using SVM and predicts
              the state of the supplied image.

'''

from skimage.feature import hog
from skimage import data, color, exposure
import skimage.transform
from skimage.io import imread
from skimage import data_dir
import os, sys
import Image
from skimage.color import rgb2grey
import numpy as np
import random
from mlpy import *
import urllib2

#path of training positive and negative samples
path = ['samples/positive_samples/', 'samples/negative_samples/']
# 1 = vehicle present; -1 = vehicle not present
classes = [1, -1]
svmObject = None
features = []
labels = []

# create svm object and train it using the training samples
def createObject():
    count = 0
    while(count <= 1):
            listing = os.listdir(path[count])
            for inputFile in listing:
                inputFile = path[count]+inputFile
                print inputFile
                image = imread(inputFile)
                image = rgb2grey(image)

                fd, hog_image = hog(image, orientations=9, pixels_per_cell=(16, 16),
                                    cells_per_block=(1, 1), visualise=True,normalise=True)
                print len(fd)
                features.append(fd)
                labels.append(classes[count])
            count += 1
                

    features_np = np.asarray(features)
    labels_np = np.asarray(labels)
    global svmObject
    svmObject = Svm()
    svmObject.compute(features_np, labels_np)
    return svmObject
        
# create svm object if not created already
def getSVMInstance():
    global svmObject
    if(svmObject == None):
        svmObject = createObject()
        return svmObject
    else:
        return svmObject

# test method, not used by the system.
def predict(image):
    svmObject = getSVMInstance()
    image = rgb2grey(image)
    fd = hog(image, orientations=9, pixels_per_cell=(16, 16), cells_per_block=(1, 1), visualise=False,normalise=True)
    print svmObject.predict(fd)

# predict if the current parking state has vehicle or not
# called by image-controller.py
def predict(image_url, fileName=None):
    svmObject = getSVMInstance()
    image_url = image_url.replace(' ', '')[:-1] # to remove \n
    fileName = "temp.png"
    getImageAndSave(image_url)
    image = imread(fileName)
    image = skimage.transform.resize(image, (100,100))
    image = rgb2grey(image)
    fd = hog(image, orientations=9, pixels_per_cell=(16, 16), cells_per_block=(1, 1), visualise=False,normalise=True)
    prediction = svmObject.predict(fd)
    return prediction
    
        

def getImageAndSave(image_url, fileName="temp.png"):
    import cStringIO
    import urllib
    import Image
    while(True):
        try:
            file = urllib.urlopen(image_url)
            im = cStringIO.StringIO(file.read())
            img = Image.open(im)

            # using PIL
            img.save(fileName)

            # delete img if you need to save space and work on large images
            del img
            break
        except IOError:
            print "Cannot fetch url. Trying again."

# test prediction -- not used by the system
if __name__ == "__main__":
    svmObject = getSVMInstance()
    image = imread("samples/negative_samples/images_22.png")
    print type(image)
    image = rgb2grey(image)
    fd, hog_image = hog(image, orientations=9, pixels_per_cell=(16, 16), cells_per_block=(1, 1), visualise=True,normalise=True)

    result, rv = svmObject.predict(fd)
    print result, rv
