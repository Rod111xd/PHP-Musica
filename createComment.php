<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header("location:index.php");
	}
	require_once("Comment.class.php");
	require_once("CommentControl.class.php");
	$com = new Comment();
	$cC = new CommentControl();
	
	$text = addslashes($_POST['text']);
	$postId = $_POST['postId'];
	date_default_timezone_set("America/Fortaleza");
	$date = new DateTime();

	$com->setText($text);
	$com->setDate($date);
	$com->setPostId($postId);
	$com->setAuthor($_SESSION['user']);
	if($_GET['type']=="reply"){
		$commentId = $_POST['commentId'];
		$com->setCommentId($commentId);
	}

	$cC->insertComment($com);

	header("location:content.php?id={$postId}#postComments");
?>