<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

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
		<link rel="stylesheet" type="text/css" href="css/xcharts.css"> 
		<link rel="stylesheet" type="text/css" href="css/xcharts.min.css"> 
	  	
		<link href="icons/IconNav23.ico" type="image/x-icon" rel="shortcut icon" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js?ver=1.4.2"></script>
		<!--<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>-->
		<script src="http://d3js.org/d3.v3.min.js"></script>
		<script src="js/xcharts.js"></script>	
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="js/bootstrap/bootstrap.js"></script>
	</head>

<script>
	
	document.onkeyup = KeyCheck;       
	function KeyCheck(){

		var KeyID = event.keyCode;
		switch(KeyID){
			// case 16:
				// document.Form1.KeyName.value = "Shift";
				// break; 
			// case 17:
				// document.Form1.KeyName.value = "Ctrl";
				// break;
			// case 18:
				// document.Form1.KeyName.value = "Alt";
				// break;
			// case 19:
				// document.Form1.KeyName.value = "Pause";
				// break;
			//Arrow Left
			case 37:
				if (document.getElementById('chart2').style.display == 'block'){
					document.getElementById('chart1').style.display = 'block';
					document.getElementById('chart2').style.display = 'none';
				}
				else if (document.getElementById('chart1').style.display == 'block'){
				
				}
				else{
					document.getElementById('chart2').style.display = 'block';
					document.getElementById('chart3').style.display = 'none';
				}
				
				break;
			//Arrow Up
			case 38:
				break;
			//Arrow Right
			case 39:
				if (document.getElementById('chart2').style.display == 'block'){
					document.getElementById('chart2').style.display = 'none';
					document.getElementById('chart3').style.display = 'block';
				}
				else if (document.getElementById('chart3').style.display == 'block'){
				
				}
				else{
					document.getElementById('chart1').style.display = 'none';
					document.getElementById('chart2').style.display = 'block';
				}
				break;
			//Arrow Down
			case 40:
				break;
		}

}
	
	function left(){
		if (document.getElementById('chart2').style.display == 'block'){
			document.getElementById('chart1').style.display = 'block';
			document.getElementById('chart2').style.display = 'none';
		}
		else if (document.getElementById('chart1').style.display == 'block'){
		
		}
		else{
			document.getElementById('chart2').style.display = 'block';
			document.getElementById('chart3').style.display = 'none';
		}
	}
	
	function right(){
		if (document.getElementById('chart2').style.display == 'block'){
			document.getElementById('chart2').style.display = 'none';
			document.getElementById('chart3').style.display = 'block';
		}
		else if (document.getElementById('chart3').style.display == 'block'){
		
		}
		else{
			document.getElementById('chart1').style.display = 'none';
			document.getElementById('chart2').style.display = 'block';
		}
	}
	
	function goLastMonth(month, year){
		// If the month is January, decrement the year
		if(month == 1){
			year = year -1;
			month = 13;
		}
		document.location.href = 'http://appdeportesprueba.esy.es/grafica.php?id_player=<?php echo $_REQUEST['id_player']; ?>&mes='+(month-1)+'&anio='+year;	
	}

	function goNextMonth(month, year){
		// If the month is December, increment the year
		if(month == 12){
			year = year + 1;
			month = 0;
		}
		document.location.href = 'http://appdeportesprueba.esy.es/grafica.php?id_player=<?php echo $_REQUEST['id_player']; ?>&mes='+(month+1)+'&anio='+year;
	}
	
</script>	

    <body class="selectTeam">
		<div id='cssmenu'>
			<ul>	   
			   <li><a href='deletesession.php'>Desconexión</a></li>
			   <li><a href='calendar.php'>Equipo</a></li>
			   <li class='active'><a href='index.php'>Home</a></li>
			   
			</ul>
		</div>

	 <?php 
		include ('Formato/conexionsql.php'); 
		if(!isset($_SESSION)) { 
			session_start(); 
		}  
		if(!isset($_REQUEST['id_player']) || empty($_REQUEST['id_player']) || empty($_SESSION['id_team']) || !isset($_SESSION['id_team'])){
			header("Location: index.php");								
		}
		
		$idPlayer = $_REQUEST['id_player'];
		$month = $_REQUEST['mes'];
		$year = $_REQUEST['anio'];
		
		$sqlPlayer = "SELECT firstname from customersweb where id_customer = ".$idPlayer;		
		foreach ($db->query($sqlPlayer) as $row)
		{                                                   
			$playerName = $row['firstname'];
		}	
		
		$sqlTeam = "SELECT name from team where id_team = ".$_SESSION['id_team'];		
		foreach ($db->query($sqlTeam) as $row)
		{                                                   
			$teamName = $row['name'];
		}	
		
		$sqlPlayer = "SELECT c.calification*TIMESTAMPDIFF(MINUTE, c.start_time, c.end_time) AS totalCalification,
					CONCAT(CONCAT(DAY(DATE(c.start_time)),'-'), MONTHNAME(DATE(c.start_time))) AS Day
					FROM training_event  a
					LEFT JOIN training_player b ON a.id_training = b.id_training
					LEFT JOIN training_data c ON b.id_training_player = c.id_training_player
					WHERE a.id_team =".$_SESSION['id_team']." and b.id_customer = ".$idPlayer." and c.start_time is not null
					AND MONTH(DATE(c.start_time)) = ".$month." AND YEAR(DATE(c.start_time)) = ".$year."
					GROUP BY DATE(c.start_time)
					ORDER BY c.start_time";		
					
		$sqlTeam = "SELECT AVG(c.calification*TIMESTAMPDIFF(MINUTE, c.start_time, c.end_time)) AS totalCalification,
					CONCAT(CONCAT(DAY(DATE(c.start_time)),'-'), MONTHNAME(DATE(c.start_time))) AS Day
					FROM training_event  a
					LEFT JOIN training_player b ON a.id_training = b.id_training
					LEFT JOIN training_data c ON b.id_training_player = c.id_training_player
					WHERE a.id_team = ".$_SESSION['id_team']." and b.id_customer <> ".$idPlayer." and c.start_time is not null
					AND MONTH(DATE(c.start_time)) = ".$month." AND YEAR(DATE(c.start_time)) = ".$year."
					GROUP BY DATE(c.start_time)
					ORDER BY c.start_time";	

		$sqlPlayerId = " SELECT concat(concat(a.username, ' '), a.lastname) as Nombre, a.email, a.phone, a.img_path, b.date_born, b.Dorsal, c.name as Position
						FROM customersweb a
						LEFT JOIN customersweb_players b ON a.id_customer = b.id_customer	
						LEFT JOIN player_position c ON c.id_position = b.position_id
						WHERE a.id_customer = ".$idPlayer."
						";
		
	?>
		<div class="col-xs-4 col-sm-6 col-md-6" style="  width: 25%;  margin-top: 4%;">
			<div style='width: 80%; height: 550px; margin-top: 10%;'>
				<table class='table' width='325'>
					<?php
						foreach ($db->query($sqlPlayerId) as $row)
						{
							echo("
								<tr>
									<td style='border-top: 0px !important;'></td>
									<td style='border-top: 0px !important;'> <img src='".$row['img_path']."' style='height: 160px;' class='img-circle'> </td>
								</tr>
								<tr style='  background: aquamarine;'>
									<td> Nombre </td>
									<td style='text-align: center;  vertical-align: middle;'>
										".$row['Nombre']."
									</td>
								</tr>
								<tr style='  background: aquamarine;'>
									<td> Email </td>
									<td style='text-align: center;  vertical-align: middle;'>
										".$row['email']."
									</td>
								</tr>
								<tr style='  background: aquamarine;'>
									<td> Telefono </td>
									<td style='text-align: center;  vertical-align: middle;'>
										".$row['phone']."
									</td>
								</tr>
								<tr style='  background: aquamarine;'>
									<td> Fecha de Nacimiento </td>
									<td style='text-align: center;  vertical-align: middle;'>
										".$row['date_born']."
									</td>
								</tr>
								<tr style='  background: aquamarine;'>
									<td> Dorsal </td>
									<td style='text-align: center;  vertical-align: middle;'>
										".$row['Dorsal']."
									</td>
								</tr>
								 <tr style='  background: aquamarine;'>
									<td> Posicion </td>
									<td style='text-align: center;  vertical-align: middle;'>
										".$row['Position']."
									</td>
								</tr>
							 ");
						 }
					 ?>
			   </table>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-8">
		<div>
			<img style="float: left;  width: 50px;  height: 50px;  margin-top: 25%;  margin-left: -30px;  cursor: pointer;" src="images/icons/leftrow.png" onclick="left()"></img>
		</div>
		<div>
			<img style="float: right;  width: 50px;  height: 50px;  margin-top: 25%;  margin-right: -30px;  cursor: pointer;" src="images/icons/rightrow.png" onclick="right()"></img>
		</div>
		<div id = "charts" >
				<div id = "chart1" style="border: 1px solid #CFCFCF; margin: 2%; display: none;">	
					<div id="chartTitle" >
						<h4> Gráfica calificaciones diarias Jugador </h4>
					</div>
					<p style="color: #E624FF;   margin: 0; padding: 0;  margin-left: 5%; font-weight: 600;  font-family: 'Raleway', sans-serif;"> 
						 <?php echo($playerName) ?> </p> 
					<figure style="width: 400px; height: 300px; margin: 0 auto;" id="myChart1"></figure>
				</div>
				<div id = "chart2" style="border: 1px solid #CFCFCF; margin: 2%; ">		
					<div id="chartTitle">
						<h4> Gráfica calificaciones diarias Equipo </h4>
					</div>
					<p style="color: #3880aa;  margin: 0; padding: 0;  margin-left: 5%; font-weight: 600;  font-family: 'Raleway', sans-serif;">
						 <?php echo($teamName) ?></p>
					<figure style="width: 400px; height: 300px; margin: 0 auto;" id="myChart2"></figure>
				</div>
				<div id = "chart3" style="border: 1px solid #CFCFCF; margin: 2%; display: none;">		
					<div id="chartTitle">
						<h4> Gráfica calificaciones diarias Jugador / Equipo </h4>
					</div>
					<p style="color: #E624FF;   margin: 0; padding: 0;  margin-left: 5%; font-weight: 600;  font-family: 'Raleway', sans-serif;"> 
						 <?php echo($playerName) ?> </p> 
					<p style="color: #3880aa;  margin: 0; padding: 0;  margin-left: 5%; font-weight: 600;  font-family: 'Raleway', sans-serif;">
						 <?php echo($teamName) ?></p>
					<figure style="width: 400px; height: 300px; margin: 0 auto;" id="myChart3"></figure>
				</div>
		</div>
		<div style="text-align: center; margin-top: 10px;">
			<button id="btnAnterior" type="button" class="btn btn-primary btn-lg" style="display: inline;" 
					onclick="goLastMonth(<?php echo $month . ", " . $year; ?>)">Anterior</button>
			<?php
				//echo ("<button id='btnAnterior' type='button' class='btn btn-primary btn-lg' style='display: inline;' 
				//			onclick='javascript: AnteriorSiguiente(0)'>Anterior</button>");
			
				function getMonth_Text($m) { 
					switch ($m) { 
						case 1: $month_text = "Enero"; break; 
						case 2: $month_text = "Febrero"; break; 
						case 3: $month_text = "Marzo"; break; 
						case 4: $month_text = "Abril"; break; 
						case 5: $month_text = "Mayo"; break; 
						case 6: $month_text = "Junio"; break; 
						case 7: $month_text = "Julio"; break; 
						case 8: $month_text = "Agosto"; break; 
						case 9: $month_text = "Septiembre"; break; 
						case 10: $month_text = "Octubre"; break; 
						case 11: $month_text = "Noviembre"; break; 
						case 12: $month_text = "Diciembre"; break; 
					} 
					return ($month_text); 
				}
				
				echo ("<h2 id='aniomes' style='display: inline; color: cornsilk;' >".getMonth_Text($month)." - ".$year."</h2>");
			
				//echo("<button id='btnSiguiente' type='button' class='btn btn-primary btn-lg' style='display: inline;' 
				//			onclick='javascript: AnteriorSiguiente(1)'>Siguiente</button>");
			?>
			<button id="btnSiguiente" type="button" class="btn btn-primary btn-lg" style="display: inline;" 
					onclick="goNextMonth(<?php echo $month . ", " . $year; ?>)">Siguiente</button>
		</div>
		<div>
	<?php 
		include 'Formato/piepag.php' 
	?>	
<script>
(function($){
var data1 = {
  "xScale": "ordinal",
  "yScale": "linear",
  "type": "bar", 
  "main": [
    {
      "className": ".pizza",
      "type": "line-dotted",
      "data": [
       <?php
			$primero = 0;
			foreach ($db->query($sqlPlayer) as $row)
			{                                                   
				$avgTeamCalification = $row['totalCalification'];
				$day = $row['Day'];
							
				if($day!=null){
					if($primero==0){
					 $primero=1;
						echo("
						{
							'x': '".$day."',
							'y':  ".$avgTeamCalification."
						}
						");
					}else{
						echo("
						,{
							'x': '".$day."',
							'y':  ".$avgTeamCalification."
						}
						");
					}
				}
			}	
		?>     
      ]
    }
  ]
};
var myChart1 = new xChart('bar', data1, '#myChart1');
})(jQuery);

(function($){
var data2 = {
  "xScale": "ordinal",
  "yScale": "linear",
  "type": "bar", 
  "main": [
    {
      "className": ".pizza",
      "data": [
		<?php			
			$primero = 0;
			foreach ($db->query($sqlTeam) as $row)
			{                                                   
				$avgTeamCalification = $row['totalCalification'];
				$day = $row['Day'];
							
				if($day!=null){
					if($primero==0){
					 $primero=1;
						echo("
						{
							'x': '".$day."',
							'y':  ".$avgTeamCalification."
						}
						");
					}else{
						echo("
						,{
							'x': '".$day."',
							'y':  ".$avgTeamCalification."
						}
						");
					}
				}
			}	
		?>     
      ]
    }
  ]
};
var opts = {
  "empty": function (self, selector, data) {d3.select(selector).text('SVG is not supported on your browser');}
};
var myChart2 = new xChart('bar', data2, '#myChart2');
})(jQuery);

(function($){
var data3 = {
  "xScale": "ordinal",
  "yScale": "linear",
  "type": "bar", 
  "main": [
    {
      "className": ".pizza",
      "data": [
		<?php	
			$primero = 0;
			foreach ($db->query($sqlTeam) as $row)
			{                                                   
				$avgTeamCalification = $row['totalCalification'];
				$day = $row['Day'];
							
				if($day!=null){
					if($primero==0){
					 $primero=1;
						echo("
						{
							'x': '".$day."',
							'y':  ".$avgTeamCalification."
						}
						");
					}else{
						echo("
						,{
							'x': '".$day."',
							'y':  ".$avgTeamCalification."
						}
						");	
					}
				}
			}	
		?>     
      ]
    }
  ],
   "comp": [
    {
      "className": ".pizza",
      "type": "line-dotted",
      "data": [
       <?php	
			$primero = 0;
			foreach ($db->query($sqlPlayer) as $row)
			{                                                   
				$avgTeamCalification = $row['totalCalification'];
				$day = $row['Day'];
							
				if($day!=null){
					if($primero==0){
					 $primero=1;
						echo("
						{
							'x': '".$day."',
							'y':  ".$avgTeamCalification."
						}
						");
					}else{
						echo("
						,{
							'x': '".$day."',
							'y':  ".$avgTeamCalification."
						}
						");
					}
				}
			}	
		?>     
      ]
    }
  ]
};
var myChart3 = new xChart('bar', data3, '#myChart3');
})(jQuery);
	
</script>

	</body>
</html>
