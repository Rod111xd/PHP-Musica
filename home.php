<?php

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
	require_once("UserControl.class.php");
	require_once("ImageControl.class.php");
	require_once("AdminControl.class.php");
	echo "
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>MN - Início</title>
	<link rel='shortcut icon' type='image/png' href='imgs/icon.png'/>
	<link rel='stylesheet' href='sui/semantic.min.css' />
	<link rel='stylesheet' href='plugins/wowslider/style.css'/>
	<link rel='stylesheet' href='css/cardStyle2.css'/>
	<link rel='stylesheet' href='plugins/floatingButton/mfb.min.css'/>
	<link rel='stylesheet' href='css/css.css'/>
	";

	if($admin){
		echo "
		<ul id='menu' class='mfb-component--br mfb-zoomin' data-mfb-toggle='hover'>
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
		<div id='mainMenu' class='ui massive inverted stackable menu'>
			<a class='item' href='home.php'><i class='home icon'></i>Início</a>
			<div class='right menu'>";
			if($admin){
				$aC = new AdminControl();
				$nm = explode(" ",$aC->selectAdmin($_SESSION['admin'])->getName())[0];
			echo "
				<div class='ui dropdown item'>
					<i class='wrench icon'></i>Administrador
					<div style='z-index:100;' class='menu'>
					<div class='header'>
						{$nm}
					</div>
					<div class='divider'></div>
						<a class='item' href='editPost.php'><i class='plus icon'></i>Criar</a>
						<a class='item' href='myContent.php'><i class='cog icon'></i>Configurações</a>
					</div>
				</div>
				<a class='item' href='logoutProcess.php'><i class='sign out icon'></i>Sair</a>
				";	
			}elseif($user){
				$iC = new ImageControl();
				$uC = new UserControl();
				$nm = explode(" ",$uC->selectUser($_SESSION['user'])->getName())[0];

				echo "
				<a class='item' href='profile.php'><div class='ui mini circular image'><img src='image.php?imgId={$_SESSION['user']}&type=user'></div><span style='margin-left:6px;'>{$nm}</span></a>
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
	$rAllShow = 0;
	foreach ($rAll as $post) {
		$dt = $post->getCreationDateTime();
		$creationDate = new DateTime($dt);	
		if($actual>=$creationDate){
			$rAllShow++;
		}
	}
	if(count($rAll)!=0){
		echo "
		<div class='introArea'>
			<div class='slider'>
			<div id='wowslider-container1'>
			<div class='ws_images'>
	   			<ul>
		";
		$y = 0;
		foreach ($rAll as $post) {
			$dt = $post->getCreationDateTime();
			$creationDate = new DateTime($dt);	
			if($actual>=$creationDate){
				echo "<li><a href='content.php?id={$post->getId()}#main'><img id='imgSlider' style='width:1147px;height:500px;' src='image.php?imgId={$post->getId()}&type=post' title='{$post->getCategory()} | {$post->getTitle()}'/></a></li>";
			}
			if($y==9){
				break;
			}
			$y++;
		}
		echo "
	        	</ul>
	    	</div>
		<div class='ws_bullets'><div>
	    	
		";
		$y = 0;
		foreach ($rAll as $post) {
			$dt = $post->getCreationDateTime();
			$creationDate = new DateTime($dt);	
			if($actual>=$creationDate){
				echo "<a href='#'></a>";
			}
			if($y==9){
				break;
			}
			$y++;
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

	<div class='mainContent'>
	<div id='gridContent' class='ui two column stackable grid'>
	<div id='leftContentMain' class='twelve wide column'>
	
	<div class='linearLeft'><h2>Últimas publicações</h2></div>
	";
	$i=0;
	if(count($rAll)==0){
		echo "<h2>Que estranho, não há nada.. (°_°)</h2>";
	}
	echo "
	<div class='ui equal width center aligned stackable grid'>
	";
	foreach ($rAll as $post) {
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
			
			$category = $post->getCategory();
			$type = $post->getType();
			if($i%2==0){
				echo "
				<div style='padding-bottom:0 !important;margin-bottom:0 !important' class='row'>
					<div style='padding-right:0 !important;margin-right:4px !important;'  class='column'>";
			}else{
				echo "<div style='padding-left:0 !important;margin-left:4px !important;'  class='column'>";
			}
			echo "
			
				<div class='ui large card'>
				  	<div class='ui image'>
				    	<a href='content.php?id={$post->getId()}#main'><img src='image.php?imgId={$post->getId()}&type=post'></a>
				  	</div>
				  	<div class='content'>
				    	<a href='content.php?id={$post->getId()}#main' class='header'>{$post->getTitle()}";if($post->getEditDateTime()!=NULL){echo "<sup><span class='edited'>EDITADO</span></sup>";}echo "</a>
				    	<div class='meta'>";				    
				    if($admin){
			  			if($_SESSION['admin']==$post->getAuthor()){
			  				echo "
			  				<span style='color:black'>Proprietário | <a href='editPost.php?id={$post->getId()}'><i class='edit large icon'></i> Editar</a><span style='color:red'><a href='deletePost.php?id={$post->getId()}'><i class='eraser large icon'></i> Apagar</a></span></span><br>";
			  			}
			  		}
				    	echo "
				      		<span class='date'>Por {$a->getName()} | {$post->getViews()} visualizações<br>{$finalDate} | {$type} | {$category}</span>
				    	</div>
				    	<div class='description'>
				      		{$post->getSubtitle()}
				    	</div>
				  	</div>
				</div>
			</div>
			";
		if($rAllShow==1 || $i%2==1 || ($rAllShow-1)==$i){
			
			echo "</div>";	
			
		}
		if($i==9){
			break;
		}
		$i++;
		}	
	}

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
	
/*
	<script>
		$('#show_more').click(function(e){  
		    e.preventdefault();
		    $.ajax({
		         url: "../results_ajax/2",
		         type : "POST",
		         dataType :"html",
		         success : function(msg){
		             $('#results_ajax').html(msg).fadeIn("slow");
		         },
		         error: function(msg){ console.log(msg); }
		    });
		});
	</script>
*/
?>