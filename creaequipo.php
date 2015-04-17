<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=7,8,9" />
		    <link rel="stylesheet" type="text/css" href="css/Estilo.css"> 
		<META HTTP-EQUIV=Refresh CONTENT="2; URL=index.php">
		
                        
    </head>
<?php include 'Formato/funciones.php' ?>

		 <?php include 'Formato/conexionsql.php' ?>
		<?php
					 	if(!isset($_SESSION)) 
						{ 
							session_start(); 
						}  	
						if(!isset($_SESSION['conectado']) || $_SESSION['conectado']!=1){   
							echo ("Acceso restringido.");
						}else{							
							if(empty($_POST['nombre']) ||
							empty($_POST['pass']) || 
							empty($_POST['cmbdeporte']) || 
							empty($_POST['cmbcategoria'])|| 
							empty($_POST['idname'])){
								echo ("Error al crear el equipo, no están introducidos todos los campos. <br>");
							}else{
									$nombre=$_REQUEST['nombre'];      
									$pass=$_REQUEST['pass'];
									$deporte=$_REQUEST['cmbdeporte'];      
									$categoria=$_REQUEST['cmbcategoria']; 
									$idname=$_REQUEST['idname']; 																								
									
										if(is_dir("teams/".$idname))
										{
											echo ("Ya existe una carpeta para las imagenes con la ID de ese equipo. Error al añadir el equipo a la bd. <br/>");
										}else{							 
											/*Crear carpeta que almacena las imagenes visor*/
											if(!mkdir("teams/".$idname, 0777)){
												echo("Error al crear carpeta.<br/>");
											}	
											
											if(!mkdir("teams/".$idname."/img" , 0777)){
												echo("Error al crear carpeta.<br/>");
											}	
											
											$origen=$_FILES['archivo']['tmp_name'];
																				
											$destino="teams/".$idname."/img/".$_FILES['archivo']['name'];											
											
											/*Almacenar imagenes redimensionadas (thumbs)*/
											$ancho=250;
											$alto=250;	
											
											$sql = "INSERT INTO team (name, id_category, password, img_path, id_sport, idname) VALUES ('".$nombre."','".$categoria."','".$pass."','".$destino."','".$deporte."','".$idname."')" ;
											$db->query($sql); 
											
											
											$sql = "INSERT INTO customersweb_team (id_customer, id_team) VALUES (".$_SESSION['id_customer'].",".$db->lastInsertId('id_team').")" ;
											$db->query($sql); 
											
											redimensionImagen ($origen,$destino, $ancho, $alto);
											
											
								?>
											<p>Equipo añadido con exito a la bd. </p>
											<hr> El navegador se redireccionará en dos segundos... </hr>
								<?php 
											}										
									//}						   
									/*Cierra la conexion con la base de datos*/
									$db=NULL;
															
								?>  
				<?php
							}
						}
				?>

    </body>