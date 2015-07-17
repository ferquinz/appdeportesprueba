<!DOCTYPE html>
<?php 
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
?>
<html>
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="images/Logos/LogoV2.jpg" type="image/png" />
		<title>AppdeportesPrueba</title>
		<link href="icons/IconNav23.ico" type="image/x-icon" rel="shortcut icon" />
		<link rel="stylesheet" type="text/css" href="css/Estilo.css">
		<!-- Bootstrap -->
		<link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">		
		<link rel="stylesheet" type="text/css" href="css/xcharts.css"> 
		<link rel="stylesheet" type="text/css" href="css/xcharts.min.css"> 
	  	
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="js/bootstrap/bootstrap.js"></script>

		<!-- Add fancyBox main JS and CSS files -->
		<script type="text/javascript" src="js/fancybox/jquery.fancybox.js?v=2.1.5"></script>
		<link rel="stylesheet" type="text/css" href="css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
		
		<script src="http://d3js.org/d3.v3.min.js"></script>
		<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>
		<script src="js/xcharts.js"></script>	
		<style>
		<style>
			.axis path,
			.axis line {
			  fill: none;
			  stroke: #000;
			  shape-rendering: crispEdges;
			}

			.bar {
			  fill: orange;
			}

			.bar:hover {
			  fill: orangered ;
			}

			.x.axis path {
			  display: none;
			}

			.d3-tip {
			  line-height: 1;
			  font-weight: bold;
			  padding: 12px;
			  background: rgba(0, 0, 0, 0.8);
			  color: #fff;
			  border-radius: 2px;
			}

			/* Creates a small triangle extender for the tooltip */
			.d3-tip:after {
			  box-sizing: border-box;
			  display: inline;
			  font-size: 10px;
			  width: 100%;
			  line-height: 1;
			  color: rgba(0, 0, 0, 0.8);
			  content: "\25BC";
			  position: absolute;
			  text-align: center;
			}

			/* Style northward tooltips differently */
			.d3-tip.n:after {
			  margin: -1px 0 0 0;
			  top: 100%;
			  left: 0;
			}
		</style>		
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
		<div class="col-xs-12 col-sm-12 col-md-12" id='cssmenu'>
			<ul>	   
			   <li><a href='deletesession.php'>Desconexion</a></li>
			   <li><a href='configuracion.php'>Configuracion</a></li>
			   <li><a href='calendar.php'>Equipo</a></li>
			   <li><a href='index.php'>Home</a></li>
			   
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

		$sqlPlayerId = " SELECT concat(concat(a.firstname, ' '), a.lastname) as Nombre, a.email, a.phone, a.img_path, b.date_born, b.Dorsal, c.name as Position
						FROM customersweb a
						LEFT JOIN customersweb_players b ON a.id_customer = b.id_customer	
						LEFT JOIN player_position c ON c.id_position = b.position_id
						WHERE a.id_customer = ".$idPlayer."
						";
		
	?>
		<div class="col-xs-3 col-sm-3 col-md-3" style="margin-top: 4%;">
			<div style='width: 90%; margin-top: 10%;'>
				<table class='table'>
					<?php
						foreach ($db->query($sqlPlayerId) as $row)
						{
							$valores=explode('/',$row['img_path']);
							$valores[count($valores)-1] = "Original_".$valores[count($valores)-1];
							$originalImage = implode("/", $valores);
							
							echo("
								<tr style='text-align: center;'>
									<td style='border-top: 0px !important;'>
										<a class='fancybox' href='".$originalImage."' title='Foto de jugador' >
											<img src='".$row['img_path']."' style='height: 160px;' class='img-circle'> 
										</a>
									</td>
								</tr>
								</table>
								<table class='table table-striped' style='background: rgb(71, 201, 175);'>
								<tr>
									<td> Nombre </td>
									<td style='text-align: center;  vertical-align: middle;'>
										".$row['Nombre']."
									</td>
								</tr>
								<tr>
									<td> Email </td>
									<td style='text-align: center;  vertical-align: middle;'>
										".$row['email']."
									</td>
								</tr>
								<tr>
									<td> Telefono </td>
									<td style='text-align: center;  vertical-align: middle;'>
										".$row['phone']."
									</td>
								</tr>
								<tr>
									<td> Fecha de Nacimiento </td>
									<td style='text-align: center;  vertical-align: middle;'>
										".$row['date_born']."
									</td>
								</tr>
								<tr>
									<td> Dorsal </td>
									<td style='text-align: center;  vertical-align: middle;'>
										".$row['Dorsal']."
									</td>
								</tr>
								 <tr>
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
		<div class="col-xs-8 col-sm-8 col-md-8">
		<div>
			<img style="float: left;  width: 50px;  height: 50px;  margin-top: 25%;  margin-left: -30px;  cursor: pointer;" src="images/icons/leftrow.png" onclick="left()"></img>
		</div>
		<div>
			<img style="float: right;  width: 50px;  height: 50px;  margin-top: 25%;  margin-right: -30px;  cursor: pointer;" src="images/icons/rightrow.png" onclick="right()"></img>
		</div>
		<div id = "charts" >
				<div id = "chart1" style="border: 1px solid #CFCFCF; margin: 2%; display: none;">	
					<div id="chartTitle" >
						<h4> Grafica calificaciones diarias Jugador </h4>
					</div>
					<p style="color: #E624FF;   margin: 0; padding: 0;  margin-left: 5%; font-weight: 600;  font-family: 'Raleway', sans-serif;"> 
						 <?php echo($playerName) ?> </p> 
					<figure style="width: 400px; height: 300px; margin: 0 auto;" id="myChart1"></figure>
				</div>
				<div id = "chart2" style="border: 1px solid #CFCFCF; margin: 2%; ">		
					<div id="chartTitle">
						<h4> Grafica calificaciones diarias Equipo </h4>
					</div>
					<p style="color: #3880aa;  margin: 0; padding: 0;  margin-left: 5%; font-weight: 600;  font-family: 'Raleway', sans-serif;">
						 <?php echo($teamName) ?></p>
					<figure style="width: 400px; height: 300px; margin: 0 auto;" id="myChart2"></figure>
				</div>
				<div id = "chart3" style="border: 1px solid #CFCFCF; margin: 2%; display: none;">		
					<div id="chartTitle">
						<h4> Grafica calificaciones diarias Jugador / Equipo </h4>
					</div>
					<p style="color: #E624FF;   margin: 0; padding: 0;  margin-left: 5%; font-weight: 600;  font-family: 'Raleway', sans-serif;"> 
						 <?php echo($playerName) ?> </p> 
					<p style="color: #3880aa;  margin: 0; padding: 0;  margin-left: 5%; font-weight: 600;  font-family: 'Raleway', sans-serif;">
						 <?php echo($teamName) ?></p>
					<figure style="width: 400px; height: 300px; margin: 0 auto;" id="myChart3"></figure>
				</div>
		</div>
		<div style="text-align: center; margin-top: 1%;">
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
		<script>

			var margin = {top: 40, right: 20, bottom: 30, left: 40},
				width = 960 - margin.left - margin.right,
				height = 500 - margin.top - margin.bottom;

			var formatPercent = d3.format(".0%");

			var x = d3.scale.ordinal()
				.rangeRoundBands([0, width], .1);

			var y = d3.scale.linear()
				.range([height, 0]);

			var xAxis = d3.svg.axis()
				.scale(x)
				.orient("bottom");

			var yAxis = d3.svg.axis()
				.scale(y)
				.orient("left")
				.tickFormat(formatPercent);

			var tip = d3.tip()
			  .attr('class', 'd3-tip')
			  .offset([-10, 0])
			  .html(function(d) {
				return "<strong>Frequency:</strong> <span style='color:red'>" + d.frequency + "</span>";
			  })

			var svg = d3.select("body").append("svg")
				.attr("width", width + margin.left + margin.right)
				.attr("height", height + margin.top + margin.bottom)
				.attr("fill", 'white')
			  .append("g")
				.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

			svg.call(tip);
			
			d3.tsv("data.tsv", type, function(error, data) {
			  x.domain(data.map(function(d) { return d.letter; }));
			  y.domain([0, d3.max(data, function(d) { return d.frequency; })]);

			  svg.append("g")
				  .attr("class", "x axis")
				  .attr("transform", "translate(0," + height + ")")
				  .call(xAxis);

			  svg.append("g")
				  .attr("class", "y axis")
				  .call(yAxis)
				.append("text")
				  .attr("transform", "rotate(-90)")
				  .attr("y", 6)
				  .attr("dy", ".71em")
				  .style("text-anchor", "end")
				  .text("Frequency");

			  svg.selectAll(".bar")
				  .data(data)
				.enter().append("rect")
				  .attr("class", "bar")
				  .attr("x", function(d) { return x(d.letter); })
				  .attr("width", x.rangeBand())
				  .attr("y", function(d) { return y(d.frequency); })
				  .attr("height", function(d) { return height - y(d.frequency); })
				  .on('mouseover', tip.show)
				  .on('mouseout', tip.hide)

			});

			function type(d) {
			  d.frequency = +d.frequency;
			  return d;
			}

		</script>
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
