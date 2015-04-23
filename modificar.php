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
		$message='El correo introducido ya existe';
		$error=false;
		$jsondata["success"] = $error;
		$jsondata["data"] = $message;
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
		exit();
	}
	else{
		$pass = $_POST['password'];		
																		
		$sql = "UPDATE customersweb SET password = '".md5( $_POST['password'])."'";
		$db->query($sql);
		 
		$message='Modificación completado con exito';
		$error=true;
		
		/*Realiza la consulta para obtener el usuario que acabamos de insertar*/
		$sql = "SELECT password, email, firstname, id_customer from customersweb where email='".$_POST['correo']."' AND password='".md5( $_POST['pass'])."'" ; 
		/*echo($sql);*/
		foreach ($db->query($sql) as $row){
				$nombre = $row['firstname'];
				$id_customer = $row['id_customer'];
		} 
		  /**************************************************************************
				 CREAMOS UNA SESION PARA QUE APAREZCA COMO CONECTADO EL USUARIO
		 **************************************************************************/
		 /*Almacenamos en la sesion el nombre de usuario para que no se pierda al pulsar submit (se recarga la pagina y se pierden los datos obtenidos)*/
		if(!isset($_SESSION)){ 
			session_start(); 
		}  
		/*echo("Consulta");*/
		$_SESSION['conectado']=1;
		$_SESSION['user']=$nombre;
		$_SESSION['id_customer']=$id_customer;
		
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