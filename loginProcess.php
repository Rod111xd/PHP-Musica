<?php
	if($_POST['loginType']=="userLogin"){
		$user = $_POST['user'];
		$pwd = $_POST['pwd'];
		
		require_once("UserControl.class.php");
		$uC = new UserControl();
		$result = $uC->signIn($user,$pwd);
		if(!$result){
			session_start();
			$_SESSION['userErrorLogin'] = true;
		}
		header("location:userLoginRegister.php");
	}else{
		$admin = $_POST['admin'];
		$pwd = $_POST['pwd'];
		
		require_once("AdminControl.class.php");
		$aC = new AdminControl();
		$result = $aC->signIn($admin,$pwd);
		var_dump($result);
		if(!$result){
			session_start();
			$_SESSION['adminErrorLogin'] = true;
		}
		header("location:adminLogin.php");
	}
	


?>