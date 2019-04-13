<?php
final class Conection{
	private $conection;
	private $host;
	private $user;
	private $pwd;
	private $db;
	private $type;

	public function getConection(){
		return $this->conection;
	}
	public function setConection($c){
		$this->conection = (isset($c)) ? $c : NULL;	
	}
	public function getHost(){
		return $this->host;
	}
	public function setHost($s){
		$this->host = (isset($s)) ? $s : NULL;
	}
	public function getUser(){
		return $this->user;
	}
	public function setUser($u){
		$this->user = (isset($u)) ? $u : NULL;
	}
	public function getPwd(){
		return $this->pwd;
	}
	public function setPwd($s){
		$this->pwd = (isset($s)) ? $s : NULL;
	}
	public function getDb(){
		return $this->db;
	}
	public function setDb($b){
		$this->db = (isset($b)) ? $b : NULL;
	}
	public function getType(){
		return $this->type;
	}
	public function setType($t){
		$this->type = (isset($t)) ? $t : NULL;
	}
	private function analiseData(){
		if($this->getHost() == NULL || $this->getUser() == NULL || $this->getPwd() == NULL || $this->getDb() == NULL || $this->getType() == NULL){
			return false;	
		}else{
			return true;
		}
	}
	public function __construct($config){
		try{
			if(file_exists("$config")){
				$arquivo = parse_ini_file("$config");
				$this->setHost($arquivo['host']);
				$this->setUser($arquivo['user']);
				$this->setPwd($arquivo['pass']);
				$this->setDb($arquivo['name']);
				$this->setType($arquivo['type']);
				if($this->analiseData()){
					switch($this->getType()){
						case "mysql":
							try{
								$this->setConection(new PDO("mysql:host={$this->getHost()};dbname={$this->getDb()}",$this->getUser(),$this->getPwd(),array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')));
								$this->getConection()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								$this->getConection()->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
							}catch(PDOException $e){
								echo "Error when attempting to connect BD: {$e->getMessage()}";
							}
							break;
						case "sqlite":
							try{
								$this->setConection(new PDO("sqlite:$this->getDb()"));
							
							}catch(PDOException $e){
								echo "Error when attempting to connect BD" . $e->getMessage();
							}
							break;
						default:
							throw new Exception("Not compatible SGBD");
					}
					

				}else{
					throw new Exception("Wrong informations on config file");
				}
			}else{
				throw new Exception("Config file not found");
			}
		}catch(Exception $ex){
			echo "Error: " . $ex->getMessage();
		}
	}
	public function __destruct(){
		$this->setConection(null);
	}

}
?>
