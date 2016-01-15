 <?php include 'Formato/conexionsql.php' ?>		

<?php
	$noLogin=0;
	if(!isset($_REQUEST['email']) || empty($_REQUEST['email']) ||
	  !isset($_REQUEST['password']) || empty($_REQUEST['password'])){
		$noLogin=1;
	
	}
	/**
	 * Devuelve 1 si se conecta
	 *			2 si no se ha introducido algún campo
	 *		    3 si el usuario (correo) o contraseña son incorrectos
	 */
	if($noLogin!=1){
		/*Recogemos los datos introducidos por el usuario para iniciar sesión*/
		$email=$_REQUEST['email'];  
		$contrasenia = md5($_REQUEST['password']); 
		$passAux=NULL;
		$customerid;
		/*Realiza la consulta para obtener el usuario*/
		$sql = "SELECT password, email, firstname, id_customer from customersweb where mister = 1 AND email='".$email."' AND password='".$contrasenia."'" ;
	 
		foreach ($db->query($sql) as $row)
		{
				$passAux= $row['password'];
				$customerid = $row['email'];
				$nombre = $row['firstname'];
				$id_customer = $row['id_customer'];
		}
		 if (strcmp($contrasenia,$passAux)==0){  
			  /**************************************************************************
					 CREAMOS UNA SESION PARA QUE APAREZCA COMO CONECTADO EL USUARIO
			 **************************************************************************/
			  /*Almacenamos en la sesion el nombre de usuario para que no se pierda al pulsar submit (se recarga la pagina y se pierden los datos obtenidos)*/
			if(!isset($_SESSION)) 
			{ 
				session_start(); 
			}  
			
			$_SESSION['conectado']=1;
			
			$_SESSION['user']=$nombre;
			
			$_SESSION['id_customer']=$id_customer;
			
			echo("1");
		}else{
			 echo("3");
		}
	}else{
		 echo("2");
	}
											   
?>
                                             
	  
		
