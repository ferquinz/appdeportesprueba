<!DOCTYPE html>
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>
<html>
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="images/Logos/LogoV2.jpg" type="image/png" />
	<title>Monitorizando Lab</title>
	<link rel="stylesheet" type="text/css" href="css/Estilo.css"> 
	<!-- Bootstrap -->
	<link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
	<link href="css/fontello/fontello.css" rel="stylesheet">  	
	<link href="icons/IconNav23.ico" type="image/x-icon" rel="shortcut icon" />
	
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="js/bootstrap/bootstrap.js"></script>
	<!-- Registro jQuery -->
	<script src="js/funciones.js" type="text/javascript"></script>
	<!-- <script src="js/jquery.smoothdivscroll-1.3-min.js" type="text/javascript"></script> -->

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="js/fancybox/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
	
	<!-- Bootstrap Dialog -->
	<link href="css/bootstrap/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
	<script src="js/bootstrap/bootstrap-dialog.min.js"></script>
	
</head>

<script type="text/javascript">
$(document).ready(function () {

	$("#formulario").submit(function (event) {

		var file = document.forms["formulario"]["archivo"].value;
		var name=document.forms["formulario"]["nombre"].value;
		var idname=document.forms["formulario"]["idname"].value;
		var pass = document.forms["formulario"]["passPrueba"].value;
		var passConfirm = document.forms["formulario"]["password"].value;
		var deporte=document.forms["formulario"]["cmbdeporte"].value;
		var categoria=document.forms["formulario"]["cmbcategoria"].value;
		var error = 0;
		
		document.getElementById("divnombreequipo").className = "form-group";
		if (name.length<1){
			document.formulario.nombre.placeholder = "Falta el nombre";
			document.getElementById("divnombreequipo").className += " has-error";
			error = 1;
		}
		document.getElementById("dividequipo").className = "form-group";
		if (idname.length<1){
			document.formulario.idname.placeholder = "Falta el id del equipo";
			document.getElementById("dividequipo").className += " has-error";
			error = 1;
		}
		/* Comprobamos la contraseña */
		document.getElementById("divpassPruebaequipo").className = "form-group";
		document.getElementById("divpassequipo").className = "form-group";
		var alfaNum = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		if (pass.length<8 || passConfirm.length<8){
			document.formulario.passPrueba.placeholder = "La contraseña debe tener al menos 8 caracteres";
			document.getElementById("divpassPruebaequipo").className += " has-error";
			document.getElementById("divpassequipo").className += " has-error";
			error = 1;
		}
		else if(pass.indexOf(' ')== 0){
			document.formulario.passPrueba.placeholder = "La contraseña no puede contener espacios";
			document.getElementById("divpassPruebaequipo").className += " has-error";
			error = 1;                       
		}
		else if(pass.localeCompare(passConfirm)){ /*Las dos contraseñas introducidas tienen que coincidir*/
			document.formulario.pass.placeholder = "La contraseña no coincide";
			document.getElementById("divpassequipo").className += " has-error";
			error = 1;
		}
		else{
			for(var i=0; i<pass.length;i++){ /*si hay algun caracter que no sea alfanumerico devuelve error*/
				if(alfaNum.indexOf(pass.charAt(i))==-1){
					document.formulario.passPrueba.placeholder = "La contraseña debe tener caracteres alfanumericos";
					document.getElementById("divpassPruebaequipo").className += " has-error";
					error = 1;                            
				}
			}  
		}
		document.getElementById("divdeporteequipo").className = "form-group";
		if (deporte.length<1){
			document.getElementById("divdeporteequipo").className += " has-error";
			error = 1;
		}
		document.getElementById("divcategoriaequipo").className = "form-group";
		if (categoria.length<1 || categoria == 0){
			document.getElementById("divcategoriaequipo").className += " has-error";
			error = 1;
		}
		
		var resultado = false;

		if (error == 0) {
			 //disable the default form submission
			event.preventDefault();
			
			var $form    = $(event.target),
                formData = new FormData(),
                params   = $form.serializeArray(),
                files    = $form.find('[name="archivo"]')[0].files;

            $.each(files, function(i, file) {
                // Prefix the name of uploaded files with "uploadedFiles-"
                // Of course, you can change it to any string
                //formData.append('uploadedFiles-' + i, file);
				formData.append('archivo', file);
            });

            $.each(params, function(i, val) {
                formData.append(val.name, val.value);
            });
			
			$.ajax({
				url : "creaequipo.php",
				type: 'POST',
				data: formData,
				dataType: 'json',	
				async: false,	
				contentType: false,
				processData: false,				
				success: function(data, textStatus, jqXHR)
				{	
					if(!data.success){
						mostrarModal(data.data,2);
						resultado = false;
					}else {
						console.log(jqXHR.status);
						resultado = true;
					}
				},
				error: function (xhr, status, error){
					mostrarModal(error,2);
					resultado = false;
				}
			});
		}
		if(resultado){
			window.location.reload();
			window.location.href = "index.php";
			return false;
		}
		return resultado;
	});
	
	$(".fancybox").fancybox({
			width       : 400,
			height      : 400,
			minWidth	: 400,
			minHeight	: 400,
			aspectRatio : true
	});
	
	$('body').on('click','#eliminar',function () {
		var data_id = '';
		if (typeof $(this).data('id') !== 'undefined') {
			data_id = $(this).data('id');
		}
		document.getElementById("EquipoId").value = data_id;
	})
		
});

	function eliminarEquipo(){
	
		var resultado = false;
		$.ajax({
			url : "deleteTeam.php",
			type: 'POST',
			data: { team: document.getElementById("EquipoId").value} ,
			dataType: 'json',	
			async: false,				
			success: function(data, textStatus, jqXHR)
			{	
				if(!data.success){
					mostrarModal(data.data,2);
					resultado = false;
				}else {
					console.log(jqXHR.status);
					resultado = true;
				}
			},
			error: function (xhr, status, error){
				mostrarModal(error,2);
				resultado = false;
			}
		});
		
		if(resultado){
			$('#myModal').modal('hide');
			window.location.reload();
			return false;
		}

		return resultado;
	}
	
	function mostrarModal(mensaje, tipo){
		var types;
		var titulo;
		if (tipo == 1){
			types = BootstrapDialog.TYPE_SUCCESS;
			titulo = "";
		}
		else{
			types = BootstrapDialog.TYPE_DANGER;
			titulo = "<span class='glyphicon glyphicon-exclamation-sign gi-2x'> ERROR</span>";
		}
		// var types = [BootstrapDialog.TYPE_DEFAULT, 
					 // BootstrapDialog.TYPE_INFO, 
					 // BootstrapDialog.TYPE_PRIMARY, 
					 // BootstrapDialog.TYPE_SUCCESS, 
					 // BootstrapDialog.TYPE_WARNING, 
					 // BootstrapDialog.TYPE_DANGER];

		BootstrapDialog.show({
			type: types,
			title: titulo,
			message: mensaje
			// buttons: [{
				// label: 'Aceptar'
			// }]
		});     

	}

</script>	

<body class="selectTeam">
	<input type="hidden" id="EquipoId" value="">
	<div class="col-xs-12 col-sm-12 col-md-12" id='cssmenu'>
		<ul>	   
		   <li><a href='deletesession.php'>Desconexión</a></li>
		   <li><a href='configuracion.php'>Configuración</a></li>
		   <li class='active'><a href='index.php'>Home</a></li>
		</ul>
	</div>
	<?php include 'Formato/conexionsql.php' ?>
	<!--
		TABLA LISTA EQUIPOS
	-->
	<div class="col-xs-12 col-sm-12 col-md-12" id="listaEquipos">
		<?php	
			//Comprueba si esta conectado
			if(!isset($_SESSION)) 
			{ 
				session_start(); 
			}  	
			if(!isset($_SESSION['conectado']) || $_SESSION['conectado']!=1){  
				header ("Location: login.php");
			}		
		
			$sql = "select team.img_path as Image, team.name as Team, team.id_team as TeamId, category.name as Category, sport.name as Sport from team
					left join sport on sport.id_sport = team.id_sport
					left join category on category.id_category = team.id_category
					left join customersweb_team on customersweb_team.id_team = team.id_team
					left join customersweb on customersweb.id_customer = customersweb_team.id_customer
					where customersweb.id_customer = ".$_SESSION['id_customer'] ;

			
echo("<div class='col-md-8 col-md-offset-2' style='margin-top: 5%;'>
	<table class='table table-hover' width='325'>
		<tr>
			<td>
			   <table class='table table-hover'>
				 <tr class='header'>
					<td> Imagen </td>
					<td> Nombre </td>
					<td> Deporte </td>
					<td> Categoria </td>
					<td>  </td>	
				 </tr>
			   </table>
			</td>
	    </tr>
		<tr>
			<td>
			   <div style='width:100%; height:480px; overflow:auto;'>
				 <table class='table table-hover' >");
				   foreach ($db->query($sql) as $row)
					{
						$valores=explode('/',$row['Image']);
						$valores[count($valores)-1] = "Original_".$valores[count($valores)-1];
						$originalImage = implode("/", $valores);
						echo("<tr class='active'>");				
							echo("<td> 
									<a class='fancybox' href='".$originalImage."' title='Foto de equipo' >
										<img src='".$row['Image']."'></img>
									<a>
								</td>");	
							echo("<td>".$row['Team']."</td>");	
							echo("<td>".$row['Sport']."</td>");	
							echo("<td>".$row['Category']."</td>");	
							echo("<td> 
									<a id='eliminar' href='#myModal' data-toggle='modal' data-id='".$row['TeamId']."' > <i class='icon-cancel'></i> </a>
									<a href='equipoCalendario.php?team=".$row['TeamId']."' > <i class='icon-forward'></i> </a>   
									</td>");	
						echo("</tr>");			
					}		
			echo("</table>
				<div>
				</td>
			</tr>
					<tr>					
					<td colspan='5'>
						<span class='boton' style='width: 100%; display: block;'>
							<a id='activator'> Añadir Equipo </a>
						</span>
					</td>
				</tr>
				 </table>  
			   </div>
			</td>
		  </tr>
		</table>
		</div>");			
		?>
		<div class="clear">  </div>			
	</div>		
	
	<!-- Menu al pulsar sobre el menu de registro -->
	<div class="registro" id="registro" style="display:none;"></div>
	
	<!--
		CUADRO REGISTRO EQUIPO
	-->
	<div class="cuadroRegistro" id="cuadroRegistro1">
		<a class="cierreCuadroRegistro" id="cierreCuadroRegistro"></a>
		<h1>Añadir Equipo</h1>
		
		<form name="formulario" class="form-horizontal" id="formulario" action="javascript:;" enctype="multipart/form-data" method="post" accept-charset="utf-8">
		<!--<form action="" class="form-horizontal" name="formulario">-->
			<div id="divarchivoequipo" class="form-group">
				<label for="login" class="col-sm-3 control-label">Imagen:</label>
				<div class="col-xs-8">
					<input type="file" name="archivo" />
				</div>
			</div>
			<div id="divnombreequipo" class="form-group">
				<label for="login" class="col-sm-3 control-label">Nombre:</label>
				<div class="col-xs-8">
					<input type="text" class="form-control" value="" name="nombre" placeholder="Nombre">
				</div>
			</div>			
			<div id="dividequipo" class="form-group">
				<label for="login" class="col-sm-3 control-label">Id Equipo:</label>
				<div class="col-xs-8">
					<input type="text" class="form-control" value="" name="idname" placeholder="Identificador del equipo">
				</div>
			</div>
			<div id="divpassPruebaequipo" class="form-group">
				<label for="password" class="col-sm-3 control-label">Contraseña:</label>
				<div class="col-xs-8">
					<input type="password" class="form-control" name="passPrueba" placeholder="Contraseña" value="">
				</div>
			</div>
			<div id="divpassequipo" class="form-group">
				<label for="password" class="col-sm-3 control-label">Confirmación:</label>
				<div class="col-xs-8">
					<input type="password" class="form-control" name="password" placeholder="Confirmacion contraseña" value="">
				</div>
			</div>
			<div id="divdeporteequipo" class="form-group">
				<label for="password" class="col-sm-3 control-label">Deporte:</label>
				<div class="col-xs-8">
					<SELECT name="cmbdeporte" class="combodeporte" id="cmbdeporte" onchange="cargaCategorias(this.id);"> 								
						<?php
							$sql = "select name, id_sport from sport" ;	
							
							foreach ($db->query($sql) as $row)
							{						
								$id_sport=$row['id_sport'];
								echo("<option value='".$id_sport."'>".$row['name']."</option>");								
							}		
						?>		 										
					</SELECT>
				</div>
			</div>
			<div id="divcategoriaequipo" class="form-group">
				<label for="password" class="col-sm-3 control-label">Categoría:</label>
				<div class="col-xs-8">
					<select name="cmbcategoria" class="combodeporte" id="cmbcategoria">
						<option value='0'>Seleccione Categoria</option>
					</select>
				</div>
			</div>					
			<div class="form-group">
				<div class="col-xs-8 col-sm-offset-3">
					<input type="submit" id="activator" class="btn btn-primary" value="Aceptar">
				</div>
			</div>		 
		</form>			
	</div>
<!-- Función para cargar el combo de categorias del registro de equipo -->
<script type="text/javascript">
	
	document.getElementById("cmbdeporte").selectedIndex = "-1";
	function nuevoAjax(){ 
		/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por lo que se puede copiar tal como esta aqui */
		var xmlhttp=false;
		try{
			// Creacion del objeto AJAX para navegadores no IE
			xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e){
			try{
				// Creacion del objet AJAX para IE
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(E){
				if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
			}
		}
		return xmlhttp; 
	}

	function cargaCategorias(idSelectOrigen){
		// Obtengo el select que el usuario modifico
		var selectOrigen=document.getElementById(idSelectOrigen);
		// Obtengo la opcion que el usuario selecciono
		var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;
		// Si el usuario eligio la opcion "Elige", no voy al servidor y pongo los selects siguientes en estado "Selecciona estado..."
		if(opcionSeleccionada==0)
		{
			var selectActual=null;
			if(idSelectOrigen == "cmbdeporte")
				selectActual=document.getElementById("cmbcategoria");
			selectActual.length=0;
			var nuevaOpcion=document.createElement("option"); 
			nuevaOpcion.value=0; 
			nuevaOpcion.innerHTML="Seleccione Deporte";
			selectActual.appendChild(nuevaOpcion);  
			selectActual.disabled=true;
		}else{
			if(idSelectOrigen == "cmbdeporte")
				var selectDestino=document.getElementById("cmbcategoria");			
				var xmlhttp;
				if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				}
				else {// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
			   xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4 && xmlhttp.status==200){
						document.getElementById("cmbcategoria").innerHTML=xmlhttp.responseText;
					}
			   }
						
				<!--Escribimos la direccion que contiene el contenido que deseamos actualizar -->  			
				xmlhttp.open("GET","llena_categorias.php?opcion="+opcionSeleccionada+"&select="+idSelectOrigen, true);
				xmlhttp.send();              			
		   }  
	}
					
</script>	

	<!-- 
		Modal HTML para los terminos y condiciones
	-->
	<div class="modal fade animated bounceIn" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<a class="cierreCuadroRegistro" id="cierrelargeModal" data-dismiss="modal" aria-hidden="true"></a>
						<h4 class="modal-title" id="myModalLabel">Eliminar</h4>
					</div>
					<div class="modal-body">
						<p>
							Estas seguro de querere eliminar el equipo
						</p>
					</div>
					<div class="modal-footer">
						<button id="btnEliminar" class="btn btn-primary" onclick="return eliminarEquipo();">Aceptar</button>
						<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
					</div>
				</div>
		  </div>
	</div>
</body>
</html>
