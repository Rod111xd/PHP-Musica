<?php
	session_start();
	if(isset($_SESSION['admin'])){
		$admin = $_SESSION['admin'];
		require_once("AdminControl.class.php");
		$aC = new AdminControl();
		$aC->signOut($admin);
		$_SESSION['admin']=NULL;
	}elseif(isset($_SESSION['user'])){
		$user = $_SESSION['user'];
		require_once("UserControl.class.php");
		$uC = new UserControl();
		$uC->signOut($user);
		$_SESSION['user']=NULL;
	}
	session_destroy();
	header("location:index.php");

?>