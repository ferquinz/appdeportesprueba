<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=7,8,9" />
		<link rel="stylesheet" type="text/css" href="Estilo/Estilo.css"> 
		<title>Calendario</title>	  

                        
    </head>
    <body>
		 <?php include 'Formato/conexionsql.php' ?>	  
		
		<!--------------- Bloque del cuerpo ----------------->
		<div id="contenidoIndex">
			<div id="infoLoginReg">	
			
				<?php
							if(!isset($_REQUEST['team']) || empty($_REQUEST['team'])){
								header("Location: index.php");								
							}
							if(!isset($_SESSION)) 
							{ 
								session_start(); 
							}  	
				
							$correo=$_REQUEST['correo'];           
							 /*Realiza la consulta para obtener el usuario*/
							$sql = "SELECT id_team from team where id_team=".$_REQUEST['team'] ;
							foreach ($db->query($sql) as $row)
							{                                                   
									$teamid = $row['id_team'];
							}
							if($teamid!=NULL){  
								echo("Creado");
								$_SESSION['id_team']= $_REQUEST['team'];							
								header("Location: calendar.php");								

							}else{
								echo("No creado..");
								header("Location: index.php");																			
							}
                                           
					/*Cierra la conexion con la base de datos*/
					$db=NULL;
					
                ?>  
		
			</div>
		</div>      
	     
    </body>
</html>
