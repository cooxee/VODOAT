'''
@Author:      Diwas Bhattarai

@Description: This script runs constantly fetching the images and 
              constantly predicting the state of the parking lot 
              every 30 seconds. 

              It calls hog.py and invokes its predict method which
              handles the training of the samples on the first run.

              This script should be the first to run as it might
              take some time to train the sample images.

'''
import SimpleCV
from hog import predict
import time

class ImageController:
    # path of set of coordinates of the parking spots
    COORDINATES_FILE_NAME = "../coordinateconfig/coordinates.txt"
    # splitter of data structure of coordinates file
    COORDINATES_SPLIT_DELIMITER = ","
    # parking spot states
    PARKING_STATE_FILE_NAME = "../current_state.txt"
    
    # save states of parking spots to file
    def saveToFile(self, prediction):
        parkingStateFile = open(self.PARKING_STATE_FILE_NAME, 'w')
        for x in range(len(prediction)):
            if(prediction[x] == -1):
                parkingStateFile.write("0\n")
            else:
                parkingStateFile.write("1\n")
    
    # crop image according to the coordinates supplied
    def callImageCropper(self):
        while(True):
            url = "http://localhost/image_cropper.php"
            coordinatesFile = open(self.COORDINATES_FILE_NAME)
            currentState = []
            print "---------------------------------------"
            for content in coordinatesFile:
                coordinates = content.split(self.COORDINATES_SPLIT_DELIMITER)
                getString = "";
                count = 0
                for x in range(len(coordinates)/2):
                        getString = getString + "x" + str(x+1) + "=" + str(coordinates[count]) + "&"
                        count = count + 1
                        getString = getString + "y" + str(x+1) + "=" + str(coordinates[count]) + "&"
                        count = count + 1
                getString = getString.replace('', '')[:-1]
                url = url + "?" + getString
                # predict method in 'hog.py'
                prediction = predict(url, self.PARKING_STATE_FILE_NAME)
                print url
                print prediction
                currentState.append(prediction)
                url = "http://localhost/image_cropper.php"
            self.saveToFile(currentState)
            del currentState[:]
            time.sleep(30)
            
    
    

if __name__ == "__main__":
    ImageController().callImageCropper()            
