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
		if(empty($_POST['player'])){
			$message='Error al pasar parametros';
			$error=false;
			$jsondata["success"] = $error;
			$jsondata["data"] = $message;
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata, JSON_FORCE_OBJECT);
			exit();	
		}else{
			$player=$_POST['player'];      																								

			$sql = "DELETE FROM customersweb_team  WHERE id_customer =".$player." AND id_team=".$_SESSION['id_team']."";
			$db->query($sql);
			
			$sql = "DELETE FROM customersweb_players WHERE id_customer = ".$player."" ;
			$db->query($sql);
			
			$sql = "DELETE FROM customersweb WHERE id_customer = ".$player."" ;
			$db->query($sql); 	
			
			$sql = "SELECT id_training FROM training_event WHERE id_team = ".$_SESSION['id_team']."" ;
			foreach ($db->query($sql) as $row)
			{
				$sql1 = "SELECT id_training_player FROM training_player WHERE id_training = ".$row['id_training']." AND id_customer=".$player."" ;
				foreach ($db->query($sql1) as $row1)
				{
					$sql2 = "DELETE FROM training_data WHERE id_training_player = ".$row1['id_training_player']."" ;
					$db->query($sql2);
				}
				$sql1 = "DELETE FROM training_player WHERE id_training = ".$row['id_training']." AND id_customer=".$player."" ;
				$db->query($sql1);
			}

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

?>