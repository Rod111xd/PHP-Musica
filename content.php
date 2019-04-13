<?php
	if(!isset($_GET['id'])){
		header("location:index.php");
	}
	session_start();
	if(isset($_SESSION['admin'])){
		$admin = true;
	}else{
		$admin = false;
	}
	if(isset($_SESSION['user'])){
		$user = true;
	}else{
		$user = false;
	}	
	date_default_timezone_set("America/Fortaleza");
	$actual = new DateTime();
	require_once("PostControl.class.php");
	require_once("ImageControl.class.php");
	require_once("UserControl.class.php");
	require_once("CommentControl.class.php");
	require_once("AdminControl.class.php");
	echo "
	<meta name='viewport' content='width=device-width, initial-scale=1'>

	<link rel='shortcut icon' type='image/png' href='imgs/icon.png'/>
	<link rel='stylesheet' href='sui/semantic.min.css' />
	<link rel='stylesheet' href='plugins/wowslider/style.css'/>
	<link rel='stylesheet' href='css/cardStyle2.css'/>
	<link rel='stylesheet' href='plugins/floatingButton/mfb.min.css'/>
	<link rel='stylesheet' href='css/css.css'/>

	";
	$id = $_GET['id'];
	$pC = new PostControl();
	$r = $pC->selectPost($id);
	if($r->getId()==NULL){
		header("location:index.php");
	}
	$dt = $r->getCreationDateTime();
	$creationDate = new DateTime($dt);	
	if($actual<$creationDate){
		header("location:myContent.php");
	}
	echo "<title>MN - {$r->getTitle()}</title>";
	if($admin){
		echo "
		<ul id='menu' class='mfb-component--br mfb-zoomin' data-mfb-toggle='hover'>
	      	";
	      	if($_SESSION['admin']==$r->getAuthor()){
		      	echo "
		      	<li class='mfb-component__wrap'>
		        	<a style='background-color:#1e1e1e;' href='editPost.php?id={$id}' data-mfb-label='Editar publicação' class='mfb-component__button--main'>
		          	<i style='text-align:center;margin-top:25%;' class='pencil alternate big icon'></i>
		        	</a>
		      	</li>
		      	";
	      	}
	      	echo "
		  	<li class='mfb-component__wrap'>
	        	<a style='background-color:#1e1e1e;' href='myContent.php' data-mfb-label='Minhas publicações' class='mfb-component__button--main'>
	          	<i style='text-align:center;margin-top:25%;' class='eye big icon'></i>
	        	</a>
	      	</li>
	      	<li class='mfb-component__wrap'>
	        	<a style='background-color:#1e1e1e;' href='editPost.php' data-mfb-label='Criar publicação' class='mfb-component__button--main'>
	          	<i style='text-align:center;margin-top:25%;' class='plus big icon'></i>
	        	</a>
	      	</li>
	    </ul>
	    ";
	}
    echo "

	<div class='mainIntro'><img src='imgs/logo.png'></div>
	<div id='sticky'>
		<div class='ui massive inverted stackable menu'>
			<a class='item' href='home.php'><i class='home icon'></i>Início</a>
			<div class='right menu'>";
			if($admin){
				$aC = new AdminControl();
				$nm = explode(" ",$aC->selectAdmin($_SESSION['admin'])->getName())[0];
			echo "
				<div class='ui dropdown item'>
					<i class='wrench icon'></i>Administrador
					<div style='z-index:1000;' class='menu'>
					<div class='header'>
						{$nm}
					</div>
					<div class='divider'></div>
						<a class='item' href='editPost.php'><i class='plus icon'></i>Criar</a>
						<a class='item' href='procertificate.php?id={$_SESSION['admin']}'><i class='cog icon'></i>Configurações</a>
					</div>
				</div>
				<a class='item' href='logoutProcess.php'><i class='sign out icon'></i>Sair</a>
				";	
			}elseif($user){
				$iC = new ImageControl();
				$uC = new UserControl();
				$nm = explode(" ",$uC->selectUser($_SESSION['user'])->getName())[0];

				echo "
				<a class='item' href='procertificate.php'><div class='ui mini circular image'><img src='image.php?imgId={$_SESSION['user']}&type=user'></div><span style='margin-left:6px;'>{$nm}</span></a>
				<a class='item' href='logoutProcess.php'><i class='sign out icon'></i>Sair</a>
				";
			}else{
				echo "
				<a class='item' href='userLoginRegister.php'><i class='user circle icon'></i>Entrar</a>
				<a class='item' href='adminLogin.php'><i class='wrench icon'></i></a>
				";
			}
			echo "		
			</div>
		</div>
	</div>
	
	";
	$pC = new PostControl();
	$rAll = $pC->selectAllPosts();
	$aC = new AdminControl();
	$iC = new ImageControl();
	
	if(count($rAll)!=0){
		echo "
		<div class='introArea'>
			<div class='slider'>
			<div id='wowslider-container1'>
			<div class='ws_images'>
	   			<ul>
		";
		foreach ($rAll as $post) {
			$dt = $post->getCreationDateTime();
			$creationDate = new DateTime($dt);	
			if($actual>=$creationDate){
				echo "<li><a href='content.php?id={$post->getId()}#main'><img id='imgSlider' style='width:1147px;height:500px;' src='image.php?imgId={$post->getId()}&type=post' title='{$post->getCategory()} | {$post->getTitle()}'/></a></li>";
			}
		}
		echo "
	        	</ul>
	    	</div>
		<div class='ws_bullets'><div>
	    	
		";
		foreach ($rAll as $post) {
			$dt = $post->getCreationDateTime();
			$creationDate = new DateTime($dt);	
			if($actual>=$creationDate){
				echo "<a href='#'></a>";
			}
		}
		echo "
	    	</div>
	    </div>
		<div class='ws_shadow'></div>
	    </div>

	    </div>
	    </div>
		";
	}
	echo "
	<div class='introMenu'>
	    <div class='ui fluid seven item big stackable inverted menu'>
			<a class='item' href='category.php?category=Sertanejo'>Sertanejo</a>
			<a class='item' href='category.php?category=Rock'>Rock</a>
			<a class='item' href='category.php?category=Pop'>Pop</a>
			<a class='item' href='category.php?category=Gospel'>Gospel</a>
			<a class='item' href='category.php?category=Mpb'>Mpb</a>
			<a class='item' href='category.php?category=Eletrônica'>Eletrônica</a>
			<a class='item' href='category.php?category=Reggae'>Reggae</a>
		</div>
	</div>

	<div id='main' class='mainContent'>
	<div id='gridContent' class='ui two column stackable divided grid'>
	<div id='leftContent' class='twelve wide column'>
	<div class='mainContentPadding'>
	<a class='ui secondary button' href='javascript:history.back()'><i class='arrow alternate circle left outline large icon'></i>Voltar</a><br><br>";
	
	$pC->addView($id);
	$aC = new AdminControl();
	$a = $aC->selectAdmin($r->getAuthor());
	$iC = new ImageControl();
	$img = $iC->selectPostImage($r->getId());
	$tags = "";
	if($r->getTags()!=NULL){
		$dTags = " " . $r->getTags();
		$tTags = preg_replace("/ /", " #", $dTags);
		$tags = substr($tTags,1);
	}
	$dt = (($r->getEditDateTime())!=NULL) ?$r->getEditDateTime() :$r->getCreationDateTime();
	$postDate = new DateTime($dt);
	$interval = $postDate->diff($actual);
	if($interval->h<1){
		$finalDate = "Há {$interval->i} minuto(s)";
	}elseif($interval->d<1){
		$finalDate = "Há {$interval->h} hora(s)";
	}elseif($interval->d<7){
		$finalDate = "Há {$interval->d} dia(s)";
	}else{
		$finalDate = "Há {$interval->w} semana(s)";
	}

	$type = $r->getType();
	$category = $r->getCategory();
	
    if($admin){
			if($_SESSION['admin']==$r->getAuthor()){
				echo "<span style='color:black'>Proprietário | <a href='editPost.php?id={$r->getId()}'><i class='edit large icon'></i> Editar</a><span style='color:red'><a href='deletePost.php?id={$r->getId()}'><i class='eraser large icon'></i> Apagar</a></span></span><br>";
			}
		}
	echo "
	<div class='contentHeader'>";
    if($r->getEditDateTime()!=NULL){
		echo "
			<span class='edited'>EDITADO</span><br>
		";
    }	
	echo "{$r->getTitle()}
	</div>
	<div class='contentSubtitle'>
		{$r->getSubtitle()}
	</div>
	<div class='contentImage'>
		<img src='image.php?imgId={$r->getId()}&type=post'>
	</div>
	<div class='contentMeta'>
		<i class='pencil alternate icon'></i> {$a->getName()}<br><i class='calendar alternate icon'></i>{$finalDate}<br><i class='eye icon'></i>{$r->getViews()} visualizações<br><i class='certificate icon'></i>{$type}<br><i class='thumbtack icon'></i>{$category}<br>";if($tags!=""){echo"<i class='tags icon'></i>{$tags}";};
	if($r->getEditDateTime()!=NULL){
    	echo "
    		<span class='edited'>EDITADO</span><br>
    	";
    }
	echo "<br><br>
	</div>
	<div class='contentText'>
		{$r->getText()}
	</div>
	<div id='postComments' class='ui threaded comments'>
  		<h3 class='ui dividing header'>Comentários</h3>
  		<div id='showComments'>
  		";
  		$cC = new CommentControl();
  		$c = $cC->selectComments();
  		$uC = new UserControl();
  		$i=0;
  		foreach ($c as $v) {
  			if($v->getPostId()==$_GET['id'] && $v->getCommentId()==NULL){
	  			$u = $uC->selectUser($v->getAuthor());
	  			$postDate = new DateTime($v->getDate());
				$interval = $postDate->diff($actual);
				if($interval->h<1){
					$finalDate = "Há {$interval->i} minuto(s)";
				}elseif($interval->d<1){
					$finalDate = "Há {$interval->h} hora(s)";
				}elseif($interval->d<7){
					$finalDate = "Há {$interval->d} dia(s)";
				}else{
					$finalDate = "Há {$interval->w} semana(s)";
				}
	  			echo "
				<div class='comment'>
		    		<a class='avatar'>
		      			<img src='image.php?imgId={$v->getAuthor()}&type=user'>
		    		</a>
		    		<div class='content'>
		      			<a class='author'>{$u->getName()}</a>
		      			<div class='metadata'>
		        			<span class='date'>{$finalDate} ";if($user){if($v->getAuthor()==$_SESSION['user']){echo "<a href='removeComment.php?id={$v->getId()}&postId={$_GET['id']}&onlyreplie=false'><i class='trash alternate icon'></i></a>";}}echo "</span>
		      			</div>
		      			<div class='text'>
		        			{$v->getText()}
		      			</div>";
		      			if(!$admin){
			      			echo"
			      			<div class='actions'>
			        			<a onclick='enableReply({$v->getId()})' class='reply'>Responder</a>
			      			</div>";
			      			
			      			if($user){
			      				echo "
								<form id='{$v->getId()}' style='display:none;' class='ui reply form' action='createComment.php?type=reply' method='post'>
							    	<div class='field'>
							      		<textarea name='text' maxlength='200' required></textarea>
							    	</div>
							    	<button type='submit' class='ui secondary labeled submit icon button'>
							      		<i class='icon edit'></i> Responder
							    	</button>
							    	<input type='hidden' name='postId' value='{$_GET['id']}'>
							    	<input type='hidden' name='commentId' value='{$v->getId()}'>
							  	</form>
			      				";
			      			}
			      			
		      			}
		      			echo "
		    		</div>
		    		";
		    	$cR = $cC->selectReplies($v->getId());	
		    	if(count($cR)!=0){
		    		foreach ($cR as $v2) {
		    			$u2 = $uC->selectUser($v2->getAuthor());
			  			$postDate2 = new DateTime($v2->getDate());
						$interval2 = $postDate2->diff($actual);
						if($interval2->h<1){
							$finalDate2 = "Há {$interval2->i} minuto(s)";
						}elseif($interval2->d<1){
							$finalDate2 = "Há {$interval2->h} hora(s)";
						}elseif($interval2->d<7){
							$finalDate2 = "Há {$interval2->d} dia(s)";
						}
		    		echo "
		    		<div  class='comments'>
						<div class='comment'>
				    		<a class='avatar'>
				      			<img src='image.php?imgId={$v2->getAuthor()}&type=user'>
				    		</a>
				    		<div class='content'>
				      			<a class='author'>{$u2->getName()}</a>
				      			<div class='metadata'>
				        			<span class='date'>{$finalDate2} ";if($user){if($v->getAuthor()==$_SESSION['user']){echo "<a href='removeComment.php?id={$v2->getId()}&postId={$_GET['id']}&onlyreplie=true'><i class='trash alternate icon'></i></a>";}}echo "</span>
				      			</div>
				      			<div class='text'>
				        			{$v2->getText()}
				      			</div>

				      		</div>
				      	</div>
				    </div>
		    		";
		    		}
		    	}
		    	echo "
		  		</div>
	  			";
	  			$i++;
	  		}
  		}
  		if($i==0){
  			echo "<h4>Esta publicação não têm comentários</h4>";
  			if(!$admin){
  				echo "Seja o primeiro a comentar.";
  			}
  		}
  		echo "
  		</div>
	  	<form ";if($admin){echo"style='display:none;'";}echo " class='ui reply form' action='createComment.php?type=none' method='post'>
	    	<div class='field'>
	      		<textarea"; if(!$user){echo" id='comments'";}echo " name='text' maxlength='200' required ";if(!$user){echo "readonly";}echo"></textarea>
	    	</div>
	    	<button type='submit' class='ui secondary labeled submit icon";if(!$user){echo " disabled";}echo" button'>
	      		<i class='icon edit'></i> Publicar
	    	</button>
	    	<input type='hidden' name='postId' value='{$_GET['id']}'> 
	  	</form>
	</div>
	";

	echo "	
		</div>
		</div>
			<div id='rightContent' class='four wide column'>
			<div class='linearRight'><h2>Pesquisar</h2></div>
			<div class='ui search'>
			  	<div class='ui icon input'>
			    	<input id='searchField' class='prompt' type='text' placeholder='Pesquisar...'>
			    	<div id='searchButton'><i class='search large icon'></i></div>
			  	</div>
			  	<div class='results'></div>
			</div>";
			require_once("contentBar.php");			
			echo "
		</div>
	</div>
		<div id='footer' class='ui vertical footer segment'>
		    <div class='ui center aligned container'>
		        <div class='ui fluid three column stackable divided grid'>
		        	<div class='column'>
		        		<h4 class='ui header'>Acesse nossas redes sociais</h4>
		        		<span style='color:blue'><i class='facebook big icon'></i></span>
		        		<span style='color:lightblue'><i class='twitter big icon'></i></span>
		        		<span style='color:purple'><i class='instagram big icon'></i></span>
		        		<span style='color:red'><i class='youtube big icon'></i></span>
		        	</div>
		        	<div class='column'>
		        		<h4 class='ui header'>Sobre</h4>
		        		<p>
		        			Este site foi desenvolvido por Rodrigo, como um projeto de trabalho. O conteúdo do site é sobre música, envolvendo notícias, curiosidades, dicas e enquetes que possam te interessar.
		        		</p>		        	
		        	</div>
		        	<div class='column'>
		        		<h4 class='ui header'>Direitos Autorais</h4>
		        		<p>
		        			Nem todos os direitos estão reservados.
		        		</p>
		        	</div>
		        </div>
		    </div>
		</div>
		<div class='ui tiny inverted modal' id='errorNoLogin'>
			<div class='ui icon header'>
		    	<i class='thumbs down icon'></i>
				Você precisa estar logado!		    	
		  	</div>
		  	<div class='content'>
		    	<p>Para comentar você precisará de realizar login! Se ainda não possuir um cadastro, o faça.</p>
		  	</div>
		  	<div class='actions'>
		  		<a class='ui primary button' href='userLoginRegister.php'>Entrar</a>
		  		<a class='ui primary button' href='userLoginRegister.php'>Cadastrar</a>
		    	<a class='ui ok button'>Cancelar</a>
	  		</div>
		</div>
	</div>
	<script src='js/jquery.js'></script>
	<script src='sui/semantic.min.js'></script>
	<script src='plugins/wowslider/wowslider.js'></script>
	<script src='plugins/wowslider/script.js'></script>
	<script src='plugins/floatingButton/mfb.min.js'></script>
	<script>
		$('.ui.dropdown')
		  .dropdown()
		;
	</script>
	<script>
        $('#wowslider-container').wowSlider({effect:'rotate',prev:'',next:'',duration:30*100,delay:50*100,width:580,height:212,autoPlay:true,stopOnHover:false,loop:false,bullets:true,caption:true,captionEffect:'slide',controls:true,logo:'',images:0});
    </script>
   	<script type='text/javascript'>
		$('#searchButton').click(function(){
			if($('#searchField').val()!=''){
				location.href= 'search.php?name='+$('#searchField').val()+'&category=Todos&type=Todos&classification=recents';
			}
		});
		$('#searchField').keyup(function(e){
			if((e.keyCode==13) && ($('#searchField').val()!='')){
				location.href= 'search.php?name='+$('#searchField').val()+'&category=Todos&type=Todos&classification=recents';
			}
		});
	</script>
	<script>
		$('#sticky')
		  .sticky({
		  	context: '.stickyContent'
		  })
		;
	</script>
	<script>
		$('#comments').click(function(){
			$('#errorNoLogin').modal('setting', 'closable', false).modal('show');
		});
	
		function enableReply(id){
			$('body').click(function(e){
				var target = $(e.target);
				if(!(target.is('.reply') || target.is('textarea') || target.is('button'))){
					$('#'+id).css('display','none');
				}
			});			
			$('#'+id).css('display','inline');
			$('#'+id).focus();
		}
	</script>
	<script>
		if (window.matchMedia('(min-width: 768px)').matches){
			$('#sticky')
			  .visibility({
			    type   : 'fixed',
			    offset : 0 // give some space from top of screen
			  })
			;
		}
	</script>
	";
	if(!$user){
		echo "
			<script>
			$('.comment').click(function(){
				$('#errorNoLogin').modal('setting', 'closable', false).modal('show');
			});
			</script>
		";
	}

?>