<?php

header('Content-Type: application/json');
	
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	error_reporting(-1);
	
	include('Formato/conexionsql.php');   
	include('Formato/funciones.php'); 
	
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
	else{							
		if(empty($_POST['team'])){
			$message='Error al crear el equipo, no están introducidos todos los campos';
			$error=false;
			$jsondata["success"] = $error;
			$jsondata["data"] = $message;
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata, JSON_FORCE_OBJECT);
			exit();	
		}else{
			$equipo=$_POST['team'];      																								

			$sql = "SELECT name FROM team WHERE id_team = ".$equipo."" ;
			foreach ($db->query($sql) as $row)
			{
				$ruta = "teams/".$row['name']."";
				eliminarDir($ruta);
			}
			
			$sql = "DELETE FROM team WHERE id_team = ".$equipo."" ;
			$db->query($sql); 	
			
			$sql = "DELETE FROM customersweb_team  WHERE id_team =".$equipo."" ;
			$db->query($sql); 
			
			
			
			$message='Eliminacion completada con exito';
			$error=true;
		}														   
		/*Cierra la conexion con la base de datos*/
		$db=NULL;
		$jsondata["success"] = $error;
		$jsondata["data"] = $message;
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
		exit();
		
	}
	
	
	function eliminarDir($carpeta)
	{
		foreach(glob($carpeta . "/*") as $archivos_carpeta)
		{
			//echo $archivos_carpeta;
	 
			if (is_dir($archivos_carpeta))
			{
				eliminarDir($archivos_carpeta);
			}
			else
			{
				unlink($archivos_carpeta);
			}
		}
	 
		rmdir($carpeta);
	}

?>