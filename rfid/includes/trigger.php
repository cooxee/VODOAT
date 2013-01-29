<?php
/**
 *Description: Triggers the python daemon listening at port 5005
 *with a http request 
 *
 * @author    Arjun Sharma
 *
 * 
 */
class trigger{
    
    public function __construct(){
        
    }
    /*
     *triggers the call to the python object
     *
     */
    public function trigger(){
        $fp = stream_socket_client("tcp://localhost:5005", $errno, $errstr, 30);
        if (!$fp) {
            
        } else {
            fwrite($fp, "GET / HTTP/1.0\r\nTrigger: Start Process".$i."\r\nAccept: */*\r\n\r\n");
            fclose($fp);
        }
    }
    
}

?>