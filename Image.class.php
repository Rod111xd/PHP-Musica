<?php
class Image {
	private $id;
	private $description;
	private $data;
	private $name;
	private $size;
	private $type;
	private $mainImage;
	private $postId;
	private $userId;
	public function getId(){
		return $this->id;
	}
	public function setId($i){
		$this->id = $i;
	}
	public function getDescription(){
		return $this->description;
	}
	public function setDescription($d){
		$this->description = $d;
	}
	public function getData(){
		return $this->data;
	}
	public function setData($d){
		$this->data = $d;
	}
	public function getName(){
		return $this->name;
	}
	public function setName($n){
		$this->name = $n;
	}
	public function getSize(){
		return $this->size;
	}
	public function setSize($s){
		$this->size = $s;
	}
	public function getType(){
		return $this->type;
	}
	public function setType($t){
		$this->type = $t;
	}
	public function getMainImage(){
		return $this->mainImage;
	}
	public function setMainImage($m){
		$this->mainImage = $m;
	}	
	public function getPostId(){
		return $this->postId;
	}
	public function setPostId($p){
		$this->postId = $p;
	}	
	public function getUserId(){
		return $this->userId;
	}
	public function setUserId($u){
		$this->userId = $u;
	}

}
?>