<?php
	require_once("ImageControl.class.php");
	$iC = new ImageControl();
	if($_GET['type']=="user"){
		$img = $iC->selectUserImage($_GET['imgId']);
	}elseif($_GET['type']=="post"){
		$img = $iC->selectPostImage($_GET['imgId']);
	}else{
		$img = $iC->selectTextPostImage($_GET['imgId']);
	}
	header("Content-type: {$img->getType()}"); 
	echo $img->getData(); 
?>