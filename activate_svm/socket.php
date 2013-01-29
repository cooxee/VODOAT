<?php
$fp = stream_socket_client("tcp://localhost:5005", $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    $i = 0;
    while($i<=10){
    fwrite($fp, "GET / HTTP/1.0\r\nTrigger: Randi lai chick".$i."\r\nAccept: */*\r\n\r\n");
    //while (!feof($fp)) {
    //    echo fgets($fp, 1024);
    //}
    $i++;
    sleep(1);
    }
    fclose($fp);
}
?>
