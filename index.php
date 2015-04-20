<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=7,8,9" />
		
		<link rel="stylesheet" type="text/css" href="css/Estilo.css"> 
		<title>Inicio</title>	  	
		<link href="icons/IconNav23.ico" type="image/x-icon" rel="shortcut icon" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js?ver=1.4.2"></script>

			<!-- Registro jQuery -->
		<script src="js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
		<script src="js/funciones.js" type="text/javascript"></script>
		<script src="js/jquery.smoothdivscroll-1.3-min.js" type="text/javascript"></script>
	
  </head>
    <body class="selectTeam">
	<div id='cssmenu'>
		<ul>	   
		   <li><a href='deletesession.php'>Desconexión</a></li>
		   <li class='active'><a href='index.php'>Home</a></li>
		</ul>
	</div>
	 <?php include 'Formato/conexionsql.php' ?>	
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
	
			echo("<center><table style=' width: 80%'>");
			echo("<tr class='header'>
				<td> Imagen </td>
				<td> Nombre </td>
				<td> Deporte </td>
				<td> Categoria </td>
				<td>  </td>	
				</tr>");	
			foreach ($db->query($sql) as $row)
			{
				echo("<tr>");				
					echo("<td> <img src='".$row['Image']."'></img></td>");	
					echo("<td>".$row['Team']."</td>");	
					echo("<td>".$row['Sport']."</td>");	
					echo("<td>".$row['Category']."</td>");	
					echo("<td> <a href='equipoCalendario.php?team=".$row['TeamId']."'> Ir </a>   </td>");	
				echo("</tr>");			
			}		
			echo("<tr>			
				<!--<form>
					<div id='addTeam' class='register'>
					<input type='submit' id='activator' value='Añadir Equipo' />
					
					</div>		
			     </form>-->
			
					<td class='boton' colspan='5'><a id='activator'> Añadir Equipo </a> </td>
					
				</tr>");
			
			echo("</table></center>");			
		
		?>
		<div class="clear">  </div>	
		
	</div>		
	
		<!-- Menu al pulsar sobre el menu de registro -->
<div class="registro" id="registro" style="display:none;"></div>
<div class="cuadroRegistro" id="cuadroRegistro">
	<a class="cierreCuadroRegistro" id="cierreCuadroRegistro"></a>
	<h1>Añadir Equipo</h1>
	   <!--<form action="" id="camposRegistro" class="registroForm" name="formulario"  method="post" onsubmit="return RegisterForm()">-->
	  <!--<form action="creaequipo.php" id="camposRegistro" class="registroForm" name="formulario"  method="post">-->

	   <form action="creaequipo.php" id="camposRegistro" class="registroForm" name="formulario"  method="post" enctype="multipart/form-data">
	   
				<p>
				  <label for="login">Imagen:</label>
					<input type="file" name="archivo" /> 								
				</p>
				<p>
				  <label for="login">Nombre:</label>
				  <input type="text" class="input" value="Nombre" name="nombre" onFocus="if (this.value=='Nombre') this.value='';">
				</p>
				
				<p>
				  <label for="login">Id Equipo:</label>
				  <input type="text" class="input" value="Id" name="idname" onFocus="if (this.value=='Id') this.value='';">
				</p>
				
				<p>
				  <label for="password">Contraseña:</label>
				  <input type="password" class="password" name="passPrueba">
				</p>
				<p>
				  <label for="password">Confirmación:</label>
				  <input type="password" class="password" name="pass">
				</p>
				<p>
				  <label for="password">Deporte:</label>
				  <!--<input type="text" class="input" value="Deporte" name="deporte" onFocus="if (this.value=='Deporte') this.value='';">-->
				  <SELECT name="cmbdeporte" id="cmbdeporte" onchange="cargaCategorias(this.id);"> 					
										
						<?php
							$sql = "select name, id_sport from sport" ;	
							
							foreach ($db->query($sql) as $row)
							{						
								$id_sport=$row['id_sport'];
								echo("<option value='".$id_sport."'>".$row['name']."</option>");								
							}		
						?>		 										
					</SELECT> 				
				</p>
				
				<p>
				  <label for="password">Categoría:</label>
				  <!--<input type="text" class="input" value="Deporte" name="deporte" onFocus="if (this.value=='Deporte') this.value='';">-->
				   <!--<SELECT name="categoria"> 									
						// <?php
							// $sql = "select name, id_category from category" ;	
							
							// foreach ($db->query($sql) as $row)
							// {						
								// $id_category=$row['id_category'];
								// echo("<option value='".$id_category."'>".$row['name']."</option>");								
							// }		
						// ?>		 										
					</SELECT>-->
					<select name="cmbcategoria" id="cmbcategoria">
						<option value='0'>Seleccione Categoria</option>
					</select>
				</p>				
						
										
				
					<div id="acceptRegister">
						<input type="submit" id="activator" value="Aceptar" >					
					</div>			 
				
						
				
				<!--<div> <input type="submit" value="Aceptar" class="button"> </div>-->
		
		</form>			

</div>	
		<script type="text/javascript">
		
		document.getElementById("cmbdeporte").selectedIndex = "-1";
		
		function nuevoAjax(){ 
				/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
				lo que se puede copiar tal como esta aqui */
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
			 
		/*function cargaCategorias(idSelectOrigen){
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
			}
			// Compruebo que el select modificado no sea el ultimo de la cadena
			else{
				
				if(idSelectOrigen == "cmbdeporte")
					var selectDestino=document.getElementById("cmbcategoria");
				// Creo el nuevo objeto AJAX y envio al servidor la opcion seleccionada del select origen
				var ajax=nuevoAjax();
				ajax.open("GET", "llena_categorias.php?opcion="+opcionSeleccionada+"&select="+idSelectOrigen, true);
				
				ajax.onreadystatechange=function() 
				{ 
				
					if (ajax.readyState==1)
					{
						// Mientras carga elimino la opcion "Selecciona Opcion..." y pongo una que dice "Cargando..."
						selectDestino.length=0;
						var nuevaOpcion=document.createElement("option"); 
						nuevaOpcion.value=0; 
						nuevaOpcion.innerHTML="Cargando...";
						selectDestino.appendChild(nuevaOpcion); 
						selectDestino.disabled=true;    
					}
					if (ajax.readyState==4)
					{
						selectDestino.parentNode.innerHTML=ajax.responseText;
					} 
				}
				ajax.send(null);
			}
		}*/
		
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
				   
                  //  var precioPeli='<?php echo$precio;?>'          
                    <!--Escribimos la direccion que contiene el contenido que deseamos actualizar -->  			
                    xmlhttp.open("GET","llena_categorias.php?opcion="+opcionSeleccionada+"&select="+idSelectOrigen, true);

                    xmlhttp.send();              
                    
               }  
		}
					
		</script>	
		
	</body>
</html>
