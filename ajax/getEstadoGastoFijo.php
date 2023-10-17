<?php
	require_once ("conexion.php");
	$id_gasto = $_GET['id_gasto'];
	$query_gasto_fijo = "SELECT fijo FROM t_gastos WHERE Id = '$id_gasto';";
	$result_gasto_fijo = mysqli_query($conexion,$query_gasto_fijo);
	if($result_gasto_fijo){
		$row = mysqli_fetch_assoc($result_gasto_fijo);
		echo $row['fijo'];
	}
?>