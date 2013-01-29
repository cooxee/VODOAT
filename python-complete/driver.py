import cv
from skimage.io import imread


image = imread('image.jpg')
thumbnail = cv.CreateImage((300, 197), cv.IPL_DEPTH_8U, 1)
cv.Resize(cv.fromarray(image), thumbnail)

cv.NamedWindow("t")
cv.ShowImage("t", thumbnail)
cv.WaitKey(0)
