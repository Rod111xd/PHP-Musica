<?php
	session_start();
	if(isset($_SESSION['user']) || isset($_SESSION['admin'])){
		header("location:index.php");
	}
	$user = $_POST['user'];
	$pwd = $_POST['pwd'];
	$pwdConfirm = $_POST['pwdConfirm'];
	if($pwd===$pwdConfirm){
		$img = $_FILES['img'];
		$imgContent = addslashes(file_get_contents($img['tmp_name']));
		$preferences = implode("/",$_POST['preferences']);
		require_once("User.class.php");
		require_once("UserControl.class.php");
		require_once("Image.class.php");
		require_once("ImageControl.class.php");
		$u = new User();
		$uC = new UserControl();
		$u->setName($user);
		$u->setPwd($pwd);
		$u->setPreferences($preferences);
		$r = $uC->signUp($u);
		if($r){
			$uC->signIn($user,$pwd);

			$i = new Image();
			$iC = new ImageControl();
			$i->setData($imgContent);
			$i->setName($img['name']);
			$i->setSize($img['size']);
			$i->setType($img['type']);
			$i->setUserId($_SESSION['user']);
			$r2 = $iC->insertImage($i);
			if($r2){
				$result = true;	
			}else{
				$result = false;
			}
		}else{
			$result = false;
		}
	}else{
		$result = false;
	}
	if(!$result){
		$_SESSION['userErrorRegister'] = true;	
	}
	header("location:userLoginRegister.php");


?>