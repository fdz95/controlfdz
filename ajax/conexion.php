<?php
$host = "localhost";
$username = "";
$password = "";
$database = "database";
$conexion = mysqli_connect($host,$username,$password,$database);
if (!$conexion){
	die("ERR_CONNECTION</br></br>SERVER_RESPONSE --->  ". mysqli_error($conexion));
}
