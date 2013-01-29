<?php
/**
*       @Author:      Arjun Sharma, Diwas Bhattarai
*       @Description: This is a tool to extract manual data
*                     from the dataset. This reads in the 
*                     coordinates from coordinates.txt and
*                     reads whether the supplied image is a positive
*                     or negative sample from setting.txt and using
*                     'imagemagick' library the image is cropped into
*                     smaller parking spot images and put into appropiate
*                     positive or negative samples' directories.
*
*/

$file  = "/var/www/coordinateconfig/coordinates.txt";
$setting = file("/var/www/coordinateconfig/setting.txt");
$lines = file($file);
if(count($file>0)){
    foreach($lines as $line){
        $coordinates = explode(',',$line);
        //var_dump($lines);
        //var_dump($setting);
        if(count($coordinates) == 8 and count($setting) ==2 ){
            imagecrop($coordinates,$setting);
        }
    }
}


function imagecrop($coordinate, $setting){
    $values = $coordinate;
    // create image
    $image  = imagecreatefromjpeg(trim($setting[0]));
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
    if($setting[1] == 0){
        $location = "./negative_sample/";
    }else{
        $location = "./positive_sample/";
    }
    $imagename = $location.uniqid().".png";
    //echo $imagename;
    //$im = imagecreatefrompng($imagename);
    //header('Content-Type: image/png');
    imagepng($dest,$imagename);
    // output and free memory
    // header('Content-type: image/png');
    //imagepng($dest);
    imagedestroy($image);
    imagedestroy($mask);
    imagedestroy($dest);
    echo "Saved ".$setting[0]." ".$imagename."<br/>";
}

?>
