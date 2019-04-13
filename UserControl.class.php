<?php
require_once("Conection.class.php");
require_once("User.class.php");
class UserControl {
	public function signIn($name,$pwd){
		$conection = new Conection("lib/mysql.ini");
		$sql = "SELECT * FROM user WHERE name='{$name}' AND pwd='{$pwd}'";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$r = $consult->fetch();
		if($r!=false){
			session_start();
			$_SESSION['user'] = $r->id;
			$sql = "UPDATE user SET logged=1 WHERE id={$r->id}";
			$consult = $conection->getConection()->prepare($sql);
			$consult->execute();
			$result=true;
		}else{
			$result=false;
		}
		$conection-> __destruct();
		return $result;
	}
	public function signOut($id){
		$conection = new Conection("lib/mysql.ini");
		$sql = "UPDATE user SET logged=0 WHERE id='{$id}'";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$conection-> __destruct();
	}
	public function signUp($user){
		$conection = new Conection("lib/mysql.ini");
		$sql = "SELECT * FROM user WHERE name='{$user->getName()}'";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$r = $consult->fetch();
		if(!$r){
			$sql2 = "INSERT INTO user (name,pwd,preferences,logged) values ('{$user->getName()}','{$user->getPwd()}','{$user->getPreferences()}',0)";
			$consult2 = $conection->getConection()->prepare($sql2);
			$consult2 = $consult2->execute();
			if($consult2){
				$result = true;
			}else{
				$result = false;
			}
		}else{
			$result = false;
		}
		$conection-> __destruct();
		return $result;
	}
	public function selectUser($id){
		$conection = new Conection("lib/mysql.ini");
		$admin = new User();
		$sql = "SELECT * FROM user WHERE id='{$id}'";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$r = $consult->fetch();
		if($r){
			$admin->setId($r->id);
			$admin->setName($r->name);
			$admin->setPwd($r->pwd);
			$admin->setPreferences($r->preferences);
			$admin->setLogged($r->logged);
		}
		$conection-> __destruct();
		return $admin;
	}
}
?>