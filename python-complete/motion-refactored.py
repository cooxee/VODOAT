#!/usr/bin/env python

'''

@Author:      Diwas Bhattarai, Arjun Sharma, Darshan Amatya

@Description: This file is not used by the system
              however, this was initially used to 
              detect the motion of the moving 
              parts of the supplied image feed.
              
              This uses raw techniques to calculate 
              the feature vectors. We later on used 
              HOG to calculate the feature vectors.

'''

# Derived from http://sundararajana.blogspot.com/2007/05/motion-detection-using-opencv.html

import SimpleCV
import cv
import numpy
import time
from hog import predict
import Image

from skimage.color import rgb2grey
from skimage.io import imread

class Target:    
    #url = "http://87.139.20.112/axis-cgi/jpg/image.cgi?camera=1&resolution=640x480"
    url = "http://vso.aa0.netvolante.jp/record/current.jpg" #japan
    #url= "http://ashtech.gotdns.com/imagecrp.php" #fayard   
    #url= "http://207.251.86.238/cctv426.jpg" # new york manhatten
    #url = "http://209.166.88.226/netcam.jpg"
    #url = "http://www.zincportdouglas.com/portico_image.jpg" #australia
    '''def __init__(self):
            #cv.NamedWindow("Target", 1)'''
    def run(self):
        url = self.url
        # Capture first frame to get size
        frame = SimpleCV.Image(url).getBitmap()
        frame_size = cv.GetSize(frame)
        grey_image = cv.CreateImage(cv.GetSize(frame), cv.IPL_DEPTH_8U, 1)
        grey_image_later = cv.CreateImage(cv.GetSize(frame), cv.IPL_DEPTH_8U, 1)
        moving_average = cv.CreateImage(cv.GetSize(frame), cv.IPL_DEPTH_32F, 3)
        difference = None
        file_counter=0

        while True:
            color_image = SimpleCV.Image(url).getBitmap()
            # Smooth to get rid of false positives
            cv.Smooth(color_image, color_image, cv.CV_GAUSSIAN, 3, 0)

            if not difference:
                # Initialize
                difference = cv.CloneImage(color_image)
                temp = cv.CloneImage(color_image)
                cv.ConvertScale(color_image, moving_average, 1.0, 0.0)
            else:
                cv.RunningAvg(color_image, moving_average, 0.020, None)

            # Convert the scale of the moving average.
            cv.ConvertScale(moving_average, temp, 1.0, 0.0)

            # Minus the current frame from the moving average.
            cv.AbsDiff(color_image, temp, difference)

            # Convert the image to grayscale.
            cv.CvtColor(difference, grey_image, cv.CV_RGB2GRAY)
            cv.CvtColor(difference, grey_image_later, cv.CV_RGB2GRAY)
            

            # Convert the image to black and white.
            cv.Threshold(grey_image, grey_image, 70, 255, cv.CV_THRESH_BINARY)

            # Dilate and erode to get object blobs
            cv.Dilate(grey_image, grey_image, None, 18)
            cv.Erode(grey_image, grey_image, None, 10)

            # Calculate movements
            storage = cv.CreateMemStorage(0)
            contour = cv.FindContours(grey_image, storage, cv.CV_RETR_CCOMP, cv.CV_CHAIN_APPROX_SIMPLE)
            points = []
            count = 0
            font = cv.InitFont(cv.CV_FONT_HERSHEY_SIMPLEX, 1, 1, 0, 3, 8)
            
            while contour:
                # Draw rectangles
                bound_rect = cv.BoundingRect(list(contour))
                contour = contour.h_next()

                pt1 = (bound_rect[0], bound_rect[1])
                pt2 = (bound_rect[0] + bound_rect[2], bound_rect[1] + bound_rect[3])
                points.append(pt1)
                points.append(pt2)
                
                dist = numpy.linalg.norm(numpy.array(pt1) - numpy.array(pt2))
                center_point = (((pt1[0] + pt2[0])/2), ((pt1[1] + pt2[1])/2))
                width = pt2[0] - pt1[0]
                height = pt2[1] - pt1[1]
                area = width * height
                
                if area < 60000 and area > 30000:
                    sub = cv.GetSubRect(grey_image_later,(pt1[0],pt1[1],width,height))
                    print "sub size ", cv.GetSize(sub)
                    #sub_grey = cv.CreateImage(cv.GetSize(sub), cv.IPL_DEPTH_8U, 1)
                    #sub = rgb2grey(sub)
                    #cv.CvtColor(sub, sub_grey, cv.CV_RGB2GRAY)
                    thumbnail = cv.CreateImage((300, 197), 8, 1)
                    
                    cv.SaveImage("image.jpg",sub)
                    image = imread("image.jpg")
                    cv.Resize(cv.fromarray(image), thumbnail)
                    print "thumbnail ", cv.GetSize(thumbnail)
                    cv.SaveImage("image_resized.jpg", thumbnail)
                    
                    image_resized = imread("image_resized.jpg")
                    
                    cv.NamedWindow("Target")
                    cv.ShowImage("Target", thumbnail)
                    cv.WaitKey(0)

                    #image = imread("/media/Primary/HOG/images/train_pos/image_0001.jpg")
                    
                    #image = rgb2grey(image)
                    
                    
                    #cv_im = cv.CreateImage((320,200), cv.IPL_DEPTH_8U, 1)
                    #thumbnail = cv.CreateImage((width, height), 8, 3)
                    #cv.Copy(sub, thumbnail)
                    #thumbnail = Image.fromstring("L", cv.GetSize(sub), sub.tostring())
                    #cv.Resize(sub, thumbnail)
                    #print "resized ", type(thumbnail)
                    #time.sleep(20)
                    predict(image_resized)
                    
                    #time.sleep(500000)

                    # PutText(img, text, org, font, color)
                    #text = str(count)
                    #count += 1
                    #cv.PutText(color_image, text, (pt2[0] + 20, pt2[1] - 20), font, cv.CV_RGB(255, 255, 255))
                #cv.Circle(color_image, center_point, int(dist/2), cv.CV_RGB(255, 255, 255), 1)
                
            '''num_points = len(points)
            if num_points:
                # Draw bullseye in midpoint of all movements
                x = y = 0
                for point in points:
                    x += point[0]
                    y += point[1]
                x /= num_points
                y /= num_points
                center_point = (x, y)
                cv.Circle(color_image, center_point, 40, cv.CV_RGB(255, 255, 255), 1)
                cv.Circle(color_image, center_point, 30, cv.CV_RGB(255, 100, 0), 1)
                cv.Circle(color_image, center_point, 20, cv.CV_RGB(255, 255, 255), 1)
                cv.Circle(color_image, center_point, 10, cv.CV_RGB(255, 100, 0), 5)
            '''
            # Display frame to user
        #cv.ShowImage("Target", color_image)

            # Listen for ESC or ENTER key
            c = cv.WaitKey(7) % 0x100
            if c == 27 or c == 10:
                break

if __name__=="__main__":
    t = Target()
    t.run()
