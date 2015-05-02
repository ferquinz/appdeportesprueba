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
		if(empty($_POST['nombre']) || empty($_POST['password']) || empty($_POST['cmbdeporte']) || empty($_POST['cmbcategoria'])|| empty($_POST['idname'])){
			$message='Error al crear el equipo, no están introducidos todos los campos';
			$error=false;
			$jsondata["success"] = $error;
			$jsondata["data"] = $message;
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata, JSON_FORCE_OBJECT);
			exit();	
		}else{
			$nombre=$_POST['nombre'];      
			$pass=$_POST['password'];
			$deporte=$_POST['cmbdeporte'];      
			$categoria=$_POST['cmbcategoria']; 
			$idname=$_POST['idname']; 																								
				
			if(is_dir("teams/".$idname)){
				$message='Ya existe una carpeta para las imagenes con la ID de ese equipo.';
				$error=false;
				$jsondata["success"] = $error;
				$jsondata["data"] = $message;
				header('Content-type: application/json; charset=utf-8');
				echo json_encode($jsondata, JSON_FORCE_OBJECT);
				exit();	
			}else{							 
				/*Crear carpeta que almacena las imagenes visor*/
				if(!mkdir("teams/".$idname, 0777)){
					$message='Error al crear carpeta.';
					$error=false;
					$jsondata["success"] = $error;
					$jsondata["data"] = $message;
					header('Content-type: application/json; charset=utf-8');
					echo json_encode($jsondata, JSON_FORCE_OBJECT);
					exit();	
				}	
				
				if(!mkdir("teams/".$idname."/img" , 0777)){
					$message='Error al crear carpeta.';
					$error=false;
					$jsondata["success"] = $error;
					$jsondata["data"] = $message;
					header('Content-type: application/json; charset=utf-8');
					echo json_encode($jsondata, JSON_FORCE_OBJECT);
					exit();
				}	
								
				/*Almacenar imagenes redimensionadas (thumbs)*/
				$ancho=250;
				$alto=250;	
				
				/*$origen="images/default/default_trainer.jpg";
				$destino="teams/".$idname."/img/default_trainer.jpg";

				redimensionImagen($origen,$destino, $ancho, $alto);*/
				if(empty($_FILES['imagen']['tmp_name'])){
					$origen=$_FILES['imagen']['tmp_name'];								
					$destino="teams/".$idname."/img/".$_FILES['imagen']['name'];
					redimensionImagen($origen,$destino, $ancho, $alto);
				}
				else{
					$origen="images/default/default_trainer.jpg";
					$destino="teams/".$idname."/img/default_trainer.jpg";
					redimensionImagen($origen,$destino, $ancho, $alto);
				}
			}
				
			$sql = "INSERT INTO team (name, id_category, password, img_path, id_sport, idname) VALUES ('".$nombre."','".$categoria."','".$pass."','".$destino."','".$deporte."','".$idname."')" ;
			$db->query($sql); 	
			
			$sql = "INSERT INTO customersweb_team (id_customer, id_team) VALUES (".$_SESSION['id_customer'].",".$db->lastInsertId('id_team').")" ;
			$db->query($sql); 
			
			$message='Registro completado con exito';
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
