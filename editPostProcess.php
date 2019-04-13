<?php
	session_start();
	if((!isset($_SESSION['admin'])) || (!isset($_COOKIE['id']))){
		header("location:index.php");
	}
	date_default_timezone_set("America/Fortaleza");
	$dt = new DateTime();
	$actual = $dt;
	$title = addslashes(ucfirst(mb_strtolower($_POST['title'],'UTF-8')));
	$subtitle = addslashes($_POST['subtitle']);
	$text = str_replace("<p></p>", "", strip_tags($_POST['text'], '<p></p>'));
	$tags = (isset($_POST['tags'])) ?(substr(str_replace("value", " ", str_replace(str_split('[{":,}]'),'',$_POST['tags'])),1)) :NULL;
	$featured = (isset($_POST['urgent'])) ?1 :0;
	$type = $_POST['type'];
	$category = $_POST['category'];
	$publishDate = (isset($_POST['public']) && $_POST['public']!="now") ?new DateTime($_POST['publishDate']) :$actual;
	$removeDate = new DateTime($_POST['removeDate']);
	$img = $_FILES['img'];

	

	if($img['size']!=0){
		$imgContent = addslashes(file_get_contents($img['tmp_name']));
	}
	require_once("Post.class.php");
	require_once("Image.class.php");
	require_once("Video.class.php");
	require_once("PostControl.class.php");
	require_once("ImageControl.class.php");
	require_once("VideoControl.class.php");

	$p = new Post();
	$pC = new PostControl();
	$p->setId($_COOKIE['id']);
	$p->setTitle($title);
	$p->setSubtitle($subtitle);
	$p->setText($text);
	$p->setTags($tags);
	$p->setFeatured($featured);
	$p->setType($type);
	$p->setCategory($category);
	if(isset($_POST['alreadyPublished'])){
		$p->setEditDateTime($actual);
	}else{
		$p->setCreationDateTime($publishDate);
	}
	$p->setRemoveDateTime($removeDate);
	$pC->editPost($p);

	$i = new Image();
	$iC = new ImageControl();

	$iC->removeTextImages($_COOKIE['id']);

	if($img['size']!=0) {	
		$i->setData($imgContent);
		$i->setName($img['name']);
		$i->setSize($img['size']);
		$i->setType($img['type']);
		$i->setPostId($_COOKIE['id']);
		$iC->editImage($i);
	}


	if(isset($_FILES['media'])){
		$text = explode("</p>", $text);
		$i2 = new Image();
		$i2C = new ImageControl();
		$v = new Video();
		$vC = new VideoControl();
		for($i=0;$i<count($_FILES['media']['name']);$i++) {
			$mType = explode("/", $_FILES['media']['type'][$i])[0];
			$p = ($_POST['paragraph'][$i])-1;
			$text[$p] = $text[$p] . "</p>";
			if($mType=="image"){				
				$imgContent2 = addslashes(file_get_contents($_FILES['media']['tmp_name'][$i]));
				$i2->setData($imgContent2);
				$i2->setName($_FILES['media']['name'][$i]);
				$i2->setSize($_FILES['media']['size'][$i]);
				$i2->setType($_FILES['media']['type'][$i]);
				$i2->setMainImage(0);
				$i2->setPostId($_COOKIE['id']);
				$iId = $i2C->insertImage($i2);
				$text[$p] = "{$text[$p]}<img style='width:450px;height:300px;' src='image.php?imgId={$iId}&type=textPost'>";
			}elseif($mType=="video"){
				$vidContent = addslashes(file_get_contents($_FILES['media']['tmp_name'][$i]));
				$v->setData($vidContent);
				$v->setName($_FILES['media']['name'][$i]);
				$v->setSize($_FILES['media']['size'][$i]);
				$v->setType($_FILES['media']['type'][$i]);
				$v->setPostId($_COOKIE['id']);
				$vId = $vC->insertVideo($v);
				$text[$p] = "{$text[$p]}<video width='450' height='300'><source src='video.php?vidId={$vId}' type='video/mp4'></video>";
			}
				
		}
		$finalText = str_replace('"','\'',implode($text));
		$pC->addNewText($_COOKIE['id'],$finalText);
	}



	$_COOKIE['id'] = NULL;
	setcookie("id",NULL,time()-7200);

	header("location:index.php");
?>	