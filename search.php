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
	if((!isset($_GET['name'])) || (!isset($_GET['category'])) || (!isset($_GET['type'])) || (!isset($_GET['classification']))){
		header("location:index.php");
	}
	date_default_timezone_set("America/Fortaleza");
	$actual = new DateTime();	
	require_once("PostControl.class.php");
	require_once("UserControl.class.php");
	require_once("ImageControl.class.php");
	require_once("AdminControl.class.php");
	echo "
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>MN - Pesquisar..</title>
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
						<a class='item' href='profile.php?id={$_SESSION['admin']}'><i class='cog icon'></i>Configurações</a>
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
	


	<div class='mainContent'>
	<div class='mainContentPadding'>
		<form id='searchForm' class='ui form' action='search.php' method='get'>
			<h1>Pesquisar</h1>
			<div class='four fields'>
				<div class='field'>
					<label>Nome ou tag</label>
					<input type='text' name='name' placeholder='Nome ou tag' required>
				</div>
				<div class='field'>
					<label>Categoria</label>
					<select name='category' class='ui fluid dropdown'>
						<option value='Todos'>Todos</option>
						<option value='Sertanejo'>Sertanejo</option>
						<option value='Rock'>Rock</option>
						<option value='Gospel'>Gospel</option>
						<option value='Mpb'>Mpb</option>
						<option value='Eletrônica'>Eletrônica</option>
						<option value='Reggae'>Reggae</option>
					</select>
				</div>					
				<div class='field'>
					<label>Tipo:</label>
					<select name='type' class='ui fluid dropdown'>
						<option value='Todos'>Todos</option>
						<option value='Notícias'>Notícias</option>
						<option value='Curiosidades'>Curiosidades</option>
						<option value='Dicas'>Dicas</option>
					</select>
				</div>				
				<div class='field'>
					<label>Classificar por:</label>
					<select name='classification' class='ui fluid dropdown'>
						<option value='recents'>Mais recentes</option>
						<option value='olders'>Mais antigos</option>
						<option value='views'>Visualizações</option>
					</select>
				</div>
			</div>
			<button class='ui secondary button' type='submit'>Pesquisar</button>		
		</form>
		<div style='float:left'>";
		if(isset($_GET['name'])){
			$tags = explode(" ",$_GET['name']);
			if(count($tags)>1){
				for($i=0;$i<count($tags);$i++){
					if($i==0){
						$tags[$i] = "{$tags[$i]} ";
					}elseif($i==(count($tags))-1){
						$tags[$i] = " {$tags[$i]}";
					}else{
						$tags[$i] = " {$tags[$i]} ";
					}
				}
			}

			if($_GET['classification']=="recents"){
				$order = "CASE WHEN editDate IS NULL THEN creationDate ELSE editDate END DESC";		
			}elseif($_GET['classification']=="olders"){
				$order = "CASE WHEN editDate IS NULL THEN creationDate ELSE editDate END ASC";
			}else{
				$order = "views DESC";
			}
			
			$type = ($_GET['type']=="Todos") ?"" :" AND type='{$_GET['type']}'";
			$category = ($_GET['category']=="Todos") ?"" :" AND category='{$_GET['category']}'";	
			$only = "{$type}{$category}";
			echo "<h2>Pesquisa: {$_GET['name']}</h2>";
			$pC = new PostControl();
			$iC = new ImageControl();
			$aC = new AdminControl();
			$r = $pC->selectSearchPosts($tags,$only,$order);
			if(count($r)==0){
				echo "<h2>Nada foi encontrado ¯\_(ツ)_/¯</h2>";
			}
			foreach ($r as $post) {
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
				     	
				      <div class='footerCard'>";if($admin){if($_SESSION['admin']==$post->getAuthor()){echo "<div class='editDelete'><a href='editPost.php?id={$post->getId()}'><i class='edit large icon'></i> Editar</a><span style='color:red'><a href='deletePost.php?id={$post->getId()}'><i class='eraser large icon'></i> Apagar</a></span></div>";}} echo " <div class='readMore'><a class='ui secondary small button' href='content.php?id={$post->getId()}'>Leia mais</a></div>
				      </div>
				    </div>
				</div>			
				";			
			}
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
		$('select.dropdown')
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