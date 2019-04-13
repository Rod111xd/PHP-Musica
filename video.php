<?php
	require_once("VideoControl.class.php");
	$vC = new VideoControl();
	
	$vid = $vC->selectVideo($_GET['vidId']);
	
	header("Content-type: {$vid->getType()}"); 
	echo $vid->getData(); 
?>