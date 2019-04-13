<?php
class Comment {
	private $id;
	private $text;
	private $date;
	private $id_post;
	private $id_author;
	private $id_comment;
	
	public function getId(){
		return $this->id;
	}
	public function setId($i){
		$this->id = $i;
	}
	public function getText(){
		return $this->text;
	}
	public function setText($t){
		$this->text = $t;
	}
	public function getDate(){
		return $this->date;
	}
	public function setDate($d){
		$this->date = $d;
	}	
	public function getPostId(){
		return $this->id_post;
	}
	public function setPostId($p){
		$this->id_post = $p;
	}
	public function getAuthor(){
		return $this->id_author;
	}
	public function setAuthor($a){
		$this->id_author = $a;
	}	
	public function getCommentId(){
		return $this->id_comment;
	}
	public function setCommentId($c){
		$this->id_comment = $c;
	}	
}
?>