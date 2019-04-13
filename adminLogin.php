<?php

	session_start();
	if(isset($_SESSION['admin']) || isset($_SESSION['user'])){
		header("location:index.php");
	}
	require_once("PostControl.class.php");
	echo "
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>MN - Entrar como admin</title>
	<link rel='shortcut icon' type='image/png' href='imgs/icon.png'/>
	<link rel='stylesheet' href='sui/semantic.min.css' />
	<link rel='stylesheet' href='css/wowslider.css'/>
	<link rel='stylesheet' href='css/css.css'/>

	<div class='mainIntro'><img src='imgs/logo.png'></div>
	<div id='sticky'>
		<div class='ui massive inverted stackable menu'>
			<a class='item' href='home.php'><i class='home icon'></i>Início</a>
			<div class='right menu'>
				<a class='item' href='userLoginRegister.php'><i class='user circle icon'></i>Entrar</a>
				<a class='item' href='adminLogin.php'><i class='wrench icon'></i></a>
			</div>
		</div>
	</div>
	

	<div class='mainContent'>
	<div class='mainContentPadding'>
		<div class='loginContainerMargin'>
			<div class='loginContainer'>
				<div class='ui center aligned container'>
					<form class='ui form' action='loginProcess.php' method='post'>
						<h1>Entrar como administrador</h1>
						<div class='field'>
							<label>Nome</label>
							<input type='text' name='admin' placeholder='Nome de administrador' required>
						</div>
						<div class='field'>
							<label>Senha</label>
							<input type='password' name='pwd' placeholder='Senha' required>
						</div>
						<input type='hidden' name='loginType' value='adminLogin'>
						<button class='ui secondary button' type='submit'>Entrar</button>		
					</form>
				</div>
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
	<div class='ui tiny inverted modal' id='errorLoginModal'>
		<div class='ui icon header'>
	    	<i class='thumbs down icon'></i>
	    	Erro ao efetuar login!
	  	</div>
	  	<div class='content'>
	    	<p>Deu ruim! Para tentar resolver o problema, verifique se seu nome de usuário e senhas estão corretos. Se ainda não possuir um cadastro, o faça ao lado direito.</p>
	  	</div>
	  	<div class='actions'>
	    	<a class='ui ok red button'>Ok</a>
	  	</div>
	</div>
	</div>
	<script src='js/jquery.js'></script>
	<script src='sui/semantic.min.js'></script>
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
	if(isset($_SESSION['adminErrorLogin'])){
		if($_SESSION['adminErrorLogin']==true){
			$_SESSION['adminErrorLogin'] = false;
			echo "
			<script>
				$('#errorLoginModal').modal('setting', 'closable', false).modal('show');
			</script>";
		}	
	}
	

?>