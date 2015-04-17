<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
date_default_timezone_set('Europe/Madrid');
$dbhost="mysql.hostinger.es";
$dbname="u669579669_dbnam";
$dbuser="u669579669_user";
$dbpass="a12345678z";
$tabla="training_event";
$db = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
if ($db->connect_errno) {
	die ("<h1>Fallo al conectar a MySQL: (" . $db->connect_errno . ") " . $db->connect_error."</h1>");
}
?>
