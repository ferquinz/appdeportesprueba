<html>
<head>
<title></title>
</head>
<body>
<form action="" method="post"></form>
 <?php include 'Formato/conexionsql.php' ?>	
<?php
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}
	if(!isset($_SESSION['conectado']) || $_SESSION['conectado']!=1){  
		header ("Location: login.php");
	}
    $selectOrigen = $_REQUEST["select"];
	$opcionSeleccionada = $_REQUEST["opcion"];
	
	if($selectOrigen == "cmbdeporte")
		echo("  <label for='password'>Categoría:</label>");
		echo "<select name='cmbcategoria' id='cmbcategoria'>";
		echo '<option value="0">Seleccione Categoria</option>';
		$sql = "select name, id_category from category WHERE id_sport = ".$opcionSeleccionada;
		foreach ($db->query($sql) as $row)
		 {				
			 $id_category=$row["id_category"];
			 echo '<option value="'.$id_category.'">'.$row["name"].'</option>';								
		 }		
	echo "</select>";
?>
</body>
</html>