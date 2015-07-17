<?php 

	include('Formato/conexionsql.php');   
	include('Formato/funciones.php'); 
 
	//Comprobamos si existe la session
	if(!isset($_SESSION)){ 
		session_start();
	}  	
	if(!isset($_SESSION['conectado']) || $_SESSION['conectado']!=1){   
		$message='Acceso restringido';
		$error=false;
		$jsondata["success"] = $error;
		$jsondata["data"] = $message;
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
		exit();
	}
	
	//<!--------------- Bloque del cuerpo ----------------->
	$jsondata = array();
	$correo=$_POST['correo'];           
	/*Realiza la consulta para obtener el usuario*/
	$sql = "SELECT email from customersweb where email='".$correo."' AND id_customer <> '".$_SESSION['id_customer']."'" ;
	foreach ($db->query($sql) as $row){                                                   
			$customemail = $row['email'];		
	}

	if($customemail!=NULL){
		$message='El correo introducido ya existe';
		$error=false;
		$jsondata["success"] = $error;
		$jsondata["data"] = $message;
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
		exit();
	}
	else{
		$sql = "SELECT img_path FROM customersweb WHERE id_customer = '".$_SESSION['id_customer']."'" ;
		foreach ($db->query($sql) as $row){                                                   
				$destino = $row['img_path'];		
		}
	
		$idname = $_POST['correo'];

		/*Almacenar imagenes redimensionadas (thumbs)*/
		$ancho=250;
		$alto=250;	
		
		if(isset($_FILES['archivo'])){
			$file_size = $_FILES['archivo']['size'];
			$acceptable = array(
				'image/jpeg',
				'image/jpg',
				'image/gif',
				'image/png'
			);

			if ($file_size > 1048576){      
				$message = 'Archivo demasiado grande. La imagen debe ser menor de un 1 megabytes.'; 
				$error=false;
				$jsondata["success"] = $error;
				$jsondata["data"] = $message;
				header('Content-type: application/json; charset=utf-8');
				echo json_encode($jsondata, JSON_FORCE_OBJECT);
				exit();
			}
			if((!in_array($_FILES['archivo']['type'], $acceptable)) && (!empty($_FILES['archivo']['type']))) {
				$message = 'Tipo de archivo invalido. Solo son validos los tipo JPG, JPEG, PNG y GIF.'; 
				$error=false;
				$jsondata["success"] = $error;
				$jsondata["data"] = $message;
				header('Content-type: application/json; charset=utf-8');
				echo json_encode($jsondata, JSON_FORCE_OBJECT);
				exit();
			}
			
			//Borramos todas las imagenes previas del usuario
			$dir = "trainers/".$idname."/"; 
			$handle = opendir($dir); 
			while ($file = readdir($handle)){   
				if (is_file($dir.$file)){
					unlink($dir.$file);
				}
			} 
			//Guardamos la imagen redimensionada
			$origen=$_FILES['archivo']['tmp_name'];
			//Guardamos el tamaño real de la imagen
			list($width, $height) = getimagesize($origen);
			$destino="trainers/".$idname."/".$_FILES['archivo']['name'];
			redimensionImagen($origen, $destino, $ancho, $alto);
		}
		
		if($_POST['password'] <> ""){
			$sql = " UPDATE customersweb SET firstname = '".$_POST['nombre']."', lastname = '".$_POST['apellidos']."', username = '".$_POST['username']."', email = '".$_POST['correo']."', 
						phone = '".$_POST['telefono']."', password = '".md5( $_POST['password'])."', img_path = '".$destino."' WHERE id_customer = '".$_SESSION['id_customer']."'";
		}
		else{
			$sql = " UPDATE customersweb SET firstname = '".$_POST['nombre']."', lastname = '".$_POST['apellidos']."', username = '".$_POST['username']."', email = '".$_POST['correo']."', 
						phone = '".$_POST['telefono']."', img_path = '".$destino."' WHERE id_customer = '".$_SESSION['id_customer']."'";
		}
		
		$db->query($sql);
		 
		$message='Actualizacion completada con exito';
		$error=true;
			
		/*Cierra la conexion con la base de datos*/
		$db=NULL;

	}
   
	/*Cierra la conexion con la base de datos*/
	$db=NULL;
	
	$jsondata["success"] = $error;
	$jsondata["data"] = $message;
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
	exit();
?>  