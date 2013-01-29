<div id="page">
<?php echo "Welcome, ".$this->session->userdata('username'); ?>
<?php
echo "<hr/>";
echo "<button id='adduser'>Add User</button>";
if(isset($enabletable)){
    
    echo "<br/>";
    echo "Active User";
    echo $enabletable;
}

if(isset($disabletable)){
   
    echo "<br/>";
    echo "Inactive User";
    echo $disabletable;
}

?>
</div>