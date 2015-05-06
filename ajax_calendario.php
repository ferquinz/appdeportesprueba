<?php include 'mobile/funciones/GoogleCloudMessaging.php' ?>
<?php
error_reporting(-1);
require_once("config.inc.php");

//Comprueba si esta conectado
if(!isset($_SESSION)) 
{ 
	session_start(); 
}  	
if(!isset($_SESSION['conectado']) || $_SESSION['conectado']!=1){  
	header ("Location: login.php");
}		

function fecha ($valor)
{
	$timer = explode(" ",$valor);
	$fecha = explode("-",$timer[0]);
	$fechex = $fecha[2]."/".$fecha[1]."/".$fecha[0];
	return $fechex;
}

function buscar_en_array($fecha,$array)
{
	$total_eventos=count($array);
	for($e=0;$e<$total_eventos;$e++)
	{
		if ($array[$e]["fecha"]==$fecha) return true;
	}
}

switch ($_GET["accion"])
{
	case "listar_evento":
	{
		//$query=$db->query("select * from ".$tabla." where fecha='".$_GET["fecha"]."' order by id asc");
		//$query=$db->query("select * from ".$tabla." where fecha='".$_GET["fecha"]."' AND id_customer=".$_SESSION['id_customer']." order by id asc");
		//$query=$db->query("select * from ".$tabla." where fecha='".$_GET["fecha"]."' AND id_customer=".$_SESSION['id_customer']."
		$query=$db->query("select title, place, hour_training, description, id_training from ".$tabla." where training_date='".$_GET["fecha"]."' AND id_customer=".$_SESSION['id_customer']."
		AND id_team=".$_SESSION['id_team']." order by id_training asc");
		if ($fila=$query->fetch_array())
		{
			do
			{
				echo "<p>".$fila["title"]."</p>";
				echo "<p>".$fila["place"]."</p>";
				echo "<p>".$fila["hour_training"]."</p>";
				echo "<p>".$fila["description"]."<a href='#' class='eliminar_evento' rel='".$fila["id_training"]."' title='Eliminar este Evento del ".fecha($_GET["fecha"])."'><img src='images/delete.png'></a></p>";
			}
			while($fila=$query->fetch_array());
		}
		break;
	}
	case "guardar_evento":
	{
		//$query=$db->query("insert into ".$tabla." (fecha,evento) values ('".$_GET["fecha"]."','".strip_tags($_GET["evento"])."')");
		//$query=$db->query("insert into ".$tabla." (fecha,evento, id_customer) values ('".$_GET["fecha"]."','".strip_tags($_GET["evento"])."',".$_SESSION['id_customer'].")");
		$query=$db->query("insert into ".$tabla." (training_date,description, id_customer, id_team, title, place, hour_training) values ('".$_GET["fecha"]."','".strip_tags($_GET["evento"])."',".$_SESSION['id_customer']."
		,".$_SESSION['id_team'].",'".$_GET["title"]."','".$_GET["place"]."','".$_GET["hour_training"]."')");
		
		if ($query){
			echo "<p class='ok'>Evento guardado correctamente.</p>";
			
			//Envia la notificacion a todos los moviles asociados al equipo
			$date=date_create($_GET["fecha"]);
			$msg="calendar$".$db->insert_id."$".$_SESSION['team_name']."$".date_format($date, 'd-m-Y')."$".$_GET["place"];
	
			//include 'gcmMessageTeam.php';
			$page = file_get_contents("http://appdeportesprueba.esy.es/mobile/gcmMessageTeam.php?msg=".$msg."&idTeam=".$_SESSION['id_team']);

		}else echo "<p class='error'>Se ha producido un error guardando el evento.</p>";
	
		break;
	}
	case "borrar_evento":
	{
		$query=$db->query("delete from ".$tabla." where id_training='".$_GET["id"]."' limit 1");		
		if ($query) echo "<p class='ok'>Evento eliminado correctamente.</p>";
		else echo "<p class='error'>Se ha producido un error eliminando el evento.</p>";
		break;
	}
	case "generar_calendario":
	{
		$fecha_calendario=array();
		if ($_GET["mes"]=="" || $_GET["anio"]=="") 
		{
			$fecha_calendario[1]=intval(date("m"));
			if ($fecha_calendario[1]<10) $fecha_calendario[1]="0".$fecha_calendario[1];
			$fecha_calendario[0]=date("Y");
		} 
		else 
		{
			$fecha_calendario[1]=intval($_GET["mes"]);
			if ($fecha_calendario[1]<10) $fecha_calendario[1]="0".$fecha_calendario[1];
			else $fecha_calendario[1]=$fecha_calendario[1];
			$fecha_calendario[0]=$_GET["anio"];
		}
		$fecha_calendario[2]="01";
		
		/* obtenemos el dia de la semana del 1 del mes actual */
		$primeromes=date("N",mktime(0,0,0,$fecha_calendario[1],1,$fecha_calendario[0]));
			
		/* comprobamos si el año es bisiesto y creamos array de días */
		if (($fecha_calendario[0] % 4 == 0) && (($fecha_calendario[0] % 100 != 0) || ($fecha_calendario[0] % 400 == 0))) $dias=array("","31","29","31","30","31","30","31","31","30","31","30","31");
		else $dias=array("","31","28","31","30","31","30","31","31","30","31","30","31");
		
		$eventos=array();
		//$query=$db->query("select fecha,count(id) as total from ".$tabla." where month(fecha)='".$fecha_calendario[1]."' and year(fecha)='".$fecha_calendario[0]."' group by fecha");
		$query=$db->query("select training_date,count(id_training) as total from ".$tabla." where month(training_date)='".$fecha_calendario[1]."' and year(training_date)='".$fecha_calendario[0]."'
			AND id_customer=".$_SESSION['id_customer']."
			AND id_team=".$_SESSION['id_team']." group by training_date");
		
		if ($fila=$query->fetch_array())
		{
			do
			{
				$eventos[$fila["training_date"]]=$fila["total"];
			}
			while($fila=$query->fetch_array());
		}
		
		$meses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		
		/* calculamos los días de la semana anterior al día 1 del mes en curso */
		$diasantes=$primeromes-1;
			
		/* los días totales de la tabla siempre serán máximo 42 (7 días x 6 filas máximo) */
		$diasdespues=42;
			
		/* calculamos las filas de la tabla */
		$tope=$dias[intval($fecha_calendario[1])]+$diasantes;
		if ($tope%7!=0) $totalfilas=intval(($tope/7)+1);
		else $totalfilas=intval(($tope/7));
			
		/* empezamos a pintar la tabla */
		if (isset($mostrar)) echo $mostrar;
			
		echo "<table class='calendario' cellspacing='0' cellpadding='0'>";
			echo "<tr><th colspan='7'> ".$meses[intval($fecha_calendario[1])]." de ".$fecha_calendario[0]." </th></tr>
			<tr><th>Lunes</th><th>Martes</th><th>Mi&eacute;rcoles</th><th>Jueves</th><th>Viernes</th><th>S&aacute;bado</th><th>Domingo</th></tr><tr>";
			
			/* inicializamos filas de la tabla */
			$tr=0;
			$dia=1;
			
			function es_finde($fecha)
			{
				$cortamos=explode("-",$fecha);
				$dia=$cortamos[2];
				$mes=$cortamos[1];
				$ano=$cortamos[0];
				$fue=date("w",mktime(0,0,0,$mes,$dia,$ano));
				if (intval($fue)==0 || intval($fue)==6) return true;
				else return false;
			}
			
			for ($i=1;$i<=$diasdespues;$i++)
			{
				if ($tr<$totalfilas)
				{
					if ($i>=$primeromes && $i<=$tope) 
					{
						echo "<td class='";
						/* creamos fecha completa */
						if ($dia<10) $dia_actual="0".$dia; else $dia_actual=$dia;
						$fecha_completa=$fecha_calendario[0]."-".$fecha_calendario[1]."-".$dia_actual;
						
						if (intval($eventos[$fecha_completa])>0) 
						{
							echo "evento";
							$hayevento=$eventos[$fecha_completa];
						}
						else $hayevento=0;
						
						/* si es hoy coloreamos la celda */
						if (date("Y-m-d")==$fecha_completa) echo " hoy";
						
						echo "'>";
						
						/* recorremos el array de eventos para mostrar los eventos del día de hoy */
						if ($hayevento>0) echo "<a href='#' data-evento='#evento".$dia_actual."' class='modal' style='position: static !important; display: block !important;' rel='".$fecha_completa."' title='Hay ".$hayevento." eventos'>".$dia."</a>";
						else echo "$dia";
						
						/* agregamos enlace a nuevo evento si la fecha no ha pasado */
						//if (date("Y-m-d")<=$fecha_completa && es_finde($fecha_completa)==false) echo "<a href='#' data-evento='#nuevo_evento' title='Agregar un Evento el ".fecha($fecha_completa)."' class='add agregar_evento' rel='".$fecha_completa."'>&nbsp;</a>";
						if (date("Y-m-d")<=$fecha_completa) 
							echo "<a href='#' data-evento='#nuevo_evento' title='Agregar un Evento el ".fecha($fecha_completa)."' class='add agregar_evento' rel='".$fecha_completa."'>&nbsp;</a>";
						
						echo "</td>";
						$dia+=1;
					}
					else echo "<td class='desactivada'>&nbsp;</td>";
					if ($i==7 || $i==14 || $i==21 || $i==28 || $i==35 || $i==42) {echo "<tr>";$tr+=1;}
				}
			}
			echo "</table>";
			
			$mesanterior=date("Y-m-d",mktime(0,0,0,$fecha_calendario[1]-1,01,$fecha_calendario[0]));
			$messiguiente=date("Y-m-d",mktime(0,0,0,$fecha_calendario[1]+1,01,$fecha_calendario[0]));
			//echo "<p class='toggle'>&laquo; <a href='#' rel='$mesanterior' class='anterior'>Mes Anterior</a> - <a href='#' class='siguiente' rel='$messiguiente'>Mes Siguiente</a> &raquo;</p>";
			/*echo "<p class='toggle'>&laquo; <a href='#' rel='$mesanterior' class='anterior'>Mes Anterior</a> - 
			<a href='#' class='siguiente' rel='$messiguiente'>Mes Siguiente</a> &raquo;
			<br> ".$meses[intval($fecha_calendario[1])]." de ".$fecha_calendario[0]."
			</p>";*/
			echo "<p class='toggle'>&laquo; <a href='#' rel='$mesanterior' class='anterior'>Mes Anterior</a> - 
			<a href='#' class='siguiente' rel='$messiguiente'>Mes Siguiente</a> &raquo;</p>";
			
			//echo "<h2>Calendario de Eventos para: ".$meses[intval($fecha_calendario[1])]." de ".$fecha_calendario[0]." <abbr title='S&oacute;lo se pueden agregar eventos en d&iacute;as h&aacute;biles y en fechas futuras (o la fecha actual).'>(?)</abbr></h2>";

		break;
	}
}
?>