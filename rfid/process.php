<?php
/**
 *Description: gets the rfid tag number from the
 *             get request (from the arduino)
 *
 * @author    Arjun Sharma
 *
 * 
 */
include_once('./includes/user.php');// to use the user object

include_once("./includes/db.php");// for database parameters

include_once("./includes/rfid.php");// for the log entry function

include_once("./includes/trigger.php");// for triggering the python daemon
$rfid          = new rfid();
@$a            = $_GET['i'];// $a is the tag number from the get request
if(!isset($a)){
    echo "No Rfid Tag";
    exit;
}
//make sure that a tag is not used twice
if(intval($rfid->lastid) == intval($a)){
    echo "+0-";
    exit;
}else{
    if(is_int(intval($a))){// making sure the rfid tag is numeric
        $myFile     = "test.txt";
        $fh         = fopen($myFile, 'w') or die("can't open file");
        $stringData = $a."\n";
        fwrite($fh, $stringData);
        fclose($fh);
        $rfid -> add_database($a);
        //now we will create a user object of the tag and see if the user
        // is authorized
        $user = new user();
        $user -> settag($a);
        $trigger = new trigger();
        // if the user is authorized call the python daemon for the process
        if($user -> authorized){
            echo "+1-";
            $trigger -> trigger();
        }else{
            echo "+0-";
        }
    }else{
        exit;
    }
}
?>
