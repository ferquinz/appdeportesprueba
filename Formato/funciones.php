<?php
	function redimensionImagen ($pathOri, $pathDest, $miniatura_ancho_maximo, $miniatura_alto_maximo){
		
		/*$miniatura_ancho_maximo = 150;
		$miniatura_alto_maximo = 150;*/
		$info_imagen = getimagesize($pathOri);
		$imagen_ancho = $info_imagen[0];
		$imagen_alto = $info_imagen[1];
		$imagen_tipo = $info_imagen['mime'];

		$proporcion_imagen = $imagen_ancho / $imagen_alto;
		$proporcion_miniatura = $miniatura_ancho_maximo / $miniatura_alto_maximo;

		if ( $proporcion_imagen > $proporcion_miniatura ){
		  $miniatura_ancho = $miniatura_alto_maximo * $proporcion_imagen;
		  $miniatura_alto = $miniatura_alto_maximo;
		} else if ( $proporcion_imagen < $proporcion_miniatura ){
		  $miniatura_ancho = $miniatura_ancho_maximo;
		  $miniatura_alto = $miniatura_ancho_maximo / $proporcion_imagen;
		} else {
		  $miniatura_ancho = $miniatura_ancho_maximo;
		  $miniatura_alto = $miniatura_alto_maximo;
		}
		$x = ( $miniatura_ancho - $miniatura_ancho_maximo ) / 2;
		$y = ( $miniatura_alto - $miniatura_alto_maximo ) / 2;
		switch ( $imagen_tipo ){
		  case "image/jpg":
		  case "image/jpeg":
			$imagen = imagecreatefromjpeg( $pathOri );
			break;
		  case "image/png":
			$imagen = imagecreatefrompng( $pathOri );
			break;
		  case "image/gif":
			$imagen = imagecreatefromgif( $pathOri );
			break;
		}
		$lienzo = imagecreatetruecolor( $miniatura_ancho_maximo, $miniatura_alto_maximo );
		$lienzo_temporal = imagecreatetruecolor( $miniatura_ancho, $miniatura_alto );
		imagecopyresampled($lienzo_temporal, $imagen, 0, 0, 0, 0, $miniatura_ancho, $miniatura_alto, $imagen_ancho, $imagen_alto);
		imagecopy($lienzo, $lienzo_temporal, 0,0, $x, $y, $miniatura_ancho_maximo, $miniatura_alto_maximo);
		imagejpeg($lienzo, $pathDest, 80);	
	}		
?>