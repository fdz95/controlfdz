<?php
	require_once ("conexion.php");
	$message = null;
	$error = null;
	$new_cant = 0;		
	$add_id_cotiz = mysqli_real_escape_string($conexion,(strip_tags($_GET["add_id_cotiz"],ENT_QUOTES)));
	$add_id_cliente = mysqli_real_escape_string($conexion,(strip_tags($_GET["add_id_cliente"],ENT_QUOTES)));
	$add_cotiz_prov = strtoupper(mysqli_real_escape_string($conexion,(strip_tags($_GET["add_cotiz_prov"],ENT_QUOTES))));
	$add_cotiz_tipo = strtoupper(mysqli_real_escape_string($conexion,(strip_tags($_GET["add_cotiz_tipo"],ENT_QUOTES))));
	$add_cotiz_item = strtoupper(mysqli_real_escape_string($conexion,(strip_tags($_GET["add_cotiz_item"],ENT_QUOTES))));
	$add_cotiz_cant = mysqli_real_escape_string($conexion,(strip_tags($_GET["add_cotiz_cant"],ENT_QUOTES)));
	$add_cotiz_precio = mysqli_real_escape_string($conexion,(strip_tags($_GET["add_cotiz_precio"],ENT_QUOTES)));
	$add_cotiz_porc = mysqli_real_escape_string($conexion,(strip_tags($_GET["add_cotiz_porc"],ENT_QUOTES)));
	$item_cotiz_fecha = date('Y-m-d');
	$item_cotiz_hora = date('H:i');
	
	if(empty($add_cotiz_tipo)){
		$error = "Debe ingresar el tipo de producto";
	}else if(empty($add_cotiz_item)){
		$error = "Debe ingresar un producto";
	}else if($add_cotiz_cant <= 0){
		$error = "Debe ingresar la cantidad";
	}else if($add_cotiz_precio <= 0){
		$error = "Debe ingresar el precio";
	}else if($add_cotiz_porc <= 0){
		$error = "Debe ingresar el porcentaje";
	}else{
		$costo_total_item = $add_cotiz_cant * $add_cotiz_precio;
		$importe_total_item = $costo_total_item + ($costo_total_item * $add_cotiz_porc / 100);
		$query_insert_item_cotiz = "INSERT INTO t_cotiz_detalle(id_cotiz, id_cliente, proveedor, tipo, producto, cantidad, costo_unit, costo_total, porcentaje, importe, fecha, hora)
		VALUES('$add_id_cotiz', '$add_id_cliente', '$add_cotiz_prov', '$add_cotiz_tipo', '$add_cotiz_item', '$add_cotiz_cant', '$add_cotiz_precio', '$costo_total_item', '$add_cotiz_porc', '$importe_total_item', '$item_cotiz_fecha', '$item_cotiz_hora');";
		$result_insert_item_cotiz = mysqli_query($conexion,$query_insert_item_cotiz);
		if ($result_insert_item_cotiz) {
			$message = "Item agregado";
		}else{
			$error = "No se pudo agregar. Por favor, vuelva a intentarlo.</br>Error result_insert_item_cotiz: ". mysqli_error($conexion);
		}
	}
	
	if(isset($message)){
		echo "<font color='green'><b>". $message ."</b></font>";
	}
	
	if(isset($error)){
		echo "<font color='red'><b>Error: ". $error ."</b></font>";
	}
?>