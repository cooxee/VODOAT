<?php
/**
*   @Author:      Arjun Sharma
*   @Description: Used to get the state of the parking spots
*                 by reading 'current_state.txt' while 
*                 making AJAX request from the main page.
**/

$myfile = file('./current_state.txt');
$text=" ";
foreach($myfile as $line){
    $text = $text.$line.",";   
}
echo substr($text,0,(strlen($text)-1));
