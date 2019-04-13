<?php
	session_start();
	if((!isset($_SESSION['user'])) || (!isset($_GET['id'])) || (!isset($_GET['postId'])) || (!isset($_GET['onlyreplie']))){
		header("location:index.php");
	}
	require_once("CommentControl.class.php");
	$cC = new CommentControl();
	
	$commentId = $_GET['id'];
	$postId = $_GET['postId'];
	if($_GET['onlyreplie']=="true"){
		$cC->removeReplie($commentId);
	}else{
		$cC->removeComment($commentId);	
	}
	
	
	header("location:content.php?id={$postId}#postComments");
?>