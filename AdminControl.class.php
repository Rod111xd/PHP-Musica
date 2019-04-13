<?php
require_once("Conection.class.php");
require_once("Admin.class.php");
class AdminControl {
	public function signIn($name,$pwd){
		$conection = new Conection("lib/mysql.ini");
		$sql = "SELECT * FROM admin WHERE name='{$name}'";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$r = $consult->fetch();
		if($r!=false){
			if($pwd===$r->pwd){
				session_start();
				$_SESSION['admin'] = $r->id;
				$sql = "UPDATE admin SET logged=1 WHERE id={$r->id}";
				$consult = $conection->getConection()->prepare($sql);
				$consult->execute();
				$result=true;
			}else{
				$result=false;	
			}
		}else{
			$result=false;
		}
		$conection-> __destruct();
		return $result;
	}
	public function signOut($id){
		$conection = new Conection("lib/mysql.ini");
		$sql = "UPDATE admin SET logged=0 WHERE id='{$id}'";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$conection-> __destruct();
	}
	public function selectAdmin($id){
		$conection = new Conection("lib/mysql.ini");
		$admin = new Admin();
		$sql = "SELECT * FROM admin WHERE id='{$id}'";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$r = $consult->fetch();
		if($r){
			$admin->setId($r->id);
			$admin->setName($r->name);
			$admin->setPwd($r->pwd);
			$admin->setLogged($r->logged);
		}
		$conection-> __destruct();
		return $admin;
	}
}
?>