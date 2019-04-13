<?php
	session_start();
	if(isset($_SESSION['admin'])){
		$admin = $_SESSION['admin'];
	}else{
		header("location:index.php");
	}
	date_default_timezone_set("America/Fortaleza");
	$actual = new DateTime();	
	require_once("PostControl.class.php");
	require_once("ImageControl.class.php");
	require_once("AdminControl.class.php");
	echo "
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>MN - Minhas publicações</title>
	<link rel='shortcut icon' type='image/png' href='imgs/icon.png'/>
	<link rel='stylesheet' href='sui/semantic.min.css' />
	<link rel='stylesheet' href='css/cardStyle.css'/>
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
		<div class='ui massive inverted menu'>
			<a class='item' href='home.php'><i class='home icon'></i>Início</a>
			<div class='right menu'>";
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
						<a class='item' href='profile.php?id={$_SESSION['admin']}'><i class='cog icon'></i>Configurações</a>
					</div>
				</div>
				<a class='item' href='logoutProcess.php'><i class='sign out icon'></i>Sair</a>
			</div>
		</div>
	</div>
	


	
	<div class='mainContent'>
	<div class='mainContentPadding'>
		<div style='float:left'>
		<a class='ui secondary button' href='editPost.php'><i class='plus large icon'></i>Criar publicação</a>
		<h1>Minhas publicações</h1>";
		$pC = new PostControl();
		$iC = new ImageControl();
		$aC = new AdminControl();
		$r = $pC->selectAdminPosts($_SESSION['admin']);
		if(count($r)==0){
			echo "<h2>Você não tem publicações.. Q_Q</h2>";
		}
		foreach ($r as $post) {
			$dt = $post->getCreationDateTime();
			$creationDate = new DateTime($dt);	
			$a = $aC->selectAdmin($post->getAuthor());
			$dt = (($post->getEditDateTime())!=NULL) ?$post->getEditDateTime() :$post->getCreationDateTime();
			$postDate = new DateTime($dt);
			$interval = $postDate->diff($actual);
			if($actual<$creationDate){
				$textStart = "Publicará em";
			}else{
				$textStart = "Há";
			}
			if($interval->invert==0){
				if($interval->h<1){
					$finalDate = "Há {$interval->i} minuto(s)";
				}elseif($interval->d<1){
					$finalDate = "Há {$interval->h} hora(s)";
				}elseif($interval->d<7){
					$finalDate = "Há {$interval->d} dia(s)";
				}else{
					$finalDate = "Há {$interval->w} semana(s)";
				}
			}else{
				$finalDate = "Publicará em {$postDate->format('d/m/Y H:i:s')}<br>";
			}
			$category = $post->getCategory();
			$type = $post->getType();
			echo "
			<div class='blog-card'>
			    <div class='meta'>
			      <a href='content.php?id={$post->getId()}'><div class='photo' style='background-image: url(image.php?imgId={$post->getId()}&type=post);background-size:cover'></div></a>
			    </div>
			    <div class='description2'>
			      <div class='headerCard'><a href='content.php?id={$post->getId()}'>{$post->getTitle()}</a></div>
			      <div style='margin:0' class='ui divider'></div>
			      <h2>{$finalDate} | {$post->getViews()} visualizações | {$type} | {$category}";if($post->getEditDateTime()!=NULL){echo "<span class='edited'> EDITADO</span><br>";}echo "</h2>
			      <p>{$post->getSubtitle()}</p>
			     	
			      <div class='footerCard'><div class='editDelete'><a href='editPost.php?id={$post->getId()}'><i class='edit large icon'></i> Editar</a><span style='color:red'><a href='deletePost.php?id={$post->getId()}'><i class='eraser large icon'></i> Apagar</a></span></div> <div class='readMore'><a class='ui secondary small button' href='content.php?id={$post->getId()}'>Ver mais</a></div>
			      </div>
			    </div>
			</div>			
			";			
		}
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
	";
	echo "
	</div>
	<script src='js/jquery.js'></script>
	<script src='sui/semantic.min.js'></script>
	<script src='plugins/floatingButton/mfb.min.js'></script>
	<script>
		$('.ui.dropdown')
		  .dropdown()
		;
	</script>
   	<script type='text/javascript'>
		$('#searchButton').click(function(){
			if($('#searchField').val()!=''){
				location.href= 'search.php?name='+$('#searchField').val();
			}
		});
		$('#searchField').keyup(function(e){
			if((e.keyCode==13) && ($('#searchField').val()!='')){
				location.href= 'search.php?name='+$('#searchField').val();
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

?>