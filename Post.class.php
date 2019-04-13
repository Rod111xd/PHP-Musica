<?php
class Post {
	private $id;
	private $title;
	private $subtitle;
	private $text;
	private $creationDateTime;
	private $editDateTime;
	private $removeDateTime;
	private $views;
	private $tags;
	private $featured;
	private $type;
	private $category;
	private $author;
	
	public function getId(){
		return $this->id;
	}
	public function setId($i){
		$this->id = $i;
	}
	public function getTitle(){
		return $this->title;
	}
	public function setTitle($t){
		$this->title = $t;
	}
	public function getSubtitle(){
		return $this->subtitle;
	}
	public function setSubtitle($s){
		$this->subtitle = $s;
	}
	public function getText(){
		return $this->text;
	}
	public function setText($t){
		$this->text = $t;
	}
	public function getCreationDateTime(){
		return $this->creationDateTime;
	}
	public function setCreationDateTime($d){
		$this->creationDateTime = $d;
	}
	public function getEditDateTime(){
		return $this->editDateTime;
	}
	public function setEditDateTime($e){
		$this->editDateTime = $e;
	}	
	public function getRemoveDateTime(){
		return $this->removeDateTime;
	}
	public function setRemoveDateTime($r){
		$this->removeDateTime = $r;
	}	
	public function getViews(){
		return $this->views;
	}
	public function setViews($v){
		$this->views = $v;
	}		
	public function getTags(){
		return $this->tags;
	}
	public function setTags($t){
		$this->tags = $t;
	}
	public function getFeatured(){
		return $this->featured;
	}
	public function setFeatured($f){
		$this->featured = $f;
	}	
	public function getType(){
		return $this->type;
	}
	public function setType($t){
		$this->type = $t;
	}
	public function getCategory(){
		return $this->category;
	}
	public function setCategory($c){
		$this->category = $c;
	}		
	public function getAuthor(){
		return $this->author;
	}
	public function setAuthor($a){
		$this->author = $a;
	}


}
?>