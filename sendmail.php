<?php
	include('Formato/conexionsql.php');   
	include('Formato/funciones.php'); 
 
	//<!--------------- Bloque del cuerpo ----------------->
	$jsondata = array();
	$correo=$_POST['correo'];           
	/*Realiza la consulta para obtener el usuario*/
	$sql = "SELECT email from customersweb where email='".$correo."'" ;
	foreach ($db->query($sql) as $row){                                                   
			$customerid = $row['email'];
	}

	if($customerid!=NULL){
		// Varios destinatarios
		$para  = $correo;

		// título
		$título = 'Contraseña AppDeportesPrueba';

		$sql = "SELECT password from customersweb where email='".$correo."'" ;
		foreach ($db->query($sql) as $row){                                                   
				$pass = $row['password'];
		}	
		// mensaje
		$mensaje = '
		<html>
			<head>
			  <title>Cambio de contraseña</title>
			</head>
		<body>
		  <p>¡Pulse ne le siguiente enlace para realizar un cambio de contraseña!</p>
		  <p>http://appdeportesprueba.esy.es/modifypass.php?correo='.$para.' </p>
		</body>
		</html>
		';

		// Para enviar un correo HTML, debe establecerse la cabecera Content-type
		$email_from = 'appdeportesprueba@gmail.com';
		$cabeceras = 'From: '.$email_from."\r\n".
					'Reply-To: '.$email_from."\r\n" .
					'X-Mailer: PHP/' . phpversion();

		// Enviarlo
		mail($para, $título, $mensaje, $cabeceras);
		
		$message = "En breves recibirá un correo con su contraseña";
		$jsondata["success"] = true;
		$jsondata["data"] = $message;
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
		exit();
	}
	else{
		$message='El correo introducido no esta registrado';
		$error=false;
		$jsondata["success"] = false;
		$jsondata["data"] = $message;
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
		exit();
	}
?>