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
		//$message = $sql;
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
			$origen=$_FILES['archivo']['tmp_name'];
			$destino="trainers/".$idname."/".$_FILES['archivo']['name'];
			redimensionImagen($origen,$destino, $ancho, $alto);
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
		 
		//$message='Actualizacion completada con exito';
		$message = $_FILES['archivo'];
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