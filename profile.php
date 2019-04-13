<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header("location:index.php");
	}
	require_once("UserControl.class.php");
	echo "
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>MN - Conta</title>
	<link rel='shortcut icon' type='image/png' href='imgs/icon.png'/>
	<link rel='stylesheet' href='sui/semantic.min.css' />
	<link rel='stylesheet' href='css/css.css'/>

	<div class='mainIntro'><img src='imgs/logo.png'></div>
	<div id='sticky'>
		<div class='ui massive inverted stackable menu'>
			<a class='item' href='home.php'><i class='home icon'></i>Início</a>
			<div class='right menu'>";
			$uC = new UserControl();
			$r = $uC->selectUser($_SESSION['user']);
			$nm = explode(" ",$uC->selectUser($_SESSION['user'])->getName())[0];
			echo "
				<a class='item' href='profile.php?id={$_SESSION['user']}'><div class='ui mini circular image'><img src='image.php?imgId={$_SESSION['user']}&type=user'></div><span style='margin-left:6px;'>{$nm}</span></a>
				<a class='item' href='logoutProcess.php'><i class='sign out icon'></i>Sair</a>
			</div>
		</div>
	</div>
	


	<div class='mainContent'>
		<div class='mainContentPadding'>
			<div class='ui two column divided grid'>
				<div class='six wide column'>
					<div class='ui medium circular image'>
						<img src='image.php?imgId={$_SESSION['user']}&type=user'>
					</div>
				</div>
				<div class='ten wide column'>
				<h1>{$r->getName()}</h1>
				<h3>Preferências: {$r->getPreferences()}</h3>
				</div>
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