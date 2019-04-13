<?php
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		session_start();
		if(isset($_SESSION['admin'])){
			$admin = $_SESSION['admin'];
			require_once("PostControl.class.php");
			require_once("ImageControl.class.php");
			require_once("VideoControl.class.php");
			require_once("CommentControl.class.php");
			$pC = new PostControl();
			$iC = new ImageControl();
			$vC = new VideoControl();
			$cC = new CommentControl();
			$cC->removePostComments($id);
			$iC->removeImage($id);
			$vC->removeVideo($id);
			$pC->removePost($id);
		}
	}
	header("location:index.php");

?>