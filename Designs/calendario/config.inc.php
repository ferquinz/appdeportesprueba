<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
date_default_timezone_set('Europe/Madrid');
$dbhost="mysql7.000webhost.com";
$dbname="a8982599_dbname";
$dbuser="a8982599_user";
$dbpass="a12345678z";
$tabla="tcalendario";
$db = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
if ($db->connect_errno) {
	die ("<h1>Fallo al conectar a MySQL: (" . $db->connect_errno . ") " . $db->connect_error."</h1>");
}
?>
