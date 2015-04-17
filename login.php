<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/Estilo.css"> 
	<!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js?ver=1.4.2"></script>
	<!-- Registro jQuery -->
	<script src="js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
	<script src="js/funciones.js" type="text/javascript"></script>
	<script src="js/jquery.smoothdivscroll-1.3-min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</head>

<script>

	function validateForm() {			
	
		/*Comprobacion del nombre*/
		var  user=document.forms["LoginForm"]["Username"].value;
		if (user.length<1)
		{
			alert("El usuario debe contener más de un caracter.");
			return false;
		}				
	
		var  pass=document.forms["LoginForm"]["Password"].value;
		if (pass.length<1)
		{
			alert("No se puede dejar en blanco el campo contraseña.");
			return false;
		}		
		
		var resultado = false;

		$.ajax({
			url : "conectarse.php",
			type: 'GET',
			data: { email: user, password : pass} ,
			async: false,					
			success: function(data, textStatus, jqXHR)
			{						
				var cad = new String(data);
				resultado = calledFromAjaxSuccess(cad);															
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert("Error al realizar el login");						
			}
		});		
		
		return resultado;
	}		
	
	function calledFromAjaxSuccess(cad) {
		if(cad.indexOf("2")>0){
			alert("Rellene todos los campos para realizar el login.");
			return false;
		}else if(cad.indexOf("3")>0){
			alert("Usuario o contraseña incorrectos.");
			return false;
		}else if(cad.indexOf("1")>0){						 
			return true;							 
		}
	}
	
	function registerForm(){
	
		var name=document.forms["formulario"]["nombre"].value;
		var firstname=document.forms["formulario"]["apellidos"].value;
		var user=document.forms["formulario"]["usuario"].value;
		var email=document.forms["formulario"]["correo"].value;
		var phone=document.forms["formulario"]["tel"].value;
		var pass = document.forms["formulario"]["passPrueba"].value;
		var passConfirm = document.forms["formulario"]["pass"].value;
		var file = document.forms["formulario"]["archivo"].value
				
		/*alert("Prueba");*/
		var error = 0;
		
		document.getElementById("divterminos").className = "form-group";
		if (!document.forms["formulario"]["condiciones"].checked){						
			 /*alert("Debe aceptar las condiciones para continuar."); */
			 document.getElementById("divterminos").className += " has-error";
			 error = 1;
		}
		

		document.getElementById("divnombre").className = "form-group";
		if (name.length<1){
			document.formulario.nombre.placeholder = "Falta el nombre";
			document.getElementById("divnombre").className += " has-error";
			error = 1;
		}
		document.getElementById("divapellidos").className = "form-group";
		if (firstname.length<1){
			document.formulario.apellidos.placeholder = "Falta el apellido";
			document.getElementById("divapellidos").className += " has-error";
			error = 1;
		}
		document.getElementById("divusuario").className = "form-group";
		if (user.length<1){
			document.formulario.usuario.placeholder = "Falta el usuario";
			document.getElementById("divusuario").className += " has-error";
			error = 1;
		}
		document.getElementById("divcorreo").className = "form-group";
		if (email.length<1){
			document.formulario.correo.placeholder = "Falta el correo";
			document.getElementById("divcorreo").className += " has-error";
			error = 1;
		}
		
		/* Comprobamos el telefono */
		document.getElementById("divtel").className = "form-group";
		var numeros = "0123456789";
		if (phone.length<1){
			document.formulario.tel.placeholder = "Falta el telefono";
			document.getElementById("divtel").className += " has-error";
			error = 1;
		}
		else if (phone.length<9){
			document.formulario.tel.placeholder = "El telefono debe contener al menos 9 números";
			document.getElementById("divtel").className += " has-error";
			error = 1;
		}
		else{
			for(var i=0; i<phone.length;i++){ /*si hay algun caracter que no sea numérico devuelve error*/
				if(numeros.indexOf(phone.charAt(i))==-1){
					document.formulario.tel.placeholder = "Telefono incorrecto: solo puede contener números";
					document.getElementById("divtel").className += " has-error";
					error = 1;
				}
			}
		}
		
		/* Comprobamos el correo */
		var atpos=email.indexOf("@"); /*Debe contener @*/
		var dotpos=email.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length){
			document.formulario.correo.placeholder = "Correo invalido";
			document.getElementById("divcorreo").className += " has-error";
			error = 1;
		}	
		
		/* Comprobamos la contraseña */
		document.getElementById("divpassPrueba").className = "form-group";
		document.getElementById("divpass").className = "form-group";
		var alfaNum = "abcdefghijklmnopqrstuvwxyz0123456789";
		if (pass.length<8 || passConfirm.length<8){
			document.formulario.passPrueba.placeholder = "La contraseña debe tener al menos 8 caracteres";
			document.getElementById("divpassPrueba").className += " has-error";
			document.getElementById("divpass").className += " has-error";
			error = 1;
		}
		else if(pass.indexOf(' ')== 0){
			document.formulario.passPrueba.placeholder = "La contraseña no puede contener espacios";
			document.getElementById("divpassPrueba").className += " has-error";
			error = 1;                       
		}
		else if(pass.localeCompare(passConfirm)){ /*Las dos contraseñas introducidas tienen que coincidir*/
			document.formulario.pass.placeholder = "La contraseña no coincide";
			document.getElementById("divpass").className += " has-error";
			error = 1;
		}
		else{
			for(var i=0; i<pass.length;i++){ /*si hay algun caracter que no sea alfanumerico devuelve error*/
				if(alfaNum.indexOf(pass.charAt(i))==-1){
					document.formulario.passPrueba.placeholder = "La contraseña debe tener caracteres alfanumericos";
					document.getElementById("divpassPrueba").className += " has-error";
					error = 1;                            
				}
			}  
		}
							
		var resultado = false;

		if (error == 0) {
			$.ajax({
				url : "registrarse.php",
				type: 'POST',
				data: { nombre: name , apellidos: firstname , usuario: user , correo: email , tel: phone , pass: pass, archivo: file} ,
				dataType: 'json',	
				async: false,				
				success: function(data, textStatus, jqXHR)
				{	
					//alert(data.success);
					if(!data.success){
						//alert("Error");
						alert(data.data);
						resultado = false;
					}else {
						console.log(jqXHR.status);
						window.location.href= "/index.php";
						resultado = true;
						//window.location.href = "http://appdeportesprueba.esy.es/index.php";
					}
				},
				error: function (xhr, status, error){
					alert(error);
					resultado = false;
				}
			});
		}
				
		return resultado;
	}
	
</script>

<body>
	<div id="login-box">
		<div class="inset">
			<div class="login-head">
				<h1>Login</h1>
				 <div class="alert-close"> </div> 			
			</div>
			<form name="LoginForm" action="index.php" class="form">
				<div class="form-group logindiv" >
					<input type="text" class="textlogin" name="Username" value="" placeholder="Correo" >
					<span id="iconuser" class="icon glyphicon glyphicon-user"></span>
				</div>
				<div class="clear"></div>
				<div class="form-group logindiv" >
					<input type="Password" class="passwordlogin" name="Password" value=""  placeholder="Password">
					<span id="iconuser" class="icon glyphicon glyphicon-lock"></span>
				</div>
				<!--<li>
					<input type="text" class="textlogin" name="Username" value="Correo" onfocus="if(this.value=='Correo') this.value = '';" onblur="if (this.value == '') {this.value = 'Correo';}">
					<a href="" class=" icon user"></a>
				</li>
				<div class="clear">  </div>
				<li>
					<input type="Password" class="passwordlogin" name="Password" value="Password" onfocus="if(this.value=='Password') this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}"> 
					<a href="" class="icon lock"></a>
				</li>-->
				<div class="clear">  </div>	
				<div class="submit">
					<div id="signIn">
						<input type="submit" onclick="return validateForm();" value="Entrar" >					
					</div>							
					<div class="register" id="register">
						<input type="submit" id="activator" value="Registro" >
					</div>			
					<div class="clear">  </div>		
				</div>
				<br>
				<center><h4><a href="#">¿Olvidó su contraseña?</a></h4></center>	
			</form>
		</div>	
	 </div>
	<!-- Menu al pulsar sobre el menu de registro -->
	<div class="registro" id="registro" style="display:none;"></div>
	<div class="cuadroRegistro" id="cuadroRegistro">
		<a class="cierreCuadroRegistro" id="cierreCuadroRegistro"></a>
		<h1>Registro</h1>
		    <form action="" class="form-horizontal" name="formulario">
				<div class="form-group">
					<label for="login" class="col-sm-3 control-label">Imagen:</label>
					<div class="col-xs-8">
						<input type="file" name="archivo" />
					</div>
				</div>
				<div id="divnombre" class="form-group">
					<label for="login" class="col-sm-3 control-label">Nombre:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" value="" name="nombre" placeholder="Nombre">
						<span data-alertid="example"></span>
					</div>
				</div>
				<div id="divapellidos" class="form-group">
					<label for="login" class="col-sm-3 control-label">Apellidos:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" value="" name="apellidos" placeholder="Apellidos">
					</div>
				</div>				
				<div id="divusuario" class="form-group">
					<label for="login" class="col-sm-3 control-label">Usuario:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" value="" name="usuario" placeholder="Usuario">
					</div>
				</div>
				<div id="divcorreo" class="form-group">
					<label for="login" class="col-sm-3 control-label">Email:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" value="" name="correo" placeholder="Email">
					</div>
				</div>
				<div id="divpassPrueba" class="form-group">
					<label for="login" class="col-sm-3 control-label">Contraseña:</label>
					<div class="col-xs-8">
						<input type="password" class="form-control" name="passPrueba" placeholder="Contraseña" value="">
					</div>
				</div>
				<div id="divpass" class="form-group">
					<label for="login" class="col-sm-3 control-label">Confirmación:</label>
					<div class="col-xs-8">
						<input type="password" class="form-control" name="pass" placeholder="Confirmacion contraseña" value="">
					</div>
				</div>
				<div id="divtel" class="form-group">
					<label for="login" class="col-sm-3 control-label">Teléfono:</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" value="" name="tel" placeholder="Telefono">
					</div>
				</div>
				<div id="divterminos" class="form-group">
					<div class="col-sm-offset-3 col-xs-8">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="condiciones" id="condiciones" value="">Acepto los <a href="#largeModal" data-toggle="modal">terminos y condiciones de uso</a>
								<!-- Modal HTML -->
								<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									  <div class="modal-dialog modal-lg">
											<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title" id="myModalLabel">Large Modal</h4>
											</div>
											<div class="modal-body">
												<h3>Modal Body</h3>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												<button type="button" class="btn btn-primary">Save changes</button>
											</div>
											</div>
									  </div>
								</div>
							</label>
						</div>
					</div>
				</div>				
				<div class="form-group">
					<div class="col-xs-8 col-sm-offset-3">
						<input type="submit" id="activator" class="btn btn-primary" value="Aceptar" onclick="return registerForm();">
					</div>
				</div>
				
			</form>			
	</div>
	
</body>
</html>