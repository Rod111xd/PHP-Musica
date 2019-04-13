<?php

	$sertanejo = [];
	$rock = [];
	$pop = [];
	$gospel = [];
	$mpb = [];
	$eletronica = [];
	$reggae = [];
	foreach ($rAll as $c) {
		switch ($c->getCategory()) {
			case "Sertanejo":
				if(count($sertanejo)<3){
					$dt = $c->getCreationDateTime();
					$creationDate = new DateTime($dt);	
					if($actual>=$creationDate){
						array_push($sertanejo,$c);	
					}
				}
				break;
			case "Rock":
				if(count($rock)<3){
					$dt = $c->getCreationDateTime();
					$creationDate = new DateTime($dt);	
					if($actual>=$creationDate){
						array_push($rock,$c);	
					}
				}
				break;
			case "Pop":
				if(count($pop)<3){
					$dt = $c->getCreationDateTime();
					$creationDate = new DateTime($dt);	
					if($actual>=$creationDate){
						array_push($pop,$c);	
					}
				}
				break;
			case "Gospel":
				if(count($gospel)<3){
					$dt = $c->getCreationDateTime();
					$creationDate = new DateTime($dt);	
					if($actual>=$creationDate){
						array_push($gospel,$c);	
					}
				}
				break;
			case "Mpb":
				if(count($mpb)<3){
					$dt = $c->getCreationDateTime();
					$creationDate = new DateTime($dt);	
					if($actual>=$creationDate){
						array_push($mpb,$c);	
					}
				}
				break;
			case "Eletronica":
				if(count($eletronica)<3){
					$dt = $c->getCreationDateTime();
					$creationDate = new DateTime($dt);	
					if($actual>=$creationDate){
						array_push($eletronica,$c);	
					}
				}
				break;
			case "Reggae":
				if(count($reggae)<3){
					$dt = $c->getCreationDateTime();
					$creationDate = new DateTime($dt);	
					if($actual>=$creationDate){
						array_push($reggae,$c);	
					}
				}
				break;
			default:
				
		}
	}
	
	if(count($sertanejo)>0){
		echo "<a href='category.php?category=Sertanejo'><div class='linearRight'><h2>Sertanejo</h2></div></a>";
		foreach ($sertanejo as $post) {
			$dt = $post->getCreationDateTime();
			$creationDate = new DateTime($dt);	
			if($actual>=$creationDate){
				$a = $aC->selectAdmin($post->getAuthor());
				$dt = (($post->getEditDateTime())!=NULL) ?$post->getEditDateTime() :$post->getCreationDateTime();
				$postDate = new DateTime($dt);
				$interval = $postDate->diff($actual);
				if($interval->h<1){
					$finalDate = "Há {$interval->i} minuto(s)";
				}elseif($interval->d<1){
					$finalDate = "Há {$interval->h} hora(s)";
				}elseif($interval->d<7){
					$finalDate = "Há {$interval->d} dia(s)";
				}			
				echo "
				<div class='blog-card'>
				    <div class='meta'>
				      <a href='content.php?id={$post->getId()}'><div class='photo' style='background-image: url(image.php?imgId={$post->getId()}&type=post);background-size:cover'></div></a>
				    </div>
				    <div class='description2'>
				      <div class='headerCard'><a href='content.php?id={$post->getId()}'>{$post->getTitle()}</a></div>
				      <div style='margin:0' class='ui divider'></div>
				    </div>
				</div>
				";			
			}
		}
	}
	if(count($rock)>0){
		echo "<a href='category.php?category=Rock'><div class='linearRight'><h2>Rock</h2></div></a>";
		foreach ($rock as $post) {
			$dt = $post->getCreationDateTime();
			$creationDate = new DateTime($dt);	
			if($actual>=$creationDate){
				$a = $aC->selectAdmin($post->getAuthor());
				$dt = (($post->getEditDateTime())!=NULL) ?$post->getEditDateTime() :$post->getCreationDateTime();
				$postDate = new DateTime($dt);
				$interval = $postDate->diff($actual);
				if($interval->h<1){
					$finalDate = "Há {$interval->i} minuto(s)";
				}elseif($interval->d<1){
					$finalDate = "Há {$interval->h} hora(s)";
				}elseif($interval->d<7){
					$finalDate = "Há {$interval->d} dia(s)";
				}			
				echo "
				<div class='blog-card'>
				    <div class='meta'>
				      <a href='content.php?id={$post->getId()}'><div class='photo' style='background-image: url(image.php?imgId={$post->getId()}&type=post);background-size:cover'></div></a>
				    </div>
				    <div class='description2'>
				      <div class='headerCard'><a href='content.php?id={$post->getId()}'>{$post->getTitle()}</a></div>
				      <div style='margin:0' class='ui divider'></div>
				    </div>
				</div>
				";			
			}
		}
	}
	if(count($pop)>0){
		echo "<a href='category.php?category=Pop'><div class='linearRight'><h2>Pop</h2></div></a>";
		foreach ($pop as $post) {
			$dt = $post->getCreationDateTime();
			$creationDate = new DateTime($dt);	
			if($actual>=$creationDate){
				$a = $aC->selectAdmin($post->getAuthor());
				$dt = (($post->getEditDateTime())!=NULL) ?$post->getEditDateTime() :$post->getCreationDateTime();
				$postDate = new DateTime($dt);
				$interval = $postDate->diff($actual);
				if($interval->h<1){
					$finalDate = "Há {$interval->i} minuto(s)";
				}elseif($interval->d<1){
					$finalDate = "Há {$interval->h} hora(s)";
				}elseif($interval->d<7){
					$finalDate = "Há {$interval->d} dia(s)";
				}			
				echo "
				<div class='blog-card'>
				    <div class='meta'>
				      <a href='content.php?id={$post->getId()}'><div class='photo' style='background-image: url(image.php?imgId={$post->getId()}&type=post);background-size:cover'></div></a>
				    </div>
				    <div class='description2'>
				      <div class='headerCard'><a href='content.php?id={$post->getId()}'>{$post->getTitle()}</a></div>
				      <div style='margin:0' class='ui divider'></div>
				    </div>
				</div>
				";			
			}
		}
	}
	if(count($gospel)>0){
		echo "<a href='category.php?category=Gospel'><div class='linearRight'><h2>Gospel</h2></div></a>";
		foreach ($gospel as $post) {
			$dt = $post->getCreationDateTime();
			$creationDate = new DateTime($dt);	
			if($actual>=$creationDate){
				$a = $aC->selectAdmin($post->getAuthor());
				$dt = (($post->getEditDateTime())!=NULL) ?$post->getEditDateTime() :$post->getCreationDateTime();
				$postDate = new DateTime($dt);
				$interval = $postDate->diff($actual);
				if($interval->h<1){
					$finalDate = "Há {$interval->i} minuto(s)";
				}elseif($interval->d<1){
					$finalDate = "Há {$interval->h} hora(s)";
				}elseif($interval->d<7){
					$finalDate = "Há {$interval->d} dia(s)";
				}			
				echo "
				<div class='blog-card'>
				    <div class='meta'>
				      <a href='content.php?id={$post->getId()}'><div class='photo' style='background-image: url(image.php?imgId={$post->getId()}&type=post);background-size:cover'></div></a>
				    </div>
				    <div class='description2'>
				      <div class='headerCard'><a href='content.php?id={$post->getId()}'>{$post->getTitle()}</a></div>
				      <div style='margin:0' class='ui divider'></div>
				    </div>
				</div>
				";			
			}
		}
	}
	if(count($mpb)>0){
		echo "<a href='category.php?category=Mpb'><div class='linearRight'><h2>Mpb</h2></div></a>";
		foreach ($mpb as $post) {
			$dt = $post->getCreationDateTime();
			$creationDate = new DateTime($dt);	
			if($actual>=$creationDate){
				$a = $aC->selectAdmin($post->getAuthor());
				$dt = (($post->getEditDateTime())!=NULL) ?$post->getEditDateTime() :$post->getCreationDateTime();
				$postDate = new DateTime($dt);
				$interval = $postDate->diff($actual);
				if($interval->h<1){
					$finalDate = "Há {$interval->i} minuto(s)";
				}elseif($interval->d<1){
					$finalDate = "Há {$interval->h} hora(s)";
				}elseif($interval->d<7){
					$finalDate = "Há {$interval->d} dia(s)";
				}			
				echo "
				<div class='blog-card'>
				    <div class='meta'>
				      <a href='content.php?id={$post->getId()}'><div class='photo' style='background-image: url(image.php?imgId={$post->getId()}&type=post);background-size:cover'></div></a>
				    </div>
				    <div class='description2'>
				      <div class='headerCard'><a href='content.php?id={$post->getId()}'>{$post->getTitle()}</a></div>
				      <div style='margin:0' class='ui divider'></div>
				    </div>
				</div>
				";			
			}
		}
	}
	if(count($eletronica)>0){
		echo "<a href='category.php?category=Eletrônica'><div class='linearRight'><h2>Eletrônica</h2></div></a>";
		foreach ($eletronica as $post) {
			$dt = $post->getCreationDateTime();
			$creationDate = new DateTime($dt);	
			if($actual>=$creationDate){
				$a = $aC->selectAdmin($post->getAuthor());
				$dt = (($post->getEditDateTime())!=NULL) ?$post->getEditDateTime() :$post->getCreationDateTime();
				$postDate = new DateTime($dt);
				$interval = $postDate->diff($actual);
				if($interval->h<1){
					$finalDate = "Há {$interval->i} minuto(s)";
				}elseif($interval->d<1){
					$finalDate = "Há {$interval->h} hora(s)";
				}elseif($interval->d<7){
					$finalDate = "Há {$interval->d} dia(s)";
				}			
				echo "
				<div class='blog-card'>
				    <div class='meta'>
				      <a href='content.php?id={$post->getId()}'><div class='photo' style='background-image: url(image.php?imgId={$post->getId()}&type=post);background-size:cover'></div></a>
				    </div>
				    <div class='description2'>
				      <div class='headerCard'><a href='content.php?id={$post->getId()}'>{$post->getTitle()}</a></div>
				      <div style='margin:0' class='ui divider'></div>
				    </div>
				</div>
				";			
			}
		}
	}
	if(count($reggae)>0){
		echo "<a href='category.php?category=Reggae'><div class='linearRight'><h2>Reggae</h2></div></a>";
		foreach ($reggae as $post) {
			$dt = $post->getCreationDateTime();
			$creationDate = new DateTime($dt);	
			if($actual>=$creationDate){
				$a = $aC->selectAdmin($post->getAuthor());
				$dt = (($post->getEditDateTime())!=NULL) ?$post->getEditDateTime() :$post->getCreationDateTime();
				$postDate = new DateTime($dt);
				$interval = $postDate->diff($actual);
				if($interval->h<1){
					$finalDate = "Há {$interval->i} minuto(s)";
				}elseif($interval->d<1){
					$finalDate = "Há {$interval->h} hora(s)";
				}elseif($interval->d<7){
					$finalDate = "Há {$interval->d} dia(s)";
				}			
				echo "
				<div class='blog-card'>
				    <div class='meta'>
				      <a href='content.php?id={$post->getId()}'><div class='photo' style='background-image: url(image.php?imgId={$post->getId()}&type=post);background-size:cover'></div></a>
				    </div>
				    <div class='description2'>
				      <div class='headerCard'><a href='content.php?id={$post->getId()}'>{$post->getTitle()}</a></div>
				      <div style='margin:0' class='ui divider'></div>
				    </div>
				</div>
				";			
			}
		}
	}			

?>