<?php
	session_start();
	if(!isset($_SESSION['admin'])){
		header("location:index.php");
	}
	date_default_timezone_set("America/Fortaleza");
	$title = addslashes(ucfirst(mb_strtolower($_POST['title'],'UTF-8')));
	$subtitle = addslashes($_POST['subtitle']);
	$text = $_POST['text'];
	$tags = (isset($_POST['tags'])) ?(substr(str_replace("value", " ", str_replace(str_split('[{":,}]'),'',$_POST['tags'])),1)) :NULL;
	$featured = (isset($_POST['urgent'])) ?1 :0;
	$type = $_POST['type'];
	$category = $_POST['category'];
	$publishDate = ($_POST['public']!="now") ?new DateTime($_POST['publishDate']) :new DateTime() ;
	$removeDate = (isset($_POST['removeDate'])) ?$_POST['removeDate'] :NULL ;
	$img = $_FILES['img'];

	$imgContent = addslashes(file_get_contents($img['tmp_name']));
	require_once("Post.class.php");
	require_once("Image.class.php");
	require_once("Video.class.php");
	require_once("PostControl.class.php");
	require_once("ImageControl.class.php");
	require_once("VideoControl.class.php");

	$p = new Post();
	$pC = new PostControl();
	$p->setTitle($title);
	$p->setSubtitle($subtitle);
	$p->setText($text);
	$p->setAuthor($_SESSION['admin']);
	$p->setCreationDateTime($publishDate);
	$p->setRemoveDateTime($removeDate);
	$p->setTags($tags);
	$p->setFeatured($featured);

	$p->setType($type);
	$p->setCategory($category);
	$r = $pC->publishPost($p);
	
	$i = new Image();
	$iC = new ImageControl();
	$i->setData($imgContent);
	$i->setName($img['name']);
	$i->setSize($img['size']);
	$i->setType($img['type']);
	$i->setMainImage(1);
	$i->setPostId($r);
	$iC->insertImage($i);

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
				$i2->setPostId($r);
				$iId = $i2C->insertImage($i2);
				$text[$p] = "{$text[$p]}<img style='width:450px;height:300px;' src='image.php?imgId={$iId}&type=textPost'>";
			}elseif($mType=="video"){
				$vidContent = addslashes(file_get_contents($_FILES['media']['tmp_name'][$i]));
				$v->setData($vidContent);
				$v->setName($_FILES['media']['name'][$i]);
				$v->setSize($_FILES['media']['size'][$i]);
				$v->setType($_FILES['media']['type'][$i]);
				$v->setPostId($r);
				$vId = $vC->insertVideo($v);
				$text[$p] = "{$text[$p]}<video width='450' height='300' controls><source src='video.php?vidId={$vId}' type='video/mp4'></video>";
			}
				
		}
		$finalText = str_replace('"','\'',implode($text));
		$pC->addNewText($r,$finalText);
	}
	
	header("location:index.php");
	
?>