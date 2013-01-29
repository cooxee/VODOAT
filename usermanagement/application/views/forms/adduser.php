<div id="jerror"></div>
<?php
// view for add user
echo $open;
echo "<li>";
echo $tag_id['label'];
echo $tag_id['input'];echo "<br/><br/>";
echo "</li>";
echo "<li>";
echo $fname['label'];
echo $fname['input'];echo "<br/><br/>";
echo "</li>";
echo "<li>";
echo $lname['label'];
echo $lname['input'];echo "<br/><br/>";
echo "</li>";
echo "<li>";
echo $wnumber['label'];
echo $wnumber['input'];echo "<br/><br/>";
echo "</li>";
echo "<li>";
echo $carmodel['label'];
echo $carmodel['input'];echo "<br/><br/>";
echo "</li>";
echo "<li>";
echo $start_time['label'];
echo $start_time['input'];echo "<br/><br/>";
echo "</li>";
echo "<li>";
echo $end_time['label'];
echo $end_time['input'];echo "<br/><br/>";
echo "</li>";
?>

<div style = "margin-left: 200px"><?php echo $submit ?></div>

<?php
echo $close;
?>
