<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html>
    <head>
	
		<meta http-equiv="X-UA-Compatible" content="IE=7,8,9" />
		
		<link rel="stylesheet" type="text/css" href="css/Estilo.css"> 
		<link rel="stylesheet" type="text/css" href="css/xcharts.css"> 
		<link rel="stylesheet" type="text/css" href="css/xcharts.min.css"> 
		<title>Inicio</title>	  	
		<link href="icons/IconNav23.ico" type="image/x-icon" rel="shortcut icon" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js?ver=1.4.2"></script>
		
		<!--<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>-->
		<script src="http://d3js.org/d3.v3.min.js"></script>

		<script src="js/xcharts.js"></script>
		<script src="js/xcharts.min.js"></script>
	
		<meta http-equiv="Content-Type" content="text/html; charset= ISO-8859-1">
		<meta http-equiv="Content-Type" content="text/html; charset= utf-8">
  </head>
    <body class="selectTeam">
	<div id='cssmenu'>
		<ul>	   
		   <li><a href='deletesession.php'>Desconexión</a></li>
		   <li><a href='calendar.php'>Equipo</a></li>
		   <li class='active'><a href='index.php'>Home</a></li>
		   
		</ul>
	</div>
	
	

	 <?php include 'Formato/conexionsql.php' ?>	
	 <?php
		if(!isset($_SESSION)) 
			{ 
				session_start(); 
			}  
		if(!isset($_REQUEST['id_player']) || empty($_REQUEST['id_player']) 
		|| empty($_SESSION['id_team']) || !isset($_SESSION['id_team'])){
			header("Location: index.php");								
		}
		
		$idPlayer = $_REQUEST['id_player'];
		
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
					GROUP BY DATE(c.start_time)
					ORDER BY c.start_time";		
					
		$sqlTeam = "SELECT AVG(c.calification*TIMESTAMPDIFF(MINUTE, c.start_time, c.end_time)) AS totalCalification,
					CONCAT(CONCAT(DAY(DATE(c.start_time)),'-'), MONTHNAME(DATE(c.start_time))) AS Day
					FROM training_event  a
					LEFT JOIN training_player b ON a.id_training = b.id_training
					LEFT JOIN training_data c ON b.id_training_player = c.id_training_player
					WHERE a.id_team = ".$_SESSION['id_team']." and b.id_customer <> ".$idPlayer." and c.start_time is not null
					GROUP BY DATE(c.start_time)
					ORDER BY c.start_time";		
		
?>

<div id = "charts" >
		<div id = "chart">	
			<div id="chartTitle" >
				<h4> Gráfica calificaciones diarias Jugador </h4>
			</div>
			<p style="color: #E624FF;   margin: 0; padding: 0;  margin-left: 5%; font-weight: 600;  font-family: 'Raleway', sans-serif;"> 
				 <?php echo($playerName) ?> </p> 
			<figure style="width: 400px; height: 300px;" id="myChart1"></figure>
		</div>
		<div id = "chart">		
			<div id="chartTitle">
				<h4> Gráfica calificaciones diarias Equipo </h4>
			</div>
			<p style="color: #3880aa;  margin: 0; padding: 0;  margin-left: 5%; font-weight: 600;  font-family: 'Raleway', sans-serif;">
				 <?php echo($teamName) ?></p>
			<figure style="width: 400px; height: 300px;" id="myChart2"></figure>
		</div>
		<div id = "chart">		
			<div id="chartTitle">
				<h4> Gráfica calificaciones diarias Jugador / Equipo </h4>
			</div>
			<p style="color: #E624FF;   margin: 0; padding: 0;  margin-left: 5%; font-weight: 600;  font-family: 'Raleway', sans-serif;"> 
				 <?php echo($playerName) ?> </p> 
			<p style="color: #3880aa;  margin: 0; padding: 0;  margin-left: 5%; font-weight: 600;  font-family: 'Raleway', sans-serif;">
				 <?php echo($teamName) ?></p>
			<figure style="width: 400px; height: 300px;" id="myChart3"></figure>
		</div>
		
</div>
<?php include 'Formato/piepag.php' ?>	
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
