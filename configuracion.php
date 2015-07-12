<!DOCTYPE html>

<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset= ISO-8859-1">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=7,8,9" />
	<link rel="shortcut icon" href="images/Logos/LogoV2.jpg" type="image/png" />
	<title>AppdeportesPrueba</title>
    <link rel="stylesheet" type="text/css" href="css/Estilo.css"> 
	<!-- Bootstrap -->
    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
	
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="js/bootstrap/bootstrap.js"></script>
	<!-- Registro jQuery -->
	<script src="js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
	<script src="js/funciones.js" type="text/javascript"></script>
	<script src="js/jquery.smoothdivscroll-1.3-min.js" type="text/javascript"></script>
	
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="js/fancybox/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="css/fancybox/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="js/fancybox/jquery.fancybox-buttons.js?v=1.0.5"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="css/fancybox/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="js/fancybox/jquery.fancybox-thumbs.js?v=1.0.7"></script>
	
	<!--[if lt IE 9]>
	  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<script>
	
	$(document).on('change', '.btn-file :file', function() {
		var input = $(this),
			numFiles = input.get(0).files ? input.get(0).files.length : 1,
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			input.trigger('fileselect', [numFiles, label]);
	});

	$(document).ready( function() {
		$('.btn-file :file').on('fileselect', function(event, numFiles, label) {        
			var input = $(this).parents('.input-group').find(':text'),
				log = numFiles > 1 ? numFiles + ' files selected' : label;
			
			if( input.length ) {
				input.val(log);
			} else {
				if( log ) alert(log);
			}       
		});
	});

</script>

<script>

    $(document).ready(function() {
		$("#formulario").submit(function (event) {

			var file = document.forms["formulario"]["archivo"].value;
			var name = document.forms["formulario"]["Nombre"].value;
			var surname = document.forms["formulario"]["Apellidos"].value;
			var phone = document.forms["formulario"]["Telefono"].value;
			var email = document.forms["formulario"]["Correo"].value;
			var user = document.forms["formulario"]["Username"].value;
			var pass = document.forms["formulario"]["Password"].value;
			var error = 0;
			
			document.getElementById("nombreusuario").className = "form-group col-xs-6 col-sm-6 col-md-6";
			if (name.length<1){
				document.formulario.nombre.placeholder = "Falta el nombre";
				document.getElementById("nombreusuario").className += " has-error";
				error = 1;
			}
			document.getElementById("apellidosusuario").className = "form-group col-xs-6 col-sm-6 col-md-6";
			if (surname.length<1){
				document.formulario.apellidos.placeholder = "Falta el id del equipo";
				document.getElementById("apellidosusuario").className += " has-error";
				error = 1;
			}
			/* Comprobamos si ha introducido una nueva contraseña */
			document.getElementById("passusuario").className = "form-group col-xs-6 col-sm-6 col-md-6";
			var alfaNum = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			if (pass.length > 0){
				if (pass.length<8){
					document.formulario.password.placeholder = "La contraseña debe tener al menos 8 caracteres";
					document.getElementById("passusuario").className += " has-error";
					error = 1;
				}
				else if(pass.indexOf(' ')== 0){
					document.formulario.password.placeholder = "La contraseña no puede contener espacios";
					document.getElementById("passusuario").className += " has-error";
					error = 1;                       
				}
				else{
					for(var i=0; i<pass.length;i++){ /*si hay algun caracter que no sea alfanumerico devuelve error*/
						if(alfaNum.indexOf(pass.charAt(i))==-1){
							document.formulario.password.placeholder = "La contraseña debe tener caracteres alfanumericos";
							document.getElementById("passusuario").className += " has-error";
							error = 1;                            
						}
					}  
				}
			}
			document.getElementById("telefonousuario").className = "form-group col-xs-6 col-sm-6 col-md-6";
			if (phone.length<1){
				document.getElementById("telefonousuario").className += " has-error";
				error = 1;
			}
			document.getElementById("correousuario").className = "form-group col-xs-6 col-sm-6 col-md-6";
			if (email.length<1){
				document.getElementById("correousuario").className += " has-error";
				error = 1;
			}
			document.getElementById("userusuario").className = "form-group col-xs-6 col-sm-6 col-md-6";
			if (user.length<1){
				document.getElementById("userusuario").className += " has-error";
				error = 1;
			}

			var resultado = false;
			if (error == 0) {
				event.preventDefault();
				
				var $form    = $(event.target),
					formData = new FormData(),
					params   = $form.serializeArray(),
					files    = $form.find('[name="archivo"]')[0].files;

				$.each(files, function(i, file) {
					formData.append('archivo', file);
				});

				$.each(params, function(i, val) {
					console.log(val.name + ":" + val.value);
					formData.append(val.name, val.value);
				});
				
				$.each(formData, function(key, value){
					console.log(key + ":" + value)
				});

				
				$.ajax({
					url : "actualizausuario.php",
					type: 'POST',
					data: formData,
					dataType: 'json',	
					async: false,	
					contentType: false,
					processData: false,				
					success: function(data, textStatus, jqXHR)
					{	
						if(!data.success){
							alert(data.data);
							resultado = false;
						}else {
							console.log(jqXHR.status);
							resultado = true;
						}
					},
					error: function (xhr, status, error){
						alert(error);
						resultado = false;
					}
				});
			}
			if(resultado){
				window.location.reload();
				window.location.href = "configuracion.php";
				return false;
			}
			return resultado;
		});
    });
		
	</script>

<body>
	<div id='cssmenu'>
		<ul>	   
		   <li><a href='deletesession.php'>Desconexion</a></li>
		   <li class='active'><a href='configuracion.php'>Configuracion</a></li>
		   <li><a href='index.php'>Home</a></li>
		</ul>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12">
		<div id = "panelconfig" style="background: #FFF; margin-top: 5%; overflow: auto;" >
			<div class="modal-header">
				<h4> Configuracion </h4>
			</div>
			<form name="formulario" class="" id="formulario" action="javascript:;" enctype="multipart/form-data" method="post" accept-charset="utf-8">
				<div class="modal-body">
					<?php
					
						include ('Formato/conexionsql.php'); 
						if(!isset($_SESSION)) { 
							session_start(); 
						}
						if(empty($_SESSION['id_customer']) || !isset($_SESSION['id_customer'])){
							header("Location: index.php");								
						}
			
						$sql = "SELECT firstname, lastname, email, phone, img_path, username, password FROM customersweb WHERE id_customer = ".$_SESSION['id_customer'];
												
						foreach ($db->query($sql) as $row)
						{
							$valores=explode('/',$row['img_path']);
							$valores[count($valores)-1] = "Original_".$valores[count($valores)-1];
							$originalImage = implode("/", $valores);
							
							echo("	<div class='row'>
										<div class='form-group col-xs-12 col-sm-4 col-md-4' style='text-align: center;'>
											<a class='fancybox' href='".$originalImage."' title='Foto de Perfil' >
												<img src='".$row['img_path']."' id='imagen_perfil' style='height: 250px; box-shadow: 6px 10px 16px #8B8282;' class='img-circle'>
											</a>
										</div>
										<div class='form-group col-sm-8 col-md-8'>
											<div class='row'>
												<div class='form-group col-xs-12 col-sm-12 col-md-12'>
													<div id='divexaminar' class='input-group'>
														<span class='input-group-btn'>
															<span class='btn btn-primary btn-file'>
																Examinar<input type='file' name='archivo'>
															</span>
														</span>
														<input id='Imagen' type='text' class='form-control' readonly>
													</div>
												</div>
											</div>
											<div class='row'>
												<div id='nombreusuario' class='form-group col-xs-6 col-sm-6 col-md-6'>
													<label for='Nombre'>Nombre</label>
													<input type='text' class='form-control' id='Nombre' name='nombre' value='".$row['firstname']."' placeholder=''>
												</div>
												<div id='apellidosusuario' class='form-group col-xs-6 col-sm-6 col-md-6'>
													<label for='Apellidos'>Apellidos</label>
													<input type='text' class='form-control' id='Apellidos' name='apellidos' value='".$row['lastname']."' placeholder=''>
												</div>
											</div>
											<div class='row'>
												<div id='telefonousuario' class='form-group col-xs-6 col-sm-6 col-md-6'>
													<label for='Telefono'>Telefono</label>
													<input type='text' class='form-control' id='Telefono' name='telefono' value='".$row['phone']."' placeholder=''>
												</div>
												<div id='correousuario' class='form-group col-xs-6 col-sm-6 col-md-6'>
													<label for='Correo'>Correo</label>
													<input type='text' class='form-control' id='Correo' name='correo' value='".$row['email']."' placeholder=''>
												</div>
											</div>
											<div class='row'>
												<div id='userusuario' class='form-group col-xs-6 col-sm-6 col-md-6'>
													<label for='Username'>Usuario</label>
													<input type='text' class='form-control' id='Username' name='username' value='".$row['username']."' placeholder=''>
												</div>
												<div id='passusuario' class='form-group col-xs-6 col-sm-6 col-md-6'>
													<label for='Password'>Nueva Password</label>
													<input type='password' class='form-control' id='Password' name='password' value='' placeholder=''>
												</div>
											</div>
											<div class='row'>
												<div class='form-group col-xs-12 col-sm-12 col-md-12' style='text-align: center;'>
													<button id='btnguardar' type='submit' class='btn btn-primary' style='width: 200px;'>Guardar</button>
												</div>
											</div>
										</div>
									</div>	
								");
						}
					?>	
				</div>
			</form>
		</div>
	</div>
</body>
</html>