<?php
	session_start();
	if(isset($_SESSION['admin'])){
		$admin = $_SESSION['admin'];
	}else{
		header("location:home.php");
	}
	if(isset($_GET['id'])){
		$edit = true;
		setcookie("id",$_GET['id']);
	}else{
		$edit = false;
	}
	date_default_timezone_set("America/Fortaleza");
	$actual = new DateTime();
	require_once("PostControl.class.php");
	require_once("ImageControl.class.php");
	require_once("AdminControl.class.php");
	if($edit){
		$pC = new PostControl();
		$aC = new AdminControl();
		$iC = new ImageControl();
		$r = $pC->selectPost($_GET['id']);
		if($r->getAuthor()!=$admin){
			header("location:home.php");
		}
		$text = str_replace("<p></p>", "", strip_tags($r->getText(), '<p></p>'));
	}
	
	echo "
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>MN - Criar | Editar</title>
	<link rel='shortcut icon' type='image/png' href='imgs/icon.png'/>
	<link rel='stylesheet' href='sui/semantic.min.css' />
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css'>
	<link rel='stylesheet' href='plugins/froala/css/froala_editor.css'>
	<link rel='stylesheet' href='plugins/froala/css/froala_style.css'>
	<link rel='stylesheet' href='plugins/froala/css/plugins/code_view.css'>
	<link rel='stylesheet' href='plugins/froala/css/plugins/draggable.css'>
	<link rel='stylesheet' href='plugins/froala/css/plugins/colors.css'>
	<link rel='stylesheet' href='plugins/froala/css/plugins/emoticons.css'>
	<link rel='stylesheet' href='plugins/froala/css/plugins/image_manager.css'>
	<link rel='stylesheet' href='plugins/froala/css/plugins/image.css'>
	<link rel='stylesheet' href='plugins/froala/css/plugins/line_breaker.css'>
	<link rel='stylesheet' href='plugins/froala/css/plugins/table.css'>
	<link rel='stylesheet' href='plugins/froala/css/plugins/char_counter.css'>
	<link rel='stylesheet' href='plugins/froala/css/plugins/video.css'>
	<link rel='stylesheet' href='plugins/froala/css/plugins/fullscreen.css'>
	<link rel='stylesheet' href='plugins/froala/css/plugins/file.css'>
	<link rel='stylesheet' href='plugins/froala/css/plugins/quick_insert.css'>
	<link rel='stylesheet' href='plugins/froala/css/plugins/help.css'>
	<link rel='stylesheet' href='plugins/froala/css/third_party/spell_checker.css'>
	<link rel='stylesheet' href='plugins/froala/css/plugins/special_characters.css'>
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css'>
	<link rel='stylesheet' href='css/jquery.datetimepicker.css'/>
	<link rel='stylesheet' href='css/tagify.css'/>
	<link rel='stylesheet' href='plugins/floatingButton/mfb.min.css'/>
	<link rel='stylesheet' href='css/css.css'/>

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
	<div class='mainIntro'><img src='imgs/logo.png'></div>
	<div id='sticky'>
		<div class='ui massive inverted stackable menu'>
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
		<a class='ui secondary button' href='javascript:history.back()'><i class='arrow alternate circle left outline large icon'></i>Voltar</a>
		<h1>Criar publicação</h1>
		<form class='ui form'";if(!$edit){echo "action='createPostProcess.php'";}else{echo "action='editPostProcess.php'";}echo " method='post' enctype='multipart/form-data'>
			<div class='ui two column divided stackable grid'>
				<div class='column'>
					<div class='field'>
						<label>Título</label>
						<input type='text' name='title' maxlength='70' placeholder='Título da publicação' ";if($edit){echo "value='{$r->getTitle()}'";} echo "required>
					</div>
					<div class='field'>
						<label>Legenda</label>
						<input type='text' name='subtitle' maxlength='200' placeholder='Legenda da publicação' ";if($edit){echo "value='{$r->getSubtitle()}'";} echo "required>
					</div>
					<div class='two fields'>
						<div class='field'>
							<label>Tipo</label>
							<select id='type' name='type' class='ui fluid dropdown'>
								<option value='Notícias'";if($edit && $r->getType()=="Notícias"){echo" selected";} echo">Notícia</option>
								<option value='Curiosidades'";if($edit && $r->getType()=="Curiosidades"){echo" selected";} echo">Curiosidade</option>
								<option value='Dicas'";if($edit && $r->getType()=="Dicas"){echo" selected";} echo">Dica</option>
							</select>
						</div>					
						<div class='field'>
							<label>Categoria</label>
							<select id='category' name='category' class='ui fluid dropdown'>
								<option value='Sertanejo'";if($edit && $r->getCategory()=="Sertanejo"){echo" selected";} echo">Sertanejo</option>
								<option value='Rock'";if($edit && $r->getCategory()=="Rock"){echo" selected";} echo">Rock</option>
								<option value='Pop'";if($edit && $r->getCategory()=="Pop"){echo" selected";} echo">Pop</option>
								<option value='Gospel'";if($edit && $r->getCategory()=="Gospel"){echo" selected";} echo">Gospel</option>
								<option value='Mpb'";if($edit && $r->getCategory()=="Mpb"){echo" selected";} echo">Mpb</option>
								<option value='Eletrônica'";if($edit && $r->getCategory()=="Eletronica"){echo" selected";} echo">Eletrônica</option>
								<option value='Reggae'";if($edit && $r->getCategory()=="Reggae"){echo" selected";} echo">Reggae</option>
							</select>
						</div>		
					</div>
					";
					if($edit){
						$dt = $r->getCreationDateTime();
						$creationDate = new DateTime($dt);		
						if($actual<$creationDate){
							echo "
							<div class='two fields'>
								<div id='publicField' class='eight wide field'>
									<label>Publicar em</label>
									<select id='public' name='public' class='ui fluid dropdown'>
										<option value='now'>Agora</option>
										<option value='other' selected>Data..</option>
									</select>
								</div>
								<div id='publishDateField' style='display:none;' class='eight wide field'>
									<label>Data Publicação</label>
									<input id='publishDate' type='text' name='publishDate' placeholder='Data' readonly required>
								</div>
							</div>

							";
						}else{
							echo "
							<input type='hidden' name='alreadyPublished' value='alreadyPublished'>
							";
						}
					}else{
					echo "
					<div class='two fields'>
						<div class='eight wide field'>
							<label>Público em</label>
							<select id='public' name='public' class='ui fluid dropdown'>
								<option value='now'>Agora</option>
								<option value='other'>Data..</option>
							</select>
						</div>
						<div id='publishDateField' style='display:none;' class='eight wide field'>
							<label>Data Publicação</label>
							<input id='publishDate' type='text' name='publishDate' placeholder='Data' readonly required>
						</div>
					</div>";		
					}
					echo "
					<div class='two fields'>
						<div class='eight wide field'>
							<label>Remover em</label>
							<select id='remove' name='remove' class='ui fluid dropdown'>
								<option value='never'>Nunca</option>
								<option value='other' ";if($edit){if($r->getRemoveDateTime()=="0000-00-00 00:00:00"){echo"selected";}}echo ">Data..</option>
							</select>
						</div>	
						<div id='removeDateField' style='display:none;' class='eight wide field'>
							<label>Data Remoção</label>	
							<input id='removeDate' type='text' name='removeDate' placeholder='Data' readonly required>
						</div>
					</div>
					<div id='urgent' class='field'>
						<div class='ui checkbox'>
							<input id='urgentCheckbox' type='checkbox' name='urgent' ";if($edit){if($r->getFeatured()){echo"checked";}}echo ">
      						<label>Marcar como urgente</label>
						</div>
					</div>		
				</div>
				<div class='column'>
				<center>
					<div id='image-preview' ";if($edit){echo "style='background-image:url(image.php?imgId={$r->getId()}&type=post) !important;'";} echo ">
				  		<label for='image-upload' id='image-label'><i class='image big icon'></i>Capa</label>
				  		<input type='file' name='img' id='image-upload' accept='image/*' ";if(!$edit){echo"required";} echo " />
					</div>
				</center>
				</div>
			</div><br>
			<textarea name='text' placeholder='Seu texto' required>";if($edit){echo "{$text}";} echo "</textarea><br><br>
			
			<div class='field'>
	            <div class='addel'>
	                <h2>Adicionar imagens ou vídeos</h2>
	                <div class='target'>
	                	<div class='ui grid'>
	                		<div class='eight wide column'>
		                        <input type='file' name='media[]' required>
		                    	
	                        </div>
	                        <div class='two wide column'>
	                        	<input type='text' name='paragraph[]' placeholder='Parágrafo' maxlength='3' required>
	                        </div>
	                        <div class='six wide column'>
	                        	<button type='button' class='ui red button addel-delete'><i class='fa fa-remove'></i></button>
	                        </div>
	                	</div>
	                </div>
	                <br>
	                <button type='button' class='ui secondary button addel-add'><i class='fa fa-plus'></i></button>
	            </div>
            </div>

			<div class='field'>
				<label>Tags</label>
				<input name='tags' placeholder='Digite as tags' value='";if($edit && $r->getTags()!=NULL){echo "{$r->getTags()}";}  echo "'>
			</div>
			<input class='ui secondary button' type='submit' value='Enviar'>
		</form>
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
	<script src='js/jQuery.tagify.js'></script>
	<script src='sui/semantic.min.js'></script>
	<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js'></script>
  	<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/froala_editor.min.js' ></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/align.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/char_counter.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/code_beautifier.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/code_view.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/colors.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/draggable.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/emoticons.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/entities.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/file.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/font_size.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/font_family.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/fullscreen.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/image.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/image_manager.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/line_breaker.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/inline_style.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/link.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/lists.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/paragraph_format.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/paragraph_style.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/quick_insert.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/quote.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/table.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/save.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/url.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/video.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/help.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/print.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/third_party/spell_checker.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/special_characters.min.js'></script>
	<script type='text/javascript' src='plugins/froala/js/plugins/word_paste.min.js'></script>
	<script type='text/javascript' src='js/uploadPreview.min.js'></script>
	<script type='text/javascript' src='js/jquery.datetimepicker.full.min.js'></script>
	<script src='js/addel.jquery.js'></script>
	<script src='plugins/floatingButton/mfb.min.js'></script>
	<script>
		$('select.dropdown')
	  		.dropdown()
		;
	</script>
	<script>
		$(function() { 
			$('textarea').froalaEditor({
				toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'color', '|', 'fontFamily', 'fontSize', '|', 'align', 'formatOL', 'formatUL', 'insertLink', 'clearFormatting', 'insertTable', 'save'],
      			toolbarButtonsXS: ['undo', 'redo' , '-', 'bold', 'italic', 'underline'],
      			language: 'pt_br',
      			height:300,
      			quickInsertButtons: ['table', 'ol', 'ul', 'myButton']
			});
		})
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
		var cw = $('#image-preview').width();
		$('#image-preview').css({'height':cw+'px'});
	</script>
	<script>
		$('[name=tags]').tagify({
			delimiters: [' ',','],
			maxTags: 8,
			addTagOnBlur: true,
			duplicates: false,
			blacklist: ['[','{',':',',','}',']','/']
		});
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
		$('#type').change(function(){
			if($('#type').val()=='news'){
				$('#urgent').removeClass('disabled');
			}else{
				$('#urgent').addClass('disabled');
				$('#urgentCheckbox').prop('checked', false);
			}
		});
	</script>
	<script>
		function refreshElements(){
			if($('#public').val()=='other'){
				$('#publishDateField').css('display','inline-block');
				$('#publishDate').prop('required',true);
			}else{
				$('#publishDateField').css('display','none');
				$('#publishDate').prop('required',false);
			}

			if($('#remove').val()=='other'){
				$('#removeDateField').css('display','inline-block');
				$('#removeDate').prop('required',true);
			}else{
				$('#removeDateField').css('display','none');
				$('#removeDate').prop('required',false);
			}			
						
		}
		$('#public').change(function(){refreshElements()});
		$('#remove').change(function(){refreshElements()});
		$('document').ready(function(){refreshElements()});
	</script>
	<script>
		jQuery('#publishDate').datetimepicker({
			formatDate:'Y-m-d H:i:s.f',
			minDate:'+1970/01/02',
			maxDate:'+1970/04/01',
			allowTimes:['00:00','00:30','01:00','01:30','02:00','02:30',
			'03:00','03:30','04:00','04:30','05:00',
			'05:30','06:00','06:30','07:00','07:30',
			'08:00','08:30','09:00','09:30','10:00',
			'10:30','11:00','11:30','12:00','12:30',
			'13:00','13:30','14:00','14:30','15:00',
			'15:30','16:00','16:30','17:00','17:30',
			'18:00','18:30','19:00','19:30','20:00',
			'20:30','21:00','21:30','22:00','22:30',
			'23:00','23:30']
		});
		jQuery('#removeDate').datetimepicker({
			formatDate:'Y-m-d H:i:s.f',
			minDate:'+1970/01/02',
			maxDate:'+1972/01/01',
			allowTimes:['00:00','00:30','01:00','01:30','02:00','02:30',
			'03:00','03:30','04:00','04:30','05:00',
			'05:30','06:00','06:30','07:00','07:30',
			'08:00','08:30','09:00','09:30','10:00',
			'10:30','11:00','11:30','12:00','12:30',
			'13:00','13:30','14:00','14:30','15:00',
			'15:30','16:00','16:30','17:00','17:30',
			'18:00','18:30','19:00','19:30','20:00',
			'20:30','21:00','21:30','22:00','22:30',
			'23:00','23:30']";
			if($edit){
				$removeDt = $r->getRemoveDateTime();
				$removeDate = new DateTime($removeDt);
				$defaultDate = $removeDate->format('Y-m-d');
				$defaultTime = $removeDate->format('H:i:s.floated');
				if($removeDt!="0000-00-00 00:00:00"){
					echo "
					,defaultDate:'{$defaultDate}',
					defaultTime:'{$defaultTime}'
					";
				}
			}
			echo"
		});
		jQuery.datetimepicker.setLocale('pt-BR');
	</script>
	<script>
		
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
	<script>
		$(document).ready(function () {
	        $('.addel').addel({
	            classes: {
	                target: 'target'
	            },
	            animation: {
	                duration: 100
	            }
	        });
    	});
	</script>
	";

?>
