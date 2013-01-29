<?php
echo $header;
if(isset($menu)){
    echo $menu;
}
?>
<?php if ($this->session->flashdata('result') != ''): ?>
	<script type="text/javascript">
	<!--
	$(document).ready(function() {
                $.jGrowl.defaults.position = 'bottom-right';
		$.jGrowl("<?php echo $this->session->flashdata('result') ?>");	
	});
	//-->				
	</script>
<?endif; ?>
<?php
echo $content;
echo $footer;
echo "<div id='modal'><div id='modalcont'></div></div>";
?>