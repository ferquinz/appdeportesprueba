<?php require_once("config.inc.php"); ?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="es"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="es"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="es"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="es"> <!--<![endif]-->
<head>
	<meta charset="UTF-8">
	
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<link rel="shortcut icon" href="images/Logos/LogoV2.jpg" type="image/png" />
	<title>AppdeportesPrueba</title>
	
	<meta http-equiv="PRAGMA" content="NO-CACHE">
	<meta http-equiv="EXPIRES" content="-1">
	
	<link type="text/css" rel="stylesheet" media="all" href="css/estilos.css">
	<!-- Bootstrap -->
	<link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/Estilo.css"> 
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="js/bootstrap/bootstrap.js"></script>
</head>
	
<body class="selectCalendario">
	<div id='cssmenu'>
		<ul>	   
		   <li><a href='deletesession.php'>Desconexión</a></li>
		   <li class='active'><a href='index.php'>Home</a></li>
		</ul>
	</div>

	<!-- 
		Comprueba si esta conectado 
	-->
	<?php 
		include('Formato/conexionsql.php');
		if(!isset($_SESSION)) 
		{ 
			session_start(); 
		}  	
		if(!isset($_SESSION['conectado']) || $_SESSION['conectado']!=1){  
			header ("Location: login.php");
		}			
		
		if(!isset($_SESSION['id_team'])){  
			header ("Location: index.php");
		}	
	?>
	<div id="page_calendar">
		<div class="row">
			<!--
				CALENDARIO
			-->
			<div class="col-xs-6 col-sm-4 col-md-2">
				<a href="#myModal" data-toggle="modal">
					<img src='images/icons/calendar.png' style="height: 150px;">
				</a>
			</div>
			
			<div class="col-xs-6 col-sm-4 col-md-6">
			
			</div>
			<!--
				TABLA JUGADORES E IMAGENES
			-->
			<div id="list_players" class="col-xs-6 col-md-6">	
				<?php
					$sql = "select customersweb.img_path AS img_trainer, team.img_path AS img_team from team 
					left join customersweb_team on customersweb_team.id_team = team.id_team
					left join customersweb on customersweb.id_customer = customersweb_team.id_customer
					where customersweb.mister = 1 AND team.id_team=".$_SESSION['id_team'] ;	
					
					foreach ($db->query($sql) as $row)
					{		
						if($row['img_trainer']==""){
							echo("	<div id='list_head'>
										<div id='img_coach'>
											<img src='images/mary-poppins1.jpg' class='img-circle'>
										</div>
										<div id='img_team'>
											<img src='".$row['img_team']."' class='img-circle'>
										</div>			
									</div>");
						}else{
							echo("	<div id='list_head'>
										<div id='img_coach'>
											<img src='".$row['img_trainer']."' class='img-circle'>
										</div>
										<div id='img_team'>
											<img src='".$row['img_team']."' class='img-circle'>
										</div>			
									</div>");
						}									
					}	
			
					$sql = "SELECT img_path, username, player_position.name as posicion, dorsal, customersweb.id_customer as id_player
							FROM customersweb
							LEFT JOIN customersweb_players ON customersweb.id_customer = customersweb_players.id_customer
							LEFT JOIN customersweb_team ON customersweb_team.id_customer = customersweb.id_customer
							LEFT JOIN player_position ON customersweb_players.position_id = player_position.id_position
							WHERE mister = 0 AND id_team =".$_SESSION['id_team'] ;	
					echo("<div id='players'>
								<table class='table'>
									<tr>
										<td>
											<table class='table' style='margin-bottom: 0px !important;'>
												<tr class='info'>
													<td>Imagen</td>
													<td>Nombre</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
									<td>
									<div style='height: 600px; overflow: auto;'>
										<table class='table table-bordered'>");
					foreach ($db->query($sql) as $row)
					{		
						echo("	
								<tr class='active'>
									<td>
										<a href='grafica.php?id_player=".$row['id_player']."&mes=".date("n")."&anio=".date('Y')."'>
											<img src='".$row['img_path']."' style='height: 100px;' class='img-circle'>
										</a>
									</td>
									<td style='text-align: center;  vertical-align: middle;'>
										".$row['username']."
									</td>
								</tr>
							");				
												
					}
					echo("</table>
						</div>
						</td>
						</tr>
						</table>
					</div>");			
				?>				
			</div>
		</div>
	</div>
	<?php include 'Formato/piepag.php' ?>	
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/localization/messages_es.js "></script>
		
	<script>
	function generar_calendario(mes,anio){
		var agenda=$(".cal");
		agenda.html("<img src='images/loading.gif'>");
		$.ajax({
			type: "GET",
			url: "ajax_calendario.php",
			cache: false,
			data: { mes:mes,anio:anio,accion:"generar_calendario" }
		}).done(function( respuesta ) 
		{
			agenda.html(respuesta);
		});
	}
		
	function formatDate (input) {
		var datePart = input.match(/\d+/g),
		year = datePart[0].substring(2),
		month = datePart[1], day = datePart[2];
		return day+'-'+month+'-'+year;
	}
		
	$(document).ready(function(){
		/* GENERAMOS CALENDARIO CON FECHA DE HOY */
		generar_calendario("<?php if (isset($_GET["mes"])) echo $_GET["mes"]; ?>","<?php if (isset($_GET["anio"])) echo $_GET["anio"]; ?>");
		
		
		/* AGREGAR UN EVENTO */
		$(document).on("click",'a.add',function(e) 
		{
			e.preventDefault();
			var id = $(this).data('evento');
			var fecha = $(this).attr('rel');
			
			//$('#mask').fadeIn(1000).html("<div id='nuevo_evento' class='window' rel='"+fecha+"'>Agregar un evento el "+formatDate(fecha)+"</h2><a href='#' class='close' rel='"+fecha+"'>&nbsp;</a><div id='respuesta_form'></div><form class='formeventos'><input type='text' name='title' id='title' class='required'><input type='text' name='place' id='place' class='required'><input type='text' name='hour_training' id='hour_training' class='required'><input type='text' name='evento_titulo' id='evento_titulo' class='required'><input type='button' name='Enviar' value='Guardar' class='enviar'><input type='hidden' name='evento_fecha' id='evento_fecha' value='"+fecha+"'></form></div>");
			$('#mask').fadeIn(1000).html(
			"<div id='nuevo_evento' class='window' rel='"+fecha
			+"'>Agregar un evento el "+formatDate(fecha)+"</h2><a href='#' class='close' rel='"+fecha+"'>&nbsp;</a>"
			+"<div id='respuesta_form'></div>"
			+"<form class='formeventos'>"
			+"<p>	<label>Título:</label><input type='text' name='title' id='title' class='required'></p>"
			+"<p><label>Lugar:</label><input type='text' name='place' id='place' class='required'></p>"
			+"<p><label>Hora:</label><input type='text' name='hour_training' id='hour_training' class='required'></p>"
			+"<p><label>Descripción:</label><input type='text' name='evento_titulo' id='evento_titulo' class='required'></p>"
			
			
			
			+"<input type='button' name='Enviar' value='Guardar' class='enviar'>"
			+"<input type='hidden' name='evento_fecha' id='evento_fecha' value='"+fecha+"'></form></div>");
		});
		
		/* LISTAR EVENTOS DEL DIA */
		$(document).on("click",'a.modal',function(e) 
		{
			e.preventDefault();
			var fecha = $(this).attr('rel');
			
			$('#mask').fadeIn(1000).html("<div id='nuevo_evento' class='window' rel='"+fecha+"'>Eventos del "+formatDate(fecha)+"</h2><a href='#' class='close' rel='"+fecha+"'>&nbsp;</a><div id='respuesta'></div><div id='respuesta_form'></div></div>");
			$.ajax({
				type: "GET",
				url: "ajax_calendario.php",
				cache: false,
				data: { fecha:fecha,accion:"listar_evento" }
			}).done(function( respuesta ) 
			{
				$("#respuesta_form").html(respuesta);
			});
		
		});
	
		$(document).on("click",'.close',function (e) 
		{
			e.preventDefault();
			$('#mask').fadeOut();
			setTimeout(function() 
			{ 
				var fecha=$(".window").attr("rel");
				var fechacal=fecha.split("-");
				generar_calendario(fechacal[1],fechacal[0]);
			}, 500);
		});
	
		//guardar evento
		$(document).on("click",'.enviar',function (e) 
		{
			e.preventDefault();
			if ($("#evento_titulo").valid()==true)
			{
				$("#respuesta_form").html("<img src='images/loading.gif'>");
				var title=$("#title").val();
				var place=$("#place").val();
				var hour_training=$("#hour_training").val();
				var evento=$("#evento_titulo").val();
				var fecha=$("#evento_fecha").val();
				$.ajax({
					type: "GET",
					url: "ajax_calendario.php",
					cache: false,
					data: { title:title, place:place, hour_training:hour_training, evento:evento,fecha:fecha,accion:"guardar_evento" }
				}).done(function( respuesta2 ) 
				{
					$("#respuesta_form").html(respuesta2);
					$(".formeventos,.close").hide();
					setTimeout(function() 
					{ 
						$('#mask').fadeOut('fast');
						var fechacal=fecha.split("-");
						generar_calendario(fechacal[1],fechacal[0]);
					}, 3000);
				});
			}
		});
			
		//eliminar evento
		$(document).on("click",'.eliminar_evento',function (e) 
		{
			e.preventDefault();
			var current_p=$(this);
			$("#respuesta").html("<img src='images/loading.gif'>");
			var id=$(this).attr("rel");
			$.ajax({
				type: "GET",
				url: "ajax_calendario.php",
				cache: false,
				data: { id:id,accion:"borrar_evento" }
			}).done(function( respuesta2 ) 
			{
				$("#respuesta").html(respuesta2);
				current_p.parent("p").fadeOut();
			});
		});
			
		$(document).on("click",".anterior,.siguiente",function(e)
		{
			e.preventDefault();
			var datos=$(this).attr("rel");
			var nueva_fecha=datos.split("-");
			generar_calendario(nueva_fecha[1],nueva_fecha[0]);
		});

	});
</script>

	<!-- 
		Modal Calendario 
	-->
	<div id="myModal" class="modal fade animated rotateInDownLeft" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<a class="cierreCuadroRegistro" id="cierremyModal" data-dismiss="modal" aria-hidden="true"></a>
					<h4 id="myModalLabel">Calendario</h4>
				</div>
				<div class="modal-body">
					<div class="cal"></div><div id="mask"></div>
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>