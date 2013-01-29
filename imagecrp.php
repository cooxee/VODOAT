<?php

/**
*   @Author:      Arjun Sharma
*   @Description: Helpful tool to manually crop the
*                 full parking lot image into a region
*                 of interest.
**/
error_reporting(E_ALL);
ini_set('display_errors','On');
header("Content-type: image/jpeg");
$picture = new Imagick('http://147.174.73.17/snap.jpg');
$picture->cropImage( 675,400, 160,375 );
//$geo = $picture->getImageGeometry();
echo $picture;

?>
