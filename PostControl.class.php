<?php
require_once("Conection.class.php");
require_once("Post.class.php");
class PostControl {
	public function selectPost($id){
		$conection = new Conection("lib/mysql.ini");
		$sql = "SELECT id,title,subtitle,text,creationDate,editDate,removeDate,views,tags,featured,type,category,id_author FROM post WHERE id={$id}";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$r = $consult->fetch();
		$post = new Post();
		$post->setId($r->id);
		$post->setTitle($r->title);
		$post->setSubtitle($r->subtitle);
		$post->setText($r->text);
		$post->setCreationDateTime($r->creationDate);
		$post->setEditDateTime($r->editDate);
		$post->setRemoveDateTime($r->removeDate);
		$post->setViews($r->views);
		$post->setTags($r->tags);
		$post->setFeatured($r->featured);
		$post->setType($r->type);
		$post->setCategory($r->category);
		$post->setAuthor($r->id_author);
		$conection-> __destruct();
		return $post;
	}

	public function selectAllPosts(){
		$conection = new Conection("lib/mysql.ini");
		$sql = "SELECT id,title,subtitle,text,creationDate,editDate,removeDate,views,tags,featured,type,category,id_author FROM post ORDER BY CASE WHEN editDate IS NULL THEN creationDate ELSE editDate END DESC";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$res = $consult->fetchAll();
		$list = [];
		foreach ($res as $item) {
			$post = new Post();
			$post->setId($item->id);
			$post->setTitle($item->title);
			$post->setSubtitle($item->subtitle);
			$post->setText($item->text);
			$post->setCreationDateTime($item->creationDate);
			$post->setEditDateTime($item->editDate);
			$post->setRemoveDateTime($item->removeDate);
			$post->setViews($item->views);
			$post->setTags($item->tags);
			$post->setFeatured($item->featured);
			$post->setType($item->type);
			$post->setCategory($item->category);
			$post->setAuthor($item->id_author);
			array_push($list, $post);
		}
		$conection-> __destruct();
		return $list;
	}

	public function selectPostsByCategory($category){
		$conection = new Conection("lib/mysql.ini");
		$sql = "SELECT id,title,subtitle,text,creationDate,editDate,removeDate,views,tags,featured,type,category,id_author FROM post WHERE category='{$category}' ORDER BY CASE WHEN editDate IS NULL THEN creationDate ELSE editDate END DESC";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$res = $consult->fetchAll();
		$list = [];
		foreach ($res as $item) {
			$post = new Post();
			$post->setId($item->id);
			$post->setTitle($item->title);
			$post->setSubtitle($item->subtitle);
			$post->setText($item->text);
			$post->setCreationDateTime($item->creationDate);
			$post->setEditDateTime($item->editDate);
			$post->setRemoveDateTime($item->removeDate);
			$post->setViews($item->views);
			$post->setTags($item->tags);
			$post->setFeatured($item->featured);
			$post->setType($item->type);
			$post->setCategory($item->category);
			$post->setAuthor($item->id_author);
			array_push($list, $post);
		}
		$conection-> __destruct();
		return $list;
	}	

	public function selectAdminPosts($authorId){
		$conection = new Conection("lib/mysql.ini");
		$sql = "SELECT id,title,subtitle,text,creationDate,editDate,removeDate,views,tags,featured,type,category,id_author FROM post WHERE id_author={$authorId} ORDER BY CASE WHEN editDate IS NULL THEN creationDate ELSE editDate END DESC";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$res = $consult->fetchAll();
		$list = [];
		foreach ($res as $item) {
			$post = new Post();
			$post->setId($item->id);
			$post->setTitle($item->title);
			$post->setSubtitle($item->subtitle);
			$post->setText($item->text);
			$post->setCreationDateTime($item->creationDate);
			$post->setEditDateTime($item->editDate);
			$post->setRemoveDateTime($item->removeDate);
			$post->setViews($item->views);
			$post->setTags($item->tags);
			$post->setFeatured($item->featured);
			$post->setType($item->type);
			$post->setCategory($item->category);
			$post->setAuthor($item->id_author);
			array_push($list, $post);
		}
		$conection-> __destruct();
		return $list;
	}

	public function selectSearchPosts($tags,$only,$order){
		$conection = new Conection("lib/mysql.ini");
		$search = "";
		for($i=0;$i<count($tags);$i++) {
			if($i==0){
				$search = $search . "(";
			}
			if($i<(count($tags)-1)){
				$search = $search . "title LIKE '%{$tags[$i]}%' OR tags LIKE '%{$tags[$i]}%' OR ";	
			}else{
				$search = $search . "title LIKE '%{$tags[$i]}%' OR tags LIKE '%{$tags[$i]}%')";
			}
			
		}
		$sql = "SELECT id,title,subtitle,text,creationDate,editDate,removeDate,views,tags,featured,type,category,id_author FROM post WHERE {$search} {$only} ORDER BY {$order}";
		$consult = $conection->getConection()->prepare($sql);
		$consult->execute();
		$res = $consult->fetchAll();
		$list = [];
		foreach ($res as $item) {
			$post = new Post();
			$post->setId($item->id);
			$post->setTitle($item->title);
			$post->setSubtitle($item->subtitle);
			$post->setText($item->text);
			$post->setCreationDateTime($item->creationDate);
			$post->setEditDateTime($item->editDate);
			$post->setRemoveDateTime($item->removeDate);
			$post->setViews($item->views);
			$post->setTags($item->tags);
			$post->setFeatured($item->featured);
			$post->setType($item->type);
			$post->setCategory($item->category);
			$post->setAuthor($item->id_author);
			array_push($list, $post);
		}
		$conection-> __destruct();
		return $list;
	}	

	public function publishPost($post){
		$conection = new Conection("lib/mysql.ini");
		$publishDate = $post->getCreationDateTime()->format('Y-m-d H:i:s.floated');
		if($post->getRemoveDateTime()!=NULL){
			$dt = new DateTime($post->getRemoveDateTime());
			$removeDate = $dt->format('Y-m-d H:i:s.floated');
		}else{
			$removeDate = NULL;
		}
		$sql = "INSERT INTO post (title,subtitle,text,creationDate,removeDate,views,tags,featured,type,category,id_author) values ('{$post->getTitle()}','{$post->getSubtitle()}','{$post->getText()}','{$publishDate}','{$removeDate}',0,'{$post->getTags()}',{$post->getFeatured()},'{$post->getType()}','{$post->getCategory()}',{$post->getAuthor()})";
		$consult = $conection->getConection()->prepare($sql);
		$res = $consult->execute();
		$r = $conection->getConection()->lastInsertId();
		$conection-> __destruct();
		return $r;
	}

	public function editPost($post){
		$conection = new Conection("lib/mysql.ini");
		if($post->getCreationDateTime()!=NULL){
			$publishDate = ",creationDate='" . $post->getCreationDateTime()->format('Y-m-d H:i:s.floated') . "'";
		}else{
			$publishDate = "";
		}
		if($post->getEditDateTime()!=NULL){
			$editDate = ",editDate='" . $post->getEditDateTime()->format('Y-m-d H:i:s.floated') . "'";
 		}else{
 			$editDate = "";
 		}
		$removeDate = $post->getRemoveDateTime()->format('Y-m-d H:i:s.floated');
		$sql = "UPDATE post SET title='{$post->getTitle()}',subtitle='{$post->getSubtitle()}',text='{$post->getText()}' {$publishDate} {$editDate},removeDate='{$removeDate}',tags='{$post->getTags()}',featured={$post->getFeatured()},type='{$post->getType()}',category='{$post->getCategory()}' WHERE id={$post->getId()}";
		$consult = $conection->getConection()->prepare($sql);
		$res = $consult->execute();
		$conection-> __destruct();
	}

	public function removePost($id){
		$conection = new Conection("lib/mysql.ini");
		$sql = "DELETE FROM post WHERE id={$id}";
		$consult = $conection->getConection()->prepare($sql);
		$res = $consult->execute();
		$conection-> __destruct();
	}

	public function addView($id){
		$conection = new Conection("lib/mysql.ini");
		$sql = "UPDATE post SET views=views+1 WHERE id={$id} ";
		$consult = $conection->getConection()->prepare($sql);
		$res = $consult->execute();
		$conection-> __destruct();
	}

	public function addNewText($id,$text){
		$conection = new Conection("lib/mysql.ini");
		$sql = 'UPDATE post SET text="'.$text.'" WHERE id='.$id;
		$consult = $conection->getConection()->prepare($sql);
		$res = $consult->execute();
		$conection-> __destruct();
	}
}
?>