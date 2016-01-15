<?php

    /*Establece la conexion con la base de datos*/
    try {	   
		/*Producción*/
		/*$db = new PDO("mysql:host=mysql.hostinger.es;dbname=u669579669_dbnam", "u669579669_user", "a12345678z");*/
		
		/*Local*/
		$db = new PDO("mysql:host=localhost;dbname=appdeportespruebalocal", "root", "");
		
        /*** use the database connection ***/
    }catch(PDOException $e)
    {
        echo $e->getMessage();
    }	
	
                                            
?>