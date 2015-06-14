<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset= ISO-8859-1">
	<meta http-equiv="Content-Type" content="text/html; charset= utf-8">
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
	<!-- File Input -->
	<link href="css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <script src="js/fileinput.min.js" type="text/javascript"></script>
    <script src="js/fileinput_locale_es.js" type="text/javascript"></script>
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

    // $('#file-es').fileinput({
        // language: 'es',
        // uploadUrl: '#',
        // allowedFileExtensions : ['jpg', 'png','gif'],
    // });
    // $("#file-0").fileinput({
        // 'allowedFileExtensions' : ['jpg', 'png','gif'],
    // });
    // $("#file-1").fileinput({
        // uploadUrl: '#', // you must set a valid URL here else you will get an error
        // allowedFileExtensions : ['jpg', 'png','gif'],
        // overwriteInitial: false,
        // maxFileSize: 1000,
        // maxFilesNum: 10,
        // //allowedFileTypes: ['image', 'video', 'flash'],
        // slugCallback: function(filename) {
            // return filename.replace('(', '_').replace(']', '_');
        // }
	// });

	// $("#file-3").fileinput({
		// showUpload: false,
		// showCaption: false,
		// browseClass: "btn btn-primary btn-lg",
		// fileType: "any",
        // previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
	// });
	// $("#file-4").fileinput({
		// uploadExtraData: {kvId: '10'}
	// });
    // $(".btn-warning").on('click', function() {
        // if ($('#file-4').attr('disabled')) {
            // $('#file-4').fileinput('enable');
        // } else {
            // $('#file-4').fileinput('disable');
        // }
    // });    
    // $(".btn-info").on('click', function() {
        // $('#file-4').fileinput('refresh', {previewClass:'bg-info'});
    // });

    $(document).ready(function() {
        $("#test-upload").fileinput({
            'showPreview' : false,
            'allowedFileExtensions' : ['jpg', 'png','gif'],
            'elErrorContainer': '#errorBlock'
        });

		
		$("#btnguardar").click(function () {

			var file = document.getElementById("Imagen").value;
			var name=document.getElementById("Nombre").value;
			var surname=document.getElementById("Apellidos").value;
			var phone = document.getElementById("Telefono").value;
			var email = document.getElementById("Correo").value;
			var user=document.getElementById("Username").value;
			var pass=document.getElementById("Password").value;
			var error = 0;
			
			document.getElementById("nombreusuario").className = "form-group col-xs-6 col-sm-6 col-md-6";
			if (name.length<1){
				document.Nombre.placeholder = "Falta el nombre";
				document.getElementById("nombreusuario").className += " has-error";
				error = 1;
			}
			document.getElementById("apellidosusuario").className = "form-group col-xs-6 col-sm-6 col-md-6";
			if (surname.length<1){
				document.Apellidos.placeholder = "Falta el id del equipo";
				document.getElementById("apellidosusuario").className += " has-error";
				error = 1;
			}
			/* Comprobamos la contraseña */
			document.getElementById("passusuario").className = "form-group col-xs-6 col-sm-6 col-md-6";
			var alfaNum = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			if (pass.length<8){
				document.Password.placeholder = "La contraseña debe tener al menos 8 caracteres";
				document.getElementById("passusuario").className += " has-error";
				error = 1;
			}
			else if(pass.indexOf(' ')== 0){
				document.Password.placeholder = "La contraseña no puede contener espacios";
				document.getElementById("passusuario").className += " has-error";
				error = 1;                       
			}
			else{
				for(var i=0; i<pass.length;i++){ /*si hay algun caracter que no sea alfanumerico devuelve error*/
					if(alfaNum.indexOf(pass.charAt(i))==-1){
						document.Password.placeholder = "La contraseña debe tener caracteres alfanumericos";
						document.getElementById("passusuario").className += " has-error";
						error = 1;                            
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
			var values = {
					'nombre'       		: name,
					'apellidos'        	: surname,
					'telefono'       	: phone,
					'correo'        	: email,
					'usuario'       	: user,
					'contrasena'        : pass
			};
			var resultado = false;
			if (error == 0) {
				event.preventDefault();
				
				var $form    = $(event.target),
					formData = new FormData(),
					params   = $form.serializeArray(),
					files    = file;

				$.each(files, function(i, file) {
					formData.append('archivo', file);
				});

				$.each(values, function(i, val) {
					formData.append(val.name, val.value);
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
					
					// <div class='input-group col-xs-3 col-sm-3 col-md-3' style='display: inline-table; padding-left: 10px;'>
						// <div class='container kv-main'>
							// <input id='file-5' class='file' type='file' data-preview-file-type='file' overwriteInitial='false' data-upload-url='http://appdeportesprueba.esy.es' data-preview-file-icon='".$row['img_path']."'
							 // data-file-preview-image='images/mary-poppins1.jpg'>
						// </div>
					// </div>
					
					foreach ($db->query($sql) as $row)
					{
						echo("	<div class='row'>
									<div class='form-group col-xs-12 col-sm-4 col-md-4' style='text-align: center;'>
										<img src='".$row['img_path']."' style='height: 250px; box-shadow: 6px 10px 16px #8B8282;' class='img-circle'>
									</div>
									<div class='col-sm-8 col-md-8'>
										<div class='row'>
											<div class='form-group col-xs-12 col-sm-12 col-md-12'>
												<div class='input-group'>
													<span class='input-group-btn'>
														<span class='btn btn-primary btn-file'>
															Examinar<input type='file'>
														</span>
													</span>
													<input id='Imagen' type='text' class='form-control' name='archivo' readonly>
												</div>
											</div>
										</div>
										<div class='row'>
											<div id='nombreusuario' class='form-group col-xs-6 col-sm-6 col-md-6'>
												<label for='Nombre'>Nombre</label>
												<input type='text' class='form-control' id='Nombre' value='".$row['firstname']."' placeholder=''>
											</div>
											<div id='apellidosusuario' class='form-group col-xs-6 col-sm-6 col-md-6'>
												<label for='Apellidos'>Apellidos</label>
												<input type='text' class='form-control' id='Apellidos' value='".$row['lastname']."' placeholder=''>
											</div>
										</div>
										<div class='row'>
											<div id='telefonousuario' class='form-group col-xs-6 col-sm-6 col-md-6'>
												<label for='Telefono'>Telefono</label>
												<input type='text' class='form-control' id='Telefono' value='".$row['phone']."' placeholder=''>
											</div>
											<div id='correousuario' class='form-group col-xs-6 col-sm-6 col-md-6'>
												<label for='Correo'>Correo</label>
												<input type='text' class='form-control' id='Correo' value='".$row['email']."' placeholder=''>
											</div>
										</div>
										<div class='row'>
											<div id='userusuario' class='form-group col-xs-6 col-sm-6 col-md-6'>
												<label for='Username'>Usuario</label>
												<input type='text' class='form-control' id='Username' value='".$row['username']."' placeholder=''>
											</div>
											<div id='passusuario' class='form-group col-xs-6 col-sm-6 col-md-6'>
												<label for='Password'>Password</label>
												<input type='password' class='form-control' id='Password' value='".$row['password']."' placeholder=''>
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
		</div>
	</div>
</body>
</html>