<?php
/**
*   @Author:      Arjun Sharma, Diwas Bhattarai
*   @Description: Takes in 4 pairs of (x, y) and uses min-max
*                 algorithm to crop the image rectangularly. 
*                 This is used because the perspective of the
*                 parking lot from the camera is not rectangular
*                 and images cannot be cropped unless it is 
*                 rectangular in shape.
**/

// set up array of points for polygon
$x1     = $_GET['x1'];
$x2     = $_GET['x2'];
$x3     = $_GET['x3'];
$x4     = $_GET['x4'];
$y1     = $_GET['y1'];
$y2     = $_GET['y2'];
$y3     = $_GET['y3'];
$y4     = $_GET['y4'];
$status = false;
for($i = 1; $i<5; $i++){
    $xget = "x".$i;
    $yget = "y".$i;
    if(!isset($$xget) or !isset($$yget)){
        echo $xget." or ".$yget." not set <br />";
        $status = true;
    }
}
if($status){
    exit;
}

//$values = array(
//            587,585,739,561,779,590,619,620
//            );
$values = array(
            $x1,$y1,$x2,$y2,$x3,$y3,$x4,$y4
            );

// create image
$image  = imagecreatefromjpeg('http://192.168.1.2/imagecrp.php'); 
$width  = imagesx($image);
$height = imagesy($image);
 
// create masking
$mask         = imagecreatetruecolor($width, $height);
$transparent  = imagecolorallocate($mask, 255, 0, 0 );
//$transparancy = 
imagecolortransparent($mask, $transparent);

imagefilledpolygon($mask, $values, 4, $transparent);



imagecopy($image, $mask, 0, 0, 0, 0, $width, $height);
imagecolortransparent($image, $transparent);
imagefill($image,0,0, $transparent);
//the image here is the shit
foreach($values as $key => $item){
    if($key % 2 == 0 ){
        $x[] = $item;
    }else{
        $y[] = $item;
    }
}



$minx = min($x);
$miny = min($y);
$maxx = max($x);
$maxy = max($y);
$cropped_width  =  $maxx - $minx;
$cropped_height =  $maxy - $miny;
$start_point     =  array($minx, $miny);
//echo "width is ".$cropped_width." and the height is ".$cropped_height;
//print_r($start_point);
$dest = imagecreatetruecolor($cropped_width, $cropped_height);
// Copy
imagecopy($dest, $image, 0, 0, $minx, $miny, $cropped_width, $cropped_height);

// output and free memory
header('Content-type: image/png');
imagepng($dest);
imagedestroy($image);
imagedestroy($mask);
imagedestroy($dest);
?>
