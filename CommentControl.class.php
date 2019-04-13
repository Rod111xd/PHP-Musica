<?php
require_once("Conection.class.php");
require_once("Comment.class.php");
class CommentControl {
	public function selectReplies($id){
		$conection = new Conection("lib/mysql.ini");
		$sql = "SELECT * FROM comment WHERE id_comment={$id} ORDER BY date ASC";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$r = $consult->fetchAll();
		$list = [];
		foreach ($r as $c) {
			$com = new Comment();
			$com->setId($c->id);
			$com->setText($c->text);
			$com->setDate($c->date);
			$com->setPostId($c->id_post);
			$com->setAuthor($c->id_author);
			$com->setCommentId($c->id_comment);
			array_push($list, $com);
		}
		$conection-> __destruct();
		return $list;
	}

	public function selectComments(){
		$conection = new Conection("lib/mysql.ini");
		$sql = "SELECT * FROM comment ORDER BY date DESC";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$r = $consult->fetchAll();
		$list = [];
		foreach ($r as $c) {
			$com = new Comment();
			$com->setId($c->id);
			$com->setText($c->text);
			$com->setDate($c->date);
			$com->setPostId($c->id_post);
			$com->setAuthor($c->id_author);
			$com->setCommentId($c->id_comment);
			array_push($list, $com);
		}
		$conection-> __destruct();
		return $list;
	}

	public function insertComment($com){
		$conection = new Conection("lib/mysql.ini");
		if($com->getCommentId()!=NULL){
			$refCom = ",id_comment";
			$refCom2 = ",{$com->getCommentId()}";
		}else{
			$refCom = "";
			$refCom2 = "";
		}
		$date = $com->getDate()->format('Y-m-d H:i:s.floated');
		$sql = "INSERT INTO comment (text,date,id_post,id_author {$refCom}) values ('{$com->getText()}','{$date}',{$com->getPostId()},{$com->getAuthor()} {$refCom2})";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$conection-> __destruct();
		return $consult;
	}

	public function removeReplie($id){
		$conection = new Conection("lib/mysql.ini");
		$sql = "DELETE FROM comment WHERE id={$id}";
		$consult = $conection->getConection()->prepare($sql);
		$r = $consult->execute();
		$conection-> __destruct();
		return $r;
	}

	public function removeComment($id){
		$conection = new Conection("lib/mysql.ini");
		$sql = "DELETE FROM comment WHERE id_comment={$id};DELETE FROM comment WHERE id={$id}";
		$consult = $conection->getConection()->prepare($sql);
		$r = $consult->execute();
		$conection-> __destruct();
		return $r;
	}

	public function removePostComments($id){
		$conection = new Conection("lib/mysql.ini");
		$sql = "DELETE FROM comment WHERE id_post={$id} AND id_comment IS NOT NULL;DELETE FROM comment WHERE id_post={$id} AND id_comment IS NULL";
		$consult = $conection->getConection()->prepare($sql);
		$r = $consult->execute();
		$conection-> __destruct();
		return $r;
	}
}
?>