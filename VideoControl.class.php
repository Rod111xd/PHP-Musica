<?php
require_once("Conection.class.php");
require_once("Video.class.php");
class VideoControl {
	public function selectVideo($id){
		$conection = new Conection("lib/mysql.ini");
		$sql = "SELECT * FROM video WHERE id={$id}";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$r = $consult->fetch();
		$vid = new Video();
		$vid->setId($r->id);
		$vid->setData($r->data);
		$vid->setName($r->name);
		$vid->setSize($r->size);
		$vid->setType($r->type);
		$conection-> __destruct();
		return $vid;
	}

	public function insertVideo($vid){
		$conection = new Conection("lib/mysql.ini");
		$sql = "INSERT INTO video (data,name,size,type,id_post) VALUES ('{$vid->getData()}','{$vid->getName()}',{$vid->getSize()},'{$vid->getType()}',{$vid->getPostId()})";
		$consult = $conection->getConection()->prepare($sql);
		$r = $consult->execute();
		$lastId = $conection->getConection()->lastInsertId();
		$conection-> __destruct();
		return $lastId;
	}

	public function editVideo($vid){
		$conection = new Conection("lib/mysql.ini");
		$sql = "UPDATE video SET data='{$vid->getData()}',name='{$vid->getName()}',size='{$vid->getSize()}',type='{$vid->getType()}' WHERE id_post={$vid->getPostId()}";
		$consult = $conection->getConection()->prepare($sql);
		$r = $consult->execute();
		$conection-> __destruct();
		return $r;
	}

	public function removeVideo($id){
		$conection = new Conection("lib/mysql.ini");
		$sql = "DELETE FROM video WHERE id_post={$id}";
		$consult = $conection->getConection()->prepare($sql);
		$r = $consult->execute();
		$conection-> __destruct();
		return $r;
	}
}
?>