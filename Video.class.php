<?php
class Video {
	private $id;
	private $data;
	private $name;
	private $size;
	private $type;
	private $postId;

	public function getId(){
		return $this->id;
	}
	public function setId($i){
		$this->id = $i;
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
	public function getPostId(){
		return $this->postId;
	}
	public function setPostId($p){
		$this->postId = $p;
	}	

}
?>