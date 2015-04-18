<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
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
			window.location.href = "index.php";
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
				<center><h4><a href="#myModal" data-toggle="modal">¿Olvidó su contraseña?</a></h4></center>
			</form>
		</div>	
	 </div>
	 <!--
		CIERRE CUADRO DIALOGO LOGIN
	-->
	
	
	<!-- Menu al pulsar sobre el menu de registro -->
	<div class="registro" id="registro" style="display:none;"></div>
	<!--
		CUADRO DIALOGO REGISTRO
	-->
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
	<!--
		CIERRE CUADRO DIALOGO REGISTRO
	-->
	
	
	<!-- 
		Modal HTML para el correo 
	-->
	<div id="myModal" class="modal fade animated rotateInDownLeft" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<a class="cierreCuadroRegistro" id="cierremyModal" data-dismiss="modal" aria-hidden="true"></a>
					<h4 id="myModalLabel">Olvidó su Contraseña</h4>
				</div>
				<div class="modal-body">
					<p>Escriba su correo electronico y le enviaremos un correo con su contraseña</p>
					<form>
						<div class="form-group">
							<label for="recipient-name" class="control-label">Correo:</label>
							<input type="text" class="form-control" id="recipient-name" placeholder="example@example.com">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary">Enviar</button>
					<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
				</div>
			</div>
		</div>
	</div>
	<!-- 
		Modal HTML para los terminos y condiciones
	-->
	<div class="modal fade animated bounceIn" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<a class="cierreCuadroRegistro" id="cierrelargeModal" data-dismiss="modal" aria-hidden="true"></a>
						<h4 class="modal-title" id="myModalLabel">Terminos y Condiciones</h4>
					</div>
					<div class="modal-body">
						<h2>Objeto</h2>
						<p>
							Las presentes Condiciones Generales de Uso, Política de Privacidad y Venta (en adelante, las "Condiciones Generales") regulan el uso del sitio web www.NOMBRE-TIENDA.com (en adelante, el Sitio Web) que Taiwan Trade Investment, S.L. (en adelante "NOMBRE_TIENDA"), pone a disposición de las personas que accedan a su Sitio Web con el fin de proporcionales información sobre productos y servicios, propios y/o de terceros colaboradores, y facilitarles el acceso a los mismos, así como la contratación de servicios y bienes por medio de la misma (todo ello denominado conjuntamente los "Servicios").

							NOMBRE_TIENDA, con domicilio social en Calle Pintores, 2 D.102.3 28923 Alcorcón (Madrid) , es una sociedad de responsabilidad limitada española titular del presente Sitio Web cuya utilización se regula mediante este documento, con CIF número B-85844033 e inscrita en el Registro Mercantil de Madrid al Tomo 27.335, Hoja M-492.541, Folio 89, Sección 8, inscripción primera. Para contactar con NOMBRE_TIENDA, puede utilizar la dirección de correo postal arriba indicada, así como la dirección de correo electrónica contacto@NOMBRE-TIENDA.com.
							Por la propia naturaleza del Sitio Web, así como de su contenido y finalidad, la práctica totalidad de la navegación que se puede llevar a cabo por el mismo ha de hacerse gozando de la condición de Cliente, la cual se adquiere según los procedimientos recogidos en la misma. Por lo tanto, la citada condición de Cliente supone la adhesión a las Condiciones Generales en la versión publicada en el momento en que se acceda al Sitio Web. NOMBRE_TIENDA se reserva el derecho de modificar, en cualquier momento, la presentación y configuración del Sitio Web, así como las presentes Condiciones Generales. Por ello, NOMBRE_TIENDA recomienda al Cliente leer el mismo atentamente cada vez que acceda al Sitio Web.

							En cualquier caso, existen páginas del Sitio Web accesibles al público en general, respecto a las cuales NOMBRE_TIENDA también desea cumplir con sus obligaciones legales, así como regular el uso de las mismas. En este sentido, los usuarios que accedan a estas partes del Sitio Web aceptan quedar sometidos, por el hecho de acceder a las citadas páginas, por los términos y condiciones recogidos en estas Condiciones Generales, en la medida que ello les pueda ser de aplicación.

							Por último, por la naturaleza propia del presente Sitio Web, es posible que se modifiquen o incluyan cambios en el contenido de las presentes Condiciones Generales. Por esto, el Cliente, así como otros usuarios que no gocen de esta condición, quedan obligados a acceder a las presente Condiciones Generales cada vez que accedan al Sitio Web, asumiendo que les serán de aplicación las condiciones correspondientes que se encuentren vigentes en el momento de su acceso.
						</p>
						<h2>Acceso y Seguridad</h2>
						<p>
							El acceso a los Servicios requiere el registro previo de los usuarios, una vez acepten las Condiciones Generales, pasando a ser considerados como Clientes .

							El identificador del Cliente estará compuesto por su dirección de correo electrónico y una contraseña. Para el acceso a la cuenta propia del Cliente, será necesario la inclusión de este identificador, así como de una contraseña que deberá contener como mínimo 4 caracteres.

							El uso de la contraseña es personal e intransferible, no estando permitida la cesión, ni siquiera temporal, a terceros. En tal sentido, el Cliente se compromete a hacer un uso diligente y a mantener en secreto la misma, asumiendo toda responsabilidad por las consecuencias de su divulgación a terceros.

							En el supuesto de que el Cliente conozca o sospeche del uso de su contraseña por terceros, deberá modificar la misma de forma inmediata, en el modo en que se recoge en el Sitio Web.
						</p>
						<h2>Utilizacion correcta de los servicios</h2>
						<p>
							El Cliente se obliga a usar los Servicios de forma diligente, correcta y lícita y, en particular, a título meramente enunciativo y no limitativo, se compromete a abstenerse de:

							utilizar los Servicios de forma, con fines o efectos contrarios a la ley, a la moral y a las buenas costumbres generalmente aceptadas o al orden público;
							reproducir o copiar, distribuir, permitir el acceso del público a través de cualquier modalidad de comunicación pública, transformar o modificar los Servicios, a menos que se cuente con la autorización del titular de los correspondientes derechos o ello resulte legalmente permitido;
							realizar cualquier acto que pueda ser considerado una vulneración de cualesquiera derechos de propiedad intelectual o industrial pertenecientes a NOMBRE_TIENDA o a terceros;
							emplear los Servicios y, en particular, la información de cualquier clase obtenida a través del Sitio Web para remitir publicidad, comunicaciones con fines de venta directa o con cualquier otra clase de finalidad comercial, mensajes no solicitados dirigidos a una pluralidad de personas con independencia de su finalidad, así como de comercializar o divulgar de cualquier modo dicha información;
							El Cliente responderá de los daños y perjuicios de toda naturaleza que NOMBRE_TIENDA pueda sufrir, con ocasión o como consecuencia del incumplimiento de cualquiera de las obligaciones anteriormente expuestas así como cualesquiera otras incluidas en las presentes Condiciones Generales y/o las impuestas por la Ley en relación con la utilización del Sitio Web .

							NOMBRE_TIENDA velará en todo momento por el respeto del ordenamiento jurídico vigente, y estará legitimada para interrumpir, a su entera discreción, el Servicio o excluir al Cliente del Sitio Web en caso de presunta comisión, completa o incompleta, de alguno de los delitos o faltas tipificados por el Código Penal vigente, o en caso de observar cualesquiera conductas que a juicio de NOMBRE_TIENDA resulten contrarias a estas Condiciones Generales, las Condiciones Generales de Contratación que operan para este Sitio Web, la Ley, las normas establecidas por NOMBRE_TIENDA o sus colaboradores o puedan perturbar el buen funcionamiento, imagen, credibilidad y/o prestigio de NOMBRE_TIENDA o sus colaboradores.
						</p>
						<h2>Derechos de propiedad</h2>
						<p>
							Todos los contenidos del Sitio Web, tales como textos, gráficos, fotografías, logotipos, iconos, imágenes, así como el diseño gráfico, código fuente y software, son de la exclusiva propiedad de NOMBRE_TIENDA o de terceros, cuyos derechos al respecto ostenta legítimamente NOMBRE_TIENDA, estando por lo tanto protegidos por la legislación nacional e internacional.

							Queda estrictamente prohibido la utilización de todos los elementos objeto de propiedad industrial e intelectual con fines comerciales así como su distribución, modificación, alteración o descompilación.

							La infracción de cualquiera de los citados derechos puede constituir una vulneración de las presentes disposiciones, así como un delito castigado de acuerdo con los artículos 270 y siguientes del Código Penal.

							Aquellos Clientes que envíen al Sitio Web observaciones, opiniones o comentarios por medio del servicio de correo electrónico o por cualquier otro medio, en los casos en los que por la naturaleza de los Servicios ello sea posible, se entiende que autorizan a NOMBRE_TIENDA para la reproducción, distribución, comunicación pública, transformación, y el ejercicio de cualquier otro derecho de explotación, de tales observaciones, opiniones o comentarios, por todo el tiempo de protección de derecho de autor que esté previsto legalmente y sin limitación territorial. Asimismo, se entiende que esta autorización se hace a título gratuito.

							Las reclamaciones que pudieran interponerse por los Clientes en relación con posibles incumplimientos de los derechos de propiedad intelectual o industrial sobre cualesquiera de los Servicios de este Sitio Web deberán dirigirse a la siguiente dirección de correo electrónico: contacto@NOMBRE-TIENDA.com.
						</p>
						<h2>Exclusión de garantias y de propiedad</h2>
						<p>
							Con independencia de lo establecido en las Condiciones Generales de Contratación relativas a la contratación de bienes recogidas en el presente Sitio Web, NOMBRE_TIENDA no se hace responsable de la veracidad, exactitud y calidad del presente Sitio Web, sus servicios, información y materiales. Dichos servicios, información y materiales son presentados "tal cual" y son accesibles sin garantías de ninguna clase.

							NOMBRE_TIENDA se reserva el derecho a interrumpir el acceso al Sitio Web, así como la prestación de cualquiera o de todos los Servicios que se prestan a través del mismo en cualquier momento y sin previo aviso, ya sea por motivos técnicos, de seguridad, de control, de mantenimiento, por fallos de suministro eléctrico o por cualquier otra causa justificada.

							En consecuencia, NOMBRE_TIENDA no garantiza la fiabilidad, la disponibilidad ni la continuidad de su Sitio Web ni de los Servicios, por lo que la utilización de los mismos por parte del Cliente se lleva a cabo por su propia cuenta y riesgo, sin que, en ningún momento, puedan exigirse responsabilidades a NOMBRE_TIENDA en este sentido.

							NOMBRE_TIENDA no será responsable en caso de que existan interrupciones de los Servicios, demoras, errores, mal funcionamiento del mismo y, en general, demás inconvenientes que tengan su origen en causas que escapan del control de NOMBRE_TIENDA, y/o debida a una actuación dolosa o culposa del Cliente y/o tenga por origen causas de caso fortuito o fuerza Mayor. Sin perjuicio de lo establecido en el artículo 1105 del Código Civil, se entenderán incluidos en el concepto de Fuerza Mayor, además, y a los efectos de las presentes Condiciones Generales, todos aquellos acontecimientos acaecidos fuera del control de NOMBRE_TIENDA, tales como: fallo de terceros, operadores o compañías de servicios, actos de Gobierno, falta de acceso a redes de terceros, actos u omisiones de las Autoridades Públicas, aquellos otros producidos como consecuencia de fenómenos naturales, apagones, etc y el ataque de hackers o terceros especializados en la seguridad o integridad del sistema informático, siempre que NOMBRE_TIENDA haya adoptado las medidas de seguridad razonables de acuerdo con el estado de la técnica. En cualquier caso, sea cual fuere su causa, NOMBRE_TIENDA no asumirá responsabilidad alguna ya sea por daños directos o indirectos, daño emergente y/o por lucro cesante.

							NOMBRE_TIENDA excluye cualquier responsabilidad por los daños y perjuicios de toda naturaleza que puedan deberse a la falta de veracidad, exactitud, exhaustividad y/o actualidad de los Servicios transmitidos, difundidos, almacenados, puestos a disposición o recibidos, obtenidos o a los que se haya accedido a través del Sitio Web así como por los Servicios prestados u ofertados por terceras personas o entidades. NOMBRE_TIENDA tratará en la medida de lo posible de actualizar y rectificar aquella información alojada en su Sitio Web que no cumpla con las mínimas garantías de veracidad. No obstante quedará exonerada de responsabilidad por su no actualización o rectificación así como por los contenidos e informaciones vertidos en la misma. En este sentido, NOMBRE_TIENDA no tiene obligación de controlar y no controla los contenidos transmitidos, difundidos o puestos a disposición de terceros por los Clientes o colaboradores, salvo los supuestos en que así lo exija la legislación vigente o cuando sea requerido por una Autoridad Judicial o Administrativa competente.

							De igual modo, NOMBRE_TIENDA excluye cualquier responsabilidad por los daños y perjuicios de toda clase que puedan deberse a la presencia de virus o a la presencia de otros elementos lesivos en los contenidos que puedan producir alteración en los sistemas informáticos así como en los documentos o sistemas almacenados en los mismos.

							NOMBRE_TIENDA no se hace responsable por la utilización que el Cliente realice de los Servicios del Sitio Web ni de sus contraseñas, así como de cualquier otro material del mismo, infringiendo los derechos de propiedad intelectual o industrial o cualquier otro derecho de terceros.

							El Cliente se obliga a mantener indemne a NOMBRE_TIENDA, por cualquier daño, perjuicio, sanción, gasto (incluyendo, sin limitación, honorarios de abogados) o responsabilidad civil, administrativa o de cualquier otra índole, que pudiera sufrir NOMBRE_TIENDA que guarde relación con el incumplimiento o cumplimiento parcial o defectuoso por su parte de lo establecido en las presentes Condiciones Generales o en la legislación aplicable, y, en especial, en relación con sus obligaciones relativas a protección de datos de carácter personal recogidas en las presentes condiciones o establecidas en la LOPD y normativa de desarrollo.
						</p>
						<h2>Enlaces de otros sitios web</h2>
						<p>
							NOMBRE_TIENDA no garantiza ni asume ningún tipo de responsabilidad por los daños y perjuicios sufridos por el acceso a Servicios de terceros a través de conexiones, vínculos o links de los sitios enlazados ni sobre la exactitud o fiabilidad de los mismos. La función de los enlaces que aparecen en NOMBRE_TIENDA es exclusivamente la de informar al Cliente sobre la existencia de otras fuentes de información en Internet, donde podrá ampliar los Servicios ofrecidos por el Portal. NOMBRE_TIENDA no será en ningún caso responsable del resultado obtenido a través de dichos enlaces o de las consecuencias que se deriven del acceso por los Clientes a los mismos. Estos Servicios de terceros son proporcionados por éstos, por lo que NOMBRE_TIENDA no puede controlar y no controla la licitud de los Servicios ni su calidad. En consecuencia, el Cliente debe extremar la prudencia en la valoración y utilización de la información y servicios existentes en los contenidos de terceros.
						</p>
						<h2>Ley aplicable y jurisdicción</h2>
						<p>
							Para cuantas cuestiones interpretativas o litigiosas que pudieran plantearse será de aplicación la legislación española y en caso de controversia, ambas partes acuerdan someterse, con renuncia a cualquier otro fuero que pudiera corresponderle, a la jurisdicción de los Juzgados y Tribunales de la ciudad de Madrid.
						</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
					</div>
				</div>
		  </div>
	</div>
</body>
</html>