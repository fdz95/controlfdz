<?php
$host = "localhost";
$username = "user-fdz";
$password = "Tt>#Y=HaFFYB5vx";
$database = "database_fdz";
$conexion = mysqli_connect($host,$username,$password,$database);
if (!$conexion){
	die("ERR_CONNECTION</br></br>SERVER_RESPONSE --->  ". mysqli_error($conexion));
}