<?php
require_once("Conection.class.php");
require_once("Image.class.php");
class ImageControl {
	public function selectPostImage($id){
		$conection = new Conection("lib/mysql.ini");
		$sql = "SELECT * FROM image WHERE id_post={$id} AND mainImage=1";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$r = $consult->fetch();
		$img = new Image();
		$img->setId($r->id);
		$img->setData($r->data);
		$img->setName($r->name);
		$img->setSize($r->size);
		$img->setType($r->type);
		$conection-> __destruct();
		return $img;
	}

	public function selectTextPostImage($id){
		$conection = new Conection("lib/mysql.ini");
		$sql = "SELECT * FROM image WHERE id={$id}";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$r = $consult->fetch();
		$img = new Image();
		$img->setId($r->id);
		$img->setData($r->data);
		$img->setName($r->name);
		$img->setSize($r->size);
		$img->setType($r->type);
		$conection-> __destruct();
		return $img;
	}

	public function selectUserImage($id){
		$conection = new Conection("lib/mysql.ini");
		$sql = "SELECT * FROM image WHERE id_user={$id}";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$r = $consult->fetch();
		$img = new Image();
		$img->setId($r->id);
		$img->setData($r->data);
		$img->setName($r->name);
		$img->setSize($r->size);
		$img->setType($r->type);
		$conection-> __destruct();
		return $img;
	}

	public function insertImage($img){
		$conection = new Conection("lib/mysql.ini");
		if($img->getPostId()!=NULL){
			$refImg = ",mainImage,id_post";
			$refImg2 = ",{$img->getMainImage()},{$img->getPostId()}";
		}else{
			$refImg = ",id_user";
			$refImg2 = ",{$img->getUserId()}";
		}
		$sql = "INSERT INTO image (data,name,size,type {$refImg}) VALUES ('{$img->getData()}','{$img->getName()}',{$img->getSize()},'{$img->getType()}' {$refImg2})";
		$consult = $conection->getConection()->prepare($sql);
		$r = $consult->execute();
		$lastId = $conection->getConection()->lastInsertId();
		$conection-> __destruct();
		return $lastId;
	}

	public function editImage($img){
		$conection = new Conection("lib/mysql.ini");
		$sql = "UPDATE image SET data='{$img->getData()}',name='{$img->getName()}',size='{$img->getSize()}',type='{$img->getType()}' WHERE id_post={$img->getPostId()}";
		$consult = $conection->getConection()->prepare($sql);
		$r = $consult->execute();
		$conection-> __destruct();
		return $r;
	}

	public function removeImage($id){
		$conection = new Conection("lib/mysql.ini");
		$sql = "DELETE FROM image WHERE id_post={$id}";
		$consult = $conection->getConection()->prepare($sql);
		$r = $consult->execute();
		$conection-> __destruct();
		return $r;
	}

	public function removeTextImages($id){
		$conection = new Conection("lib/mysql.ini");
		$sql = "DELETE FROM image WHERE id_post={$id} AND mainImage=0";
		$consult = $conection->getConection()->prepare($sql);
		$r = $consult->execute();
		$conection-> __destruct();
		return $r;
	}
}
?>