<?php


if(!isset($_POST) || invalidPost()){
    echo "Null Pointer Exception";
    exit;
}

$myFile = "coordinates.txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$count = 1;
foreach($_POST as $key=>$value){
    fwrite($fh, $value);
    if($count % 8 == 0){
        fwrite($fh, "\n");
    }else{
        fwrite($fh, ",");
    }
    $count++;
}

fclose($fh);

echo "You got it!";


function invalidPost(){
    for($i = 0; $i < 12; $i++){
        if($_POST['form_x'.$i] == "" || $_POST['form_y'.$i] == ""){
            return true;
        }
    }
    return false;
}

?>
