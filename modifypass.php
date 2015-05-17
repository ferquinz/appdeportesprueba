<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<link rel="shortcut icon" href="images/Logos/LogoV2.jpg" type="image/png" />
	<title>AppdeportesPrueba</title>
    <link rel="stylesheet" type="text/css" href="css/Estilo.css"> 
	<!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Animation -->
	<link href="css/animate.css" rel="stylesheet">
	
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.js"></script>
	<!-- Registro jQuery -->
	<script src="js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
	<script src="js/funciones.js" type="text/javascript"></script>
	<script src="js/jquery.smoothdivscroll-1.3-min.js" type="text/javascript"></script>
	
</head>
<script>

	function validateForm() {			
	
		alert(<?php echo($_REQUEST["correo"]); ?>);
		alert("Prueba");
		/*Comprobacion del nombre*/
		var  pass=document.forms["LoginForm"]["Pass"].value;
		if (pass.length<1){
			alert("El usuario debe contener más de un caracter.");
			return false;
		}				
	
		var  confirmpass=document.forms["LoginForm"]["ConfirmPass"].value;
		if (confirmpass.length<1)
		{
			alert("No se puede dejar en blanco el campo contraseña.");
			return false;
		}		
		
		var resultado = false;

		$.ajax({
			url : "modificar.php",
			type: 'POST',
			data: { password: pass, correo : <?php $_REQUEST["correo"] ?>} ,
			async: false,					
			dataType: 'json',	
				async: false,				
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
			window.location.href = "http://appdeportesprueba.esy.es/index.php";
			return false;
		}
		return resultado;
	}

</script>
<body>
	<!--
		CUADRO DIALOGO LOGIN
	-->	
	<div id="login-box">
		<div class="inset">
			<div class="login-head">
				<h1>Modificar Contraseña</h1>
				 <div class="alert-close"> </div> 			
			</div>
			<form name="LoginForm" action="login.php" class="form-horizontal" style="padding-bottom: 12% !important;">
				<div class="form-group logindiv" >
					<input type="Password" class="passwordlogin" name="Pass" value="" placeholder="Password" >
					<span id="iconuser" class="icon glyphicon glyphicon-lock"></span>
				</div>
				<div class="clear"></div>
				<div class="form-group logindiv" >
					<input type="Password" class="passwordlogin" name="ConfirmPass" value=""  placeholder="Confirmar Password">
					<span id="iconuser" class="icon glyphicon glyphicon-lock"></span>
				</div>
				<div class="clear">  </div>	
				<div class="row">
					<div id="signIn" class="col-xs-6 col-md-offset-3">
						<input type="submit" class="btn-lg btn btn-success center-block" onclick="return validateForm();" value="Modificar" >					
					</div>									
					<div class="clear">  </div>		
				</div>
				</br>
			</form>
		</div>	
	 </div>
	 
 </body>
</html>