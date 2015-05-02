<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=7,8,9" />
	
	<link rel="stylesheet" type="text/css" href="css/Estilo.css"> 
	<!-- Bootstrap -->
	<link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
	<link href="css/fontello/fontello.css" rel="stylesheet">
	<title>Inicio</title>	  	
	<link href="icons/IconNav23.ico" type="image/x-icon" rel="shortcut icon" />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="js/bootstrap/bootstrap.js"></script>
		<!-- Registro jQuery -->
	<script src="js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
	<script src="js/funciones.js" type="text/javascript"></script>
	<script src="js/jquery.smoothdivscroll-1.3-min.js" type="text/javascript"></script>

</head>

<script type="text/javascript">

	function registerTeam(){
	
		var file = document.forms["formulario"]["archivo"].value;
		var name=document.forms["formulario"]["nombre"].value;
		var idname=document.forms["formulario"]["idname"].value;
		var pass = document.forms["formulario"]["passPrueba"].value;
		var passConfirm = document.forms["formulario"]["pass"].value;
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
			$.ajax({
				url : "creaequipo.php",
				type: 'POST',
				data: { nombre: name , idname: idname , cmbdeporte: deporte , cmbcategoria: categoria , password: pass, imagen: file } ,
				dataType: 'json',	
				async: false,				
				success: function(data, textStatus, jqXHR)
				{	
					alert(data.data);
					if(!data.success){
						alert(data.data);
						resultado = false;
					}else {
						console.log(jqXHR.status);
						resultado = true;
					}
				},
				error: function (xhr, status, error){
					alert("Error");
					alert(error);
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
	}

</script>	

<body class="selectTeam">
	<div id='cssmenu'>
		<ul>	   
		   <li><a href='deletesession.php'>Desconexión</a></li>
		   <li class='active'><a href='index.php'>Home</a></li>
		</ul>
	</div>
	<?php include 'Formato/conexionsql.php' ?>
	<!--
		TABLA LISTA EQUIPOS
	-->
	<div id="listaEquipos">
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

			echo("<center><table style=' width: 80%' class='table table-hover'>");
			echo("<tr class='header'>
				<td> Imagen </td>
				<td> Nombre </td>
				<td> Deporte </td>
				<td> Categoria </td>
				<td>  </td>	
				</tr>");	
			foreach ($db->query($sql) as $row)
			{
				echo("<tr class='active'>");				
					echo("<td> <img src='".$row['Image']."'></img></td>");	
					echo("<td>".$row['Team']."</td>");	
					echo("<td>".$row['Sport']."</td>");	
					echo("<td>".$row['Category']."</td>");	
					echo("<td> <a href='equipoCalendario.php?team=".$row['TeamId']."' > <i class='icon-forward'></i> </a>   </td>");	
				echo("</tr>");			
			}		
			echo("<tr>					
					<td class='boton' colspan='5'><a id='activator'> Añadir Equipo </a> </td>
				</tr>");
			
			echo("</table></center>");			
		?>
		<div class="clear">  </div>			
	</div>		
	
	<!-- Menu al pulsar sobre el menu de registro -->
	<div class="registro" id="registro" style="display:none;"></div>
	
	<!--
		CUADRO REGISTRO EQUIPO
	-->
	<div class="cuadroRegistro" id="cuadroRegistro">
		<a class="cierreCuadroRegistro" id="cierreCuadroRegistro"></a>
		<h1>Añadir Equipo</h1>
		<form action="" class="form-horizontal" name="formulario">
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
					<input type="password" class="form-control" name="pass" placeholder="Confirmacion contraseña" value="">
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
					<input type="submit" id="activator" class="btn btn-primary" value="Aceptar" onclick="return registerTeam();">
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
</body>
</html>
