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
		  <title>Recordatorio de cumpleaños para Agosto</title>
		</head>
		<body>
		  <p>¡Estos son los cumpleaños para Agosto!</p>
		  <table>
			<tr>
			  <th>Quien</th><th>Día</th><th>Mes</th><th>Año</th>
			</tr>
			<tr>
			  <td>Joe</td><td>3</td><td>Agosto</td><td>1970</td>
			</tr>
			<tr>
			  <td>Sally</td><td>17</td><td>Agosto</td><td>1973</td>
			</tr>
		  </table>
		</body>
		</html>
		';

		// Para enviar un correo HTML, debe establecerse la cabecera Content-type
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Cabeceras adicionales
		$cabeceras .= "To: '".$correo."'" . "\r\n";
		$cabeceras .= 'From: <appdeportesprueba@gmail.com>' . "\r\n";
		$cabeceras .= 'Cc: appdeportesprueba@gmail.com' . "\r\n";

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