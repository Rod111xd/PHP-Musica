<?php

	session_start();
	if(isset($_SESSION['admin']) || isset($_SESSION['user'])){
		header("location:index.php");
	}
	require_once("PostControl.class.php");
	echo "
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>MN - Entrar | Cadastrar</title>
	<link rel='shortcut icon' type='image/png' href='imgs/icon.png'/>
	<link rel='stylesheet' href='sui/semantic.min.css' />
	<link rel='stylesheet' href='css/wowslider.css'/>
	<link rel='stylesheet' href='plugins/floatingButton/mfb.min.css'/>
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
		<div class='ui two column divided stackable grid'>
			<div class='column'>
				<form class='ui form' action='loginProcess.php' method='post'>
					<h1><i class='sign in icon'></i>Entrar</h1>
					<div class='field'>
						<label>Nome de usuário</label>
						<input type='text' name='user' placeholder='Nome de usuário' required>
					</div>
					<div class='field'>
						<label>Senha</label>
						<input type='password' name='pwd' placeholder='Senha' required>
					</div>
					<input type='hidden' name='loginType' value='userLogin'>
					<button class='ui secondary button' type='submit'>Entrar</button>		
				</form>
			</div>
			<div class='column'>
				<form class='ui form' action='registerUserProcess.php' method='post' enctype='multipart/form-data'>
					<h1><i class='address book icon'></i>Cadastrar</h1>
					<div class='field'>
						<label>Nome de usuário</label>
						<input type='text' name='user' placeholder='Nome de usuário' required>
					</div>
					<div class='two fields'>
						<div class='field'>
							<label>Senha</label>
							<input type='password' name='pwd' placeholder='Senha' required>
						</div>
						<div class='field'>
							<label>Confirme sua senha</label>
							<input type='password' name='pwdConfirm' placeholder='Confirme sua senha' required>
						</div>			
					</div>
					<div class='two fields'>
						<div class='field'>
							<div id='image-preview'>
								<label for='image-upload' id='image-label'>Avatar</label>
								<input type='file' name='img' id='image-upload' accept='image/*' required>
							</div>
						</div>
						<div class='field'>
							<label>Preferências</label>
							<div class='ui checkbox'>
								<input type='checkbox' name='preferences[]' value='Sertanejo'>
	      						<label>Sertanejo</label>
							</div><br>
							<div class='ui checkbox'>
								<input type='checkbox' name='preferences[]' value='Rock'>
	      						<label>Rock</label>
							</div><br>
							<div class='ui checkbox'>
								<input type='checkbox' name='preferences[]' value='Pop'>
	      						<label>Pop</label>
							</div><br>
							<div class='ui checkbox'>
								<input type='checkbox' name='preferences[]' value='Gospel'>
	      						<label>Gospel</label>
							</div><br>
							<div class='ui checkbox'>
								<input type='checkbox' name='preferences[]' value='Mpb'>
	      						<label>Mpb</label>
							</div><br>
							<div class='ui checkbox'>
								<input type='checkbox' name='preferences[]' value='Eletrônica'>
	      						<label>Eletrônica</label>
							</div><br>
							<div class='ui checkbox'>
								<input type='checkbox' name='preferences[]' value='Reggae'>
	      						<label>Reggae</label>
							</div>
							<div class='ui divider'></div>
							<div class='ui checkbox'>
								<input type='checkbox' name='terms' required>
	      						<label>Li e concordo com os termos de cadastro e uso do site.</label>
							</div>
						</div>		
					</div>
					<button class='ui secondary button' type='submit'>Cadastrar</button>		
				</form>
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
	<div class='ui tiny inverted modal' id='errorRegisterModal'>
		<div class='ui icon header'>
	    	<i class='thumbs down icon'></i>
	    	Erro ao efetuar cadastro!
	  	</div>
	  	<div class='content'>
	    	<p>Deu ruim! Para tentar resolver o problema, tente inserir outro usuário e confira a senha e sua confirmação</p>
	  	</div>
	  	<div class='actions'>
	    	<a class='ui ok red button'>Ok</a>
	  	</div>
	</div>
	</div>
	<script src='js/jquery.js'></script>
	<script src='sui/semantic.min.js'></script>
	<script type='text/javascript' src='js/uploadPreview.min.js'></script>
	<script src='plugins/floatingButton/mfb.min.js'></script>
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
	<script type='text/javascript'>
		$(document).ready(function() {
		  $.uploadPreview({
		    input_field: '#image-upload',
		    preview_box: '#image-preview',
		    label_field: '#image-label',
		    label_default: 'Escolher',
		    label_selected: 'Mudar',
		    no_label: false
		  });
		});
		$('#image-preview').css({'width':'100%'});
		var cw = $('#image-preview').width();
		$('#image-preview').css({'height':cw+'px'});
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
	if (isset($_SESSION['userErrorLogin'])) {
		if($_SESSION['userErrorLogin']==true){
			$_SESSION['userErrorLogin'] = false;
			echo "
			<script>
				$('#errorLoginModal').modal('setting', 'closable', false).modal('show');
			</script>";
		}
	}
	if(isset($_SESSION['userErrorRegister'])){
		if($_SESSION['userErrorRegister']==true){
			$_SESSION['userErrorRegister'] = false;
			echo "
			<script>
				$('#errorRegisterModal').modal('setting', 'closable', false).modal('show');
			</script>";
		}
	}
	
?>