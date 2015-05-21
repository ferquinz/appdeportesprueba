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
		$idname = $_POST['correo'];
	
		if(is_dir("trainers/".$idname)){
			$message='Ya existe una carpeta para las imagenes con la ID de entrenador: '.$idname;
			$error=false;
			$jsondata["success"] = $error;
			$jsondata["data"] = $message;
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata, JSON_FORCE_OBJECT);
			exit();
		}else{		
			if(!is_dir("trainers/".$idname)){
				/*Crear carpeta que almacena las imagenes visor*/
				if(!is_dir("trainers")){
					if(!mkdir("trainers", 0700)){
						$message='Error al crear carpeta trainers';
						$error=false;
						$jsondata["success"] = $error;
						$jsondata["data"] = $message;
						header('Content-type: application/json; charset=utf-8');
						echo json_encode($jsondata, JSON_FORCE_OBJECT);
						exit();
					}
				}
			}
			
			/*Crear carpeta que almacena las imagenes visor*/
			if(!mkdir("trainers/".$idname, 0700, true)){
				$message='Error al crear carpeta '.$idname.'';
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
			
			if(isset($_FILES['archivo'])){
				$origen=$_FILES['archivo']['tmp_name'];
				$destino="trainers/".$idname."/".$_FILES['archivo']['name'];
				redimensionImagen($origen,$destino, $ancho, $alto);
			}
			else{
				$origen="images/default/default_trainer.jpg";
				$destino="trainers/".$idname."/default_trainer.jpg";
				redimensionImagen($origen,$destino, $ancho, $alto);
			}
		}																			
		$sql = "INSERT INTO customersweb (firstname, lastname, username, email, phone, password, img_path) VALUES ('".$_POST['nombre']."',
				'".$_POST['apellidos']."','".$_POST['usuario']."','".$_POST['correo']."','".$_POST['tel']."',
				'".md5( $_POST['pass'])."', '".$destino."')" ;
		$db->query($sql);
		 
		$message='Registro completado con exito';
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
		
