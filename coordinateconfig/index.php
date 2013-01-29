<?php 
?>
<html>
<head>

<script language="JavaScript">
var count = 0;
function point_it(event){
	pos_x = event.offsetX?(event.offsetX):event.pageX-document.getElementById("pointer_div").offsetLeft;
	pos_y = event.offsetY?(event.offsetY):event.pageY-document.getElementById("pointer_div").offsetTop;
	document.getElementById("cross").style.left = (pos_x-1) ;
	document.getElementById("cross").style.top = (pos_y-15) ;
	document.getElementById("cross").style.visibility = "visible";
    document.getElementById("form_x"+count).value = pos_x;
    document.getElementById("form_y"+count).value = pos_y;
	count = count + 1;
}
</script>
</head>
<body>
<?php
$setting = file("/var/www/coordinateconfig/setting.txt");
//@$url    = ($_GET['url'])?:"http://192.168.1.2/imagecrp.php";
$url = trim($setting[0]);
//$url = "http://192.168.1.2/images/*-0.jpg";
$split = explode(".", $url);
if(trim($split[count($split)-1]) == "png"){
    $image = imagecreatefrompng($url);
}else{
    $image  = imagecreatefromjpeg($url);
}
$width  = imagesx($image);
$height = imagesy($image);

?>
<form name="pointform" method="post" id="pform" action="coordinate_submit.php">
<div id ="pointer_div" onclick="point_it(event)" style = "background-image:url(<?php  var_export($url); ?>);width:<?php echo $width; ?>;height:<?php echo $height; ?>;">
<img src ="" id="cross" style="position:relative;visibility:hidden;z-index:2;"></div>
<table >
<tr>
<?php
    $count = 0;
    for ($i = 0; $i < 3; $i++){
        echo "<td  width='200'>";
        echo "Box ".($i+1)."<br/>";
        for ($j = 0; $j < 4; $j++){?>
            x = <input type='text' id='<?php echo "form_x".$count;?>' name='<?php echo "form_x".$count;?>' size='4' /> - y = <input type='text' id='<?php echo "form_y".$count;?>' name='<?php echo "form_y".$count; ?>' size='4' /><br/><?php
            $count++;
        }
        echo "</td>";
    }
?>
<td width="200">
    <input type="submit"/>
</td>
</tr>
</table>
</form> 
</body>
</html>
