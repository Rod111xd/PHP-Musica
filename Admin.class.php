<?php
class Admin {
	private $id;
	private $name;
	private $pwd;
	private $logged;
	
	public function getId(){
		return $this->id;
	}
	public function setId($i){
		$this->id = $i;
	}
	public function getName(){
		return $this->name;
	}
	public function setName($n){
		$this->name = $n;
	}
	public function getPwd(){
		return $this->pwd;
	}
	public function setPwd($p){
		$this->pwd = $p;
	}
	public function getLogged(){
		return $this->logged;
	}
	public function setLogged($l){
		$this->logged = $l;
	}	
}
?>