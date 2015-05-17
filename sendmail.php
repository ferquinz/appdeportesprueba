<?php
	include('Formato/conexionsql.php');   
	include('Formato/funciones.php'); 
	//error_reporting(E_ALL);
	//require_once("class.phpmailer.php");
	//include("PHPMailerAutoload.php"); //Incluimos la clase phpmailer
	//include("class.phpmailer.php"); 
	//include("class.smtp.php"); 
	require "class.phpmailer.php";
	require "class.smtp.php";

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
		$mensaje = "
			<html>
				<head>
					<title>Cambio de contraseña</title>
				</head>
				<body>
					<p>¡Pulse ne le siguiente enlace para realizar un cambio de contraseña!</p>
					<table width='100%' cellspacing='0'>
						<tr>
							<td>
								<div style='text-align: left; font-family: calibri; font-size: 13pt;'>
									<img src='../images/Logos/LogoV2.jpg' alt='Logo' border='0' style='margin: 0; padding: 0; padding-botton:10px;'/>
										<br><br>
										<b><p>http://appdeportesprueba.esy.es/modifypass.php?correo='".$para."' </p></b><br>
									</div>
							</td>
						</tr>
					</table>
					<br>
					<br><b><i>Por favor no responda a este mensaje</i></b><br>
				</body>
			</html>
		";

					
		// Para enviar un correo HTML, debe establecerse la cabecera Content-type
		$email_from = 'appdeportesprueba@gmail.com';
		
		// Cabecera que especifica que es un HMTL
		// $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		// $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$cabeceras = 'From: '.strip_tags($email_from).'\r\n';
		$cabeceras .= 'Reply-To: '.strip_tags($email_from).'\r\n';
		$cabeceras .= 'MIME-Version: 1.0\r\n';
		$cabeceras .= 'Content-Type: text/html; charset=ISO-8859-1\r\n';
		$cabeceras .= 'X-Mailer: PHP/' . phpversion();
		
		// Cabeceras adicionales
		// $cabeceras = 'From: '.$email_from."\r\n".
					// 'Reply-To: '.$email_from."\r\n" .
					// 'X-Mailer: PHP/' . phpversion();

		// Enviarlo
		mail($para, $título, $mensaje, $cabeceras);
		
 
		// $mail = new PHPMailer(true); // Declaramos un nuevo correo, el parametro true significa que mostrara excepciones y errores.
		// $mail->Mailer = "smtp";
		// $mail->IsSMTP(); // Se especifica a la clase que se utilizará SMTP
 
		// try {
			// //------------------------------------------------------
			// $correo_emisor="appdeportesprueba@gmail.com";     	//Correo a utilizar para autenticarse
			// //$correo_emisor="appdeportesprueba@appdeportesprueba.esy.es";     	
			// //con Gmail o en caso de GoogleApps utilizar con @tudominio.com
			// $nombre_emisor="AppDeportesPrueba";               	//Nombre de quien envía el correo
			// $contrasena="a12345678z";          					//contraseña de tu cuenta en Gmail
			// $correo_destino=$correo;      						//Correo de quien recibe
			// $nombre_destino="Usuario";                					//Nombre de quien recibe
			// //--------------------------------------------------------
			// $mail->SMTPDebug  = 4;                     	// Habilita información SMTP (opcional para pruebas)
														// // 1 = errores y mensajes
														// // 2 = solo mensajes
			// $mail->SMTPAuth   = true;                  // Habilita la autenticación SMTP
			// //$mail->SMTPSecure = 'ssl';                 // Establece el tipo de seguridad SMTP
			// $mail->SMTPSecure = '';                 
			// //$mail->Host       = 'smtp.gmail.com';      // Establece Gmail como el servidor SMTP
			// $mail->Host		  = 'mx1.hostinger.es';	
			// //$mail->Port       = 465;                   // Establece el puerto del servidor SMTP de Gmail
			// $mail->Port       = 2525;                   
			// $mail->Username   = $correo_emisor;  	     // Usuario Gmail
			// $mail->Password   = $contrasena;           // Contraseña Gmail
			// //A que dirección se puede responder el correo
			// //$mail->AddReplyTo($correo_emisor, $nombre_emisor);
			// //La direccion a donde mandamos el correo
			// $mail->AddAddress($correo_destino, $nombre_destino);
			// //De parte de quien es el correo
			// $mail->SetFrom($correo_emisor, $nombre_emisor);
			// //Asunto del correo
			// $mail->Subject = 'Cambio Contraseña';
			// //Mensaje alternativo en caso que el destinatario no pueda abrir correos HTML
			// $mail->AltBody = 'Para ver el mensaje necesita un cliente de correo compatible con HTML.';
			// //El cuerpo del mensaje, puede ser con etiquetas HTML
			// $mail->MsgHTML("
				// <html>
					// <head>
						// <title>Cambio de contraseña</title>
					// </head>
					// <body>
						// <p>¡Pulse ne le siguiente enlace para realizar un cambio de contraseña!</p>
						// <table width='100%' cellspacing='0'>
							// <tr>
								// <td>
									// <div style='text-align: left; font-family: calibri; font-size: 13pt;'>
										// <img src='../images/Logos/LogoV2.jpg' alt='Logo' border='0' style='margin: 0; padding: 0; padding-botton:10px;'/>
										// <br><br>
										// <b><p>http://appdeportesprueba.esy.es/modifypass.php?correo='.$para.' </p></b><br>
									// </div>
								// </td>
							// </tr>
						// </table>
						// <br>
						// <br><b><i>Por favor no responda a este mensaje</i></b><br>
					// </body>
				// </html>");
			// //Enviamos el correo
			// $mail->Send();
			  
			// $message = "En breves recibirá un correo con su contraseña";
			// $jsondata["success"] = true;
			// $jsondata["data"] = $message;
			// header('Content-type: application/json; charset=utf-8');
			// echo json_encode($jsondata, JSON_FORCE_OBJECT);
			// exit();
		// } catch (phpmailerException $e) {
			// echo '<script type="text/javascript">alert("'.$e->errorMessage().'");</script>'; //Errores de PhpMailer
		// } catch (Exception $e) {
			// echo '<script type="text/javascript">alert("'.$e->errorMessage().'");</script>'; //Errores de cualquier otra cosa.
		// }		
	

		// $mail = new phpmailer();
		// $mail->IsSendmail();
		// $mail->Mailer = "smtp";
		// $mail->IsSMTP();
		// $mail->SMTPDebug = 1;
		// $mail->Host = 'mx1.hostinger.es';
		// $mail->Port = 2525;
		// $mail->SMTPAuth = true;
		// $mail->Username = 'appdeportesprueba@appdeportesprueba.esy.es';
		// $mail->Password = 'a12345678z';
		// $mail->SMTPSecure = '';
		
		// $mail->AddAddress($correo, 'Usuario');
		// $mail->SetFrom('appdeportesprueba@gmail.com', 'Aplicacion');
		// $mail->Subject = 'Cambio Contraseña';
		// $mail->AltBody = 'Para ver el mensaje necesita un cliente de correo compatible con HTML.';
		// $mail->MsgHTML("
			// <html>
				// <head>
					// <title>Cambio de contraseña</title>
				// </head>
				// <body>
					// <p>¡Pulse ne le siguiente enlace para realizar un cambio de contraseña!</p>
					// <table width='100%' cellspacing='0'>
						// <tr>
							// <td>
								// <div style='text-align: left; font-family: calibri; font-size: 13pt;'>
									// <img src='../images/Logos/LogoV2.jpg' alt='Logo' border='0' style='margin: 0; padding: 0; padding-botton:10px;'/>
									// <br><br>
									// <b><p>http://appdeportesprueba.esy.es/modifypass.php?correo='.$para.' </p></b><br>
								// </div>
							// </td>
						// </tr>
					// </table>
					// <br>
					// <br><b><i>Por favor no responda a este mensaje</i></b><br>
				// </body>
			// </html>");
		// $mail->Send();
		
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