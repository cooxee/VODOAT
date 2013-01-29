import numpy
import Image, ImageDraw

# read image as RGB and add alpha (transparency)
im = Image.open("lena.jpg").convert("RGBA")

# convert to numpy (for convenience)
imArray = numpy.asarray(im)

# create mask
polygon = [(100,100), (200,100), (150,150)]
maskIm = Image.new('L', (imArray.shape[0], imArray.shape[1]), 0)
ImageDraw.Draw(maskIm).polygon(polygon, outline=1, fill=1)
mask = numpy.array(maskIm)

# assemble new image (uint8: 0-255)
newImArray = numpy.empty(imArray.shape,dtype='uint8')

# colors (three first columns, RGB)
newImArray[:,:,:3] = imArray[:,:,:3]

# transparency (4th column)
newImArray[:,:,3] = mask*255          

# back to Image from numpy
newIm = Image.fromarray(newImArray, "RGBA")
newIm.save("lena3.png")
