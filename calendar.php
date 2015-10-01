<!DOCTYPE html>
<?php 
	// require_once("config.inc.php"); 
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/Logos/LogoV2.jpg" type="image/png" />
	<title>Monitorizando Lab</title>
	<link type="text/css" rel="stylesheet" media="all" href="css/estilos.css" />
	<link rel="stylesheet" type="text/css" href="css/Estilo.css" /> 
	
	<!-- Bootstrap -->
	<link href="css/bootstrap/bootstrap.min.css" rel="stylesheet" />
	<link href="css/fontello/fontello.css" rel="stylesheet" />  	
	
	<script src="https://code.jquery.com/jquery-latest.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/localization/messages_es.js "></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="js/bootstrap/bootstrap.js"></script>
	
	<!-- Registro jQuery -->
	<script src="js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
	<script src="js/funciones.js" type="text/javascript"></script>
	<script src="js/jquery.smoothdivscroll-1.3-min.js" type="text/javascript"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="js/fancybox/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
	
	<!-- Bootstrap Dialog -->
	<link href="css/bootstrap/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
	<script src="js/bootstrap/bootstrap-dialog.min.js"></script>

	<!-- Graficos Google -->
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	
	<!-- ScrollBar -->
	<link rel="stylesheet" href="css/malihu/jquery.mCustomScrollbar.css" />
	<script src="js/malihu/jquery.mCustomScrollbar.min.js"></script>
	
	<!--[if lt IE 9]>
	  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<script type="text/javascript">
	
	function eliminarJugador(){
	
		var resultado = false;
		$.ajax({
			url : "deletePlayer.php",
			type: 'POST',
			data: { player: document.getElementById("PlayerId").value} ,
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
			//$('#ModalDelete').modal('hide');
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
	
$(document).ready(function(){

	$(".fancybox").fancybox({
		width       : 400,
		height      : 400,
		minWidth	: 200,
		minHeight	: 200,
		maxWidth	: 600,
		maxHeight	: 600,
		autoResize	: true,
		aspectRatio : true
	})

});

</script>

<script>

  (function($){
    $(window).load(function(){
		$("#tablajugadores").mCustomScrollbar({
			theme:"light-3",
			scrollButtons:{
				enable:true
			}
		});
		$("body").mCustomScrollbar({
			theme:"minimal"
		});
    });
  })(jQuery);
  
</script>
	
<body class="selectCalendario" style="height: 100% !important">
	<input type="hidden" id="PlayerId" value="">
	<header class="col-xs-12 col-sm-12 col-md-12" id='cssmenu'>
		<ul>	   
		   <li><a href='deletesession.php'>Desconexion</a></li>
		   <li><a href='configuracion.php'>Configuracion</a></li>
		   <li class='active'><a href='calendar.php'>Equipo</a></li>
		   <li><a href='index.php'>Home</a></li>
		</ul>
	</header>

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
	<div id="page_calendar" class="col-xs-12 col-sm-12 col-md-12">
			<!--
				CALENDARIO
			-->
			<div class="col-xs-2 col-sm-2 col-md-2">
				<a href="#myModal" data-toggle="modal">
					<img src='images/icons/calendar.png' style="height: 150px;">
				</a>
			</div>
			
			<div class="col-xs-7 col-sm-7 col-md-7">
				<section id = "graficas" style="background: #FFF; margin-top: 5%; margin-bottom: 5%; overflow: auto;" >
					<section class="modal-header" >
						<h4> Graficas </h4>
					</section>
					<section class="modal-body" style="text-align: -webkit-center;">
						<div id="dual_y_div" style="width: 900px; height: 500px;"></div>
					</section>
					<section>
						<hr noshade size=7 width="70%" align=center style="border-top-color: blueviolet;   display: -webkit-inline-box;">
					</section>
					<section class="modal-body" style="text-align: -webkit-center;">
						<div id="chart_div" style="width: 900px; height: 500px;"></div>
					</section>
					<section>
						<hr noshade size=7 width="70%" align=center style="border-top-color: blueviolet;   display: -webkit-inline-box;">
					</section>
					<section class="modal-body" style="text-align: -webkit-center;">
						<div id="chart_div2" style="width: 900px; height: 500px;"></div>
					</section>
				</section>
			</div>
			<!--
				TABLA JUGADORES E IMAGENES
			-->
			<div id="list_players" class="col-xs-3 col-sm-3 col-md-3">	
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
							$valores=explode('/',$row['img_trainer']);
							$valores[count($valores)-1] = "Original_".$valores[count($valores)-1];
							$originalImage = implode("/", $valores);
							
							$valores1=explode('/',$row['img_team']);
							$valores1[count($valores1)-1] = "Original_".$valores1[count($valores1)-1];
							$originalImage1 = implode("/", $valores1);
							
							echo("	<div id='list_head'>
										<div id='img_coach'>
											<a class='fancybox' href='".$originalImage."' title='Foto de entrenador' >
												<img src='".$row['img_trainer']."' class='img-circle'>
											</a>
										</div>
										<div id='img_team'>
											<a class='fancybox' href='".$originalImage1."' title='Foto de equipo' >
												<img src='".$row['img_team']."' class='img-circle'>
											</a>
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
													<td></td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
									<td>
									<div id='tablajugadores' style='height: 600px; overflow: auto;' class='mCustomScrollbar'>
										<table class='table table-bordered'>");
					foreach ($db->query($sql) as $row)
					{		
						$idcustomer = $row['id_player'];
						echo("	
								<tr class='active'>
									<td>
										<a href='grafica.php?id_player=".$idcustomer."&mes=".date("n")."&anio=".date('Y')."'>
											<img src='".$row['img_path']."' style='height: 100px;' class='img-circle'>
										</a>
									</td>
									<td style='text-align: center;  vertical-align: middle;'>
										".$row['username']."
									</td>
									<td style='text-align: center;  vertical-align: middle;'>
										<a id='eliminar' href='#ModalDelete' data-toggle='modal' data-id='".$idcustomer."' > <i class='icon-cancel'></i> </a>
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
		

<!-- 
	Script para el Calendario 
	-->		
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
			
			//$('#mask').fadeIn(1000).html("<div style='border: 6px; border-style: solid;' id='nuevo_evento' class='window' rel='"+fecha+"'>Agregar un evento el "+formatDate(fecha)+"</h2><a href='#' class='close' rel='"+fecha+"'>&nbsp;</a><div id='respuesta_form'></div><form class='formeventos'><input type='text' name='title' id='title' class='required'><input type='text' name='place' id='place' class='required'><input type='text' name='hour_training' id='hour_training' class='required'><input type='text' name='evento_titulo' id='evento_titulo' class='required'><input type='button' name='Enviar' value='Guardar' class='enviar'><input type='hidden' name='evento_fecha' id='evento_fecha' value='"+fecha+"'></form></div>");
			$('#mask').fadeIn(1000).html(
			"<div id='nuevo_evento' class='window' style='border: 6px; border-style: solid;' rel='"+fecha
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
			
			$('#mask').fadeIn(1000).html("<div id='nuevo_evento' class='window' style='border: 6px; border-style: solid;' rel='"+fecha+"'>Eventos del "+formatDate(fecha)+"</h2><a href='#' class='close' rel='"+fecha+"'>&nbsp;</a><div id='respuesta'></div><div id='respuesta_form'></div></div>");
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

		/* Cogemos el id del jugador que deseamos eliminar */
		$('body').on('click','#eliminar',function () {
			var data_id = '';
			if (typeof $(this).data('id') !== 'undefined') {
				data_id = $(this).data('id');
			}
			document.getElementById("PlayerId").value = data_id;
		});

	});

</script>
<!-- 
	Script para el grafico 
-->
<script type="text/javascript">
		
		google.load("visualization", "1.1", {packages:["bar"]});
		google.setOnLoadCallback(drawStuff);

		function drawStuff() {
			var data = new google.visualization.arrayToDataTable(
			[				
				['Fecha', 'Puntuacion', 'Personas']
			<?php
				$flag = 0;
				$mediaequipo = "SELECT AVG(c.calification*TIMESTAMPDIFF(MINUTE, c.start_time, c.end_time)) AS totalCalification,
									CONCAT(CONCAT(DAY(DATE(c.start_time)),'-'), MONTHNAME(DATE(c.start_time))) AS Day,
									COUNT(c.calification) AS Num_Personas
									FROM training_event  a
									LEFT JOIN training_player b ON a.id_training = b.id_training
									LEFT JOIN training_data c ON b.id_training_player = c.id_training_player
									WHERE a.id_team = ".$_SESSION['id_team']." and c.start_time is not null
									AND MONTH(DATE(c.start_time)) = ".date("n")." AND YEAR(DATE(c.start_time)) = ".date('Y')."
									GROUP BY DATE(c.start_time)
									ORDER BY c.start_time";
					
				foreach ($db->query($mediaequipo) as $row)
				{
					$flag = 1;
					$avgTeamCalification = $row['totalCalification'];
					$day = $row['Day'];
					$numpersonas = $row['Num_Personas'];
								
					if($day!=null){
						echo(",['".$day."',".$avgTeamCalification.",".$numpersonas."]");
					}
				}
				
				if ($flag == 0){
					echo(",['".date("d/m/y")."',0,25]");
				}
			?>
			]);
			
			var dataTable = new google.visualization.DataTable();
			dataTable.addColumn('string', 'Fecha');
			dataTable.addColumn('number', 'Puntuacion');
			// A column for custom tooltip content
			dataTable.addColumn({type: 'string', role: 'tooltip'});
			dataTable.addRows(
			[
				<?php
				$primero = 0;
				foreach ($db->query($mediaequipo) as $row)
				{
					$flag = 1;
					$avgTeamCalification = $row['totalCalification'];
					$day = $row['Day'];
					$numpersonas = $row['Num_Personas'];
								
					if($day!=null){
						if($primero==0){
							 $primero=1;
							 echo("['".$day."',".$avgTeamCalification.", '".$day." Personas: ".$numpersonas."']");
						 }
						 else{
							echo(",['".$day."',".$avgTeamCalification.",'".$day." Personas: ".$numpersonas."']");
						 }
					}
				}
				
				 if ($flag == 0){
					echo("['".date("d-m-y")."',0,'25']");
				 }
				
				?>
			]);

			var options = {
				width: 900,
				chart: {
					title: 'Media entrenamientos',
					subtitle: 'Media a la izquierda, personas entrenando a la derecha'
				},
				axes: {
					y: {
						0: {label: 'Puntuación media', minValue: 0, maxValue: 1000}
					},
					x: {
						0: {label: 'Día de entrenamiento' }
					}
				},
				tooltip: {isHtml: true},
				interpolateNulls: true,
				legend: 'none'
			};

			var chart = new google.charts.Bar(document.getElementById('dual_y_div'));
			chart.draw(dataTable, options);
		};

		google.load('visualization', '1', {packages: ['corechart', 'bar']});
		google.setOnLoadCallback(drawTitleSubtitle);

		function drawTitleSubtitle() {
			var data = new google.visualization.arrayToDataTable(
			[				
				['Fecha', 'Participantes']
			<?php
				$flag = 0;
				/* Calculamos el numero de jugadores en el equipo */
				$personas = 0;
				$numpersonasequipo = "SELECT COUNT(id_customer) AS Numero
										FROM customersweb_team
										WHERE id_team = ".$_SESSION['id_team']." ";
				foreach ($db->query($numpersonasequipo) as $row)
				{
					if($row['Numero'] != null){
						$personas = $row['Numero'] - 1;
					}
				}					
				/* Calculamos el número de participantes por entrenamiento */
				$participantesequipo = "SELECT CONCAT(CONCAT(DAY(DATE(c.start_time)),'-'), MONTHNAME(DATE(c.start_time))) AS Day,
									COUNT(c.calification) AS Num_Personas
									FROM training_event  a
									LEFT JOIN training_player b ON a.id_training = b.id_training
									LEFT JOIN training_data c ON b.id_training_player = c.id_training_player
									WHERE a.id_team = ".$_SESSION['id_team']." and c.start_time is not null
									AND MONTH(DATE(c.start_time)) = ".date("n")." AND YEAR(DATE(c.start_time)) = ".date('Y')."
									GROUP BY DATE(c.start_time)
									ORDER BY c.start_time";
					
				foreach ($db->query($participantesequipo) as $row)
				{
					$flag = 1;
					$day = $row['Day'];
					$numpersonas = $row['Num_Personas'];
								
					if($day!=null){
						echo(",['".$day."',".$numpersonas."]");
					}
				}
				if ($flag == 0){
					echo(",['".date("d-m-y")."',0]");
				 }
			?>
			]);
	
			var view = new google.visualization.DataView(data);
			view.setColumns([0, 1,
								{ calc: "stringify",
								sourceColumn: 1,
								type: "string",
								role: "annotation" }]);
							
			var options = {
				colors: ['#9575cd', '#33ac71'],
				chart: {
					title: 'Participación de los Jugadores',
					subtitle: 'Cantidad de jugadores que han valorado el entrenamiento'
				},
				axes: {
					y: {
						0: {label: 'Cantidad de participantes',
							minValue: 0, 
							maxValue: <?php echo("".$personas.""); ?>,
							viewWindowMode:'explicit'
						}
					},
					x: {
						0: {label: 'Día de entrenamiento'}
					}
				},
				bar: {
					groupWidth: "90%"
				}
			};
			  
			var material = new google.charts.Bar(document.getElementById('chart_div'));
			material.draw(view, options);
		}
				
		google.load('visualization', '1.1', {packages: ['bar']});
		google.setOnLoadCallback(drawMultSeries);

		function drawMultSeries() {
			var data = new google.visualization.arrayToDataTable(
			[				
				['Fecha', 'Puntuacion', 'Personas']
			<?php
				$flag = 0;
				$mediaequipo = "SELECT AVG(c.calification*TIMESTAMPDIFF(MINUTE, c.start_time, c.end_time)) AS totalCalification,
									CONCAT(CONCAT(DAY(DATE(c.start_time)),'-'), MONTHNAME(DATE(c.start_time))) AS Day,
									COUNT(c.calification) AS Num_Personas
									FROM training_event  a
									LEFT JOIN training_player b ON a.id_training = b.id_training
									LEFT JOIN training_data c ON b.id_training_player = c.id_training_player
									WHERE a.id_team = ".$_SESSION['id_team']." and c.start_time is not null
									AND MONTH(DATE(c.start_time)) = ".date("n")." AND YEAR(DATE(c.start_time)) = ".date('Y')."
									GROUP BY DATE(c.start_time)
									ORDER BY c.start_time";
					
				foreach ($db->query($mediaequipo) as $row)
				{
					$flag = 1;
					$avgTeamCalification = $row['totalCalification'];
					$day = $row['Day'];
					$numpersonas = $row['Num_Personas'];
								
					if($day!=null){
						echo(",['".$day."',".$avgTeamCalification.",".$numpersonas."]");
					}
				}
				if ($flag == 0){
					echo(",['".date("d-m-y")."',0,0]");
				 }
			?>
			]);

			var options = {
				chart: {
					title: 'Participación vs. Puntuación media',
					subtitle: 'Cantidad de jugadores que han valorado el entrenamiento y la puntuación media'
				},
				series: {
					0: { axis: 'media' }, // Bind series 0 to an axis named 'distance'.
					1: { axis: 'participantes' } // Bind series 1 to an axis named 'brightness'.
				},
				axes: {
					y: {
						media: {label: 'Puntuación media', minValue: 0, maxValue: 1000},
						participantes: {side: 'right', label: 'Cantidad de participantes', minValue: 0, maxValue: <?php echo("".$personas.""); ?>}
					},
					x: {
						0: {label: 'Día de entrenamiento'}
					}
				},
				bar: {
					groupWidth: "90%"
				}
			};

			  var chart = new google.charts.Bar(document.getElementById('chart_div2'));
			  chart.draw(data, options);
		}
				
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
	<!-- 
		Modal HTML para los terminos y condiciones
	-->
	<div class="modal fade animated bounceIn" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<a class="cierreCuadroRegistro" id="cierrelargeModal" data-dismiss="modal" aria-hidden="true"></a>
						<h4 class="modal-title" id="myModalLabel">Eliminar</h4>
					</div>
					<div class="modal-body">
						<p>
							Estas seguro de quiere eliminar el jugador
						</p>
					</div>
					<div class="modal-footer">
						<button id="btnEliminar" class="btn btn-primary" onclick="return eliminarJugador();">Aceptar</button>
						<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
					</div>
				</div>
		  </div>
	</div>
</body>
</html>