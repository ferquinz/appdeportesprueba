<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=7,8,9" />
		<link rel="stylesheet" type="text/css" href="Estilo/Estilo.css"> 
		<title>Registro</title>	  

                        
    </head>
    <body>
		 <?php include 'Formato/conexionsql.php' ?>	  
		<?php include 'Formato/funciones.php' ?>
		<!--------------- Bloque del cuerpo ----------------->
		<div id="contenidoIndex">
			<div id="infoLoginReg">	
				<?php
				
					/*for ($i = 0; $i < 24; $i++){
						echo("Insertando jugador ".$i); 
						$nombre="JugadorArsenal".$i;
						$apellido="ApellidoArsenal".$i;
						$username="UsuarioArsenal".$i;
						$email="CorreoArsenal".$i."@gmail.com";
						$phone="612345678".$i;
						$password=md5("12345678");
						$img_path="players/miguelrojo@gmail.com/2.jpg";
						$sql = "INSERT INTO customersweb (firstname, lastname, username, email, phone, password, img_path, mister) VALUES ('".$nombre."', '".$apellido."','".$username."','".$email."','".$phone."','".$password."','".$img_path."', 0)";
							
						$db->query($sql);
					}*/
					
					/*for ($i = 1; $i < 25; $i++){
						echo("Insertando jugador ".$i); 
						$id_customer="".$i+159;
						$position="2";
						$date="1991-06-04".$i;
						$dorsal="".$i;
						$sql = "INSERT INTO customersweb_players (id_customer, position_id, date_born, dorsal) VALUES ('".$id_customer."', '".$position."',
						'".$date."','".$dorsal."')";
							
						$db->query($sql);
					}*/
					
					/*for ($i = 0; $i < 24; $i++){
						echo("Insertando jugador ".$i); 
						$id_customer="".$i+159;
						$id_team="114";						
						$sql = "INSERT INTO customersweb_team (id_customer, id_team) VALUES ('".$id_customer."', '".$id_team."')";
							
						$db->query($sql);
					}*/
					
					
					
					/* Entrenamiento 1 */
					/*echo("Insertando entrenamiento <br> <br>");						
					$title="entrenamiento prueba";
					$description="descirfgsdjkofjiosdafj dasof";
					$place="Casa";
					$hour_training="12:00";
					$id_team="114";
					$training_date="2015-08-01 00:00:00";
					$id_customer="3";
					$sql = "INSERT INTO training_event (title, description, place, hour_training, 
					id_team, training_date, id_customer) VALUES ('".$title."', 
					'".$description."','".$place."','".$hour_training."','".$id_team."','".$training_date."','".$id_customer."')";
						
					$db->query($sql);
					
					for ($i = 0; $i < 24; $i++){
						echo("Insertando training_player ".$i); 
						$id_customer="".$i+159;
						$id_training=80;						
						$sql = "INSERT INTO training_player (id_customer, id_training) VALUES ('".$id_customer."', ".$id_training.")";
							
						$db->query($sql);
					}
					
					
					for ($i = 0; $i < 24; $i++){						
						$id_training_player="".$i+203;
						$start_time="2015-08-01 12:00:00";
						$end_time="2015-08-01 14:00:00";
						$calification= rand ( 1 , 10 );
						$sql = "INSERT INTO training_data (id_training_player, start_time, end_time, calification)
						VALUES ('".$id_training_player."', '".$start_time."', '".$end_time."', ".$calification.")";
										
						echo("<br>".$sql);				
						$db->query($sql);
					}*/
					
					/* Entrenamiento 2 */
					/*echo("Insertando entrenamiento <br> <br>");						
					$title="entrenamiento prueba";
					$description="descirfgsdjkofjiosdafj dasof";
					$place="Casa";
					$hour_training="12:00";
					$id_team="114";
					$training_date="2015-08-03 00:00:00";
					$id_customer="3";
					$sql = "INSERT INTO training_event (title, description, place, hour_training, 
					id_team, training_date, id_customer) VALUES ('".$title."', 
					'".$description."','".$place."','".$hour_training."','".$id_team."','".$training_date."','".$id_customer."')";
						
					$db->query($sql);
					
					for ($i = 0; $i < 24; $i++){
						echo("Insertando training_player ".$i); 
						$id_customer="".$i+159;
						$id_training=81;						
						$sql = "INSERT INTO training_player (id_customer, id_training) VALUES ('".$id_customer."', ".$id_training.")";
							
						$db->query($sql);
					}*/
					
					
					for ($i = 0; $i < 22; $i++){						
						$id_training_player="".$i+227;
						$start_time="2015-08-03 12:00:00";
						$end_time="2015-08-03 14:00:00";
						$calification= rand ( 1 , 10 );
						$sql = "INSERT INTO training_data (id_training_player, start_time, end_time, calification)
						VALUES ('".$id_training_player."', '".$start_time."', '".$end_time."', ".$calification.")";
										
						echo("<br>".$sql);				
						$db->query($sql);
					}
					
					/* Entrenamiento 3 */
					/*echo("Insertando entrenamiento <br> <br>");						
					$title="entrenamiento prueba";
					$description="descirfgsdjkofjiosdafj dasof";
					$place="Casa";
					$hour_training="12:00";
					$id_team="114";
					$training_date="2015-08-05 00:00:00";
					$id_customer="3";
					$sql = "INSERT INTO training_event (title, description, place, hour_training, 
					id_team, training_date, id_customer) VALUES ('".$title."', 
					'".$description."','".$place."','".$hour_training."','".$id_team."','".$training_date."','".$id_customer."')";
						
					$db->query($sql);
					
					for ($i = 0; $i < 24; $i++){
						echo("Insertando training_player ".$i); 
						$id_customer="".$i+159;
						$id_training=82;						
						$sql = "INSERT INTO training_player (id_customer, id_training) VALUES ('".$id_customer."', ".$id_training.")";
							
						$db->query($sql);
					}*/
					
					
					for ($i = 0; $i < 22; $i++){						
						$id_training_player="".$i+250;
						$start_time="2015-08-05 12:00:00";
						$end_time="2015-08-05 14:00:00";
						$calification= rand ( 1 , 10 );
						$sql = "INSERT INTO training_data (id_training_player, start_time, end_time, calification)
						VALUES ('".$id_training_player."', '".$start_time."', '".$end_time."', ".$calification.")";
										
						echo("<br>".$sql);				
						$db->query($sql);
					}
					
					/*Cierra la conexion con la base de datos*/
					$db=NULL;
                                            
                ?>  
		
			</div>
		</div>      
	     
    </body>
</html>
