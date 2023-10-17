<?php
	$output = "";
	if (empty($_POST['edit_gasto'])){
		$errors[] = "ERROR edit_gasto";
	} else if (!empty($_POST['edit_gasto'])){
		require_once ("conexion.php");
		$id_edit_gasto = mysqli_real_escape_string($conexion,(strip_tags($_POST["id_edit_gasto"],ENT_QUOTES)));
		$edit_gasto = strtoupper(mysqli_real_escape_string($conexion,(strip_tags($_POST["edit_gasto"],ENT_QUOTES))));
		$edit_gasto_importe = mysqli_real_escape_string($conexion,(strip_tags($_POST["edit_gasto_importe"],ENT_QUOTES)));
		$edit_gasto_notas = strtoupper(mysqli_real_escape_string($conexion,(strip_tags($_POST["edit_gasto_notas"],ENT_QUOTES))));
		$edit_gasto_fecha = mysqli_real_escape_string($conexion,(strip_tags($_POST["edit_gasto_fecha"],ENT_QUOTES)));
		$edit_gasto_fijo = mysqli_real_escape_string($conexion,(strip_tags($_GET["edit_gasto_fijo"],ENT_QUOTES)));
		$fecha_edit = date('Y-m-d');
		$hora_edit = date('H:i');
		
		if(empty($edit_gasto_importe) || $edit_gasto_importe <= 0){
			$errors[] = "Debe ingresar el importe del gasto";
		}else if(empty($edit_gasto_fecha)){
			$errors[] = "Debe ingresar la fecha del gasto";
		}else{
			$query_update_gasto = "UPDATE t_gastos SET fijo = '$edit_gasto_fijo', gasto = '$edit_gasto', importe = '$edit_gasto_importe', saldo = '$edit_gasto_importe', notas = '$edit_gasto_notas', fecha_gasto = '$edit_gasto_fecha', fecha = '$fecha_edit', hora = '$hora_edit' WHERE Id = '$id_edit_gasto';";
			$result_update_gasto = mysqli_query($conexion,$query_update_gasto);
			if ($result_update_gasto) {
				$messages[] = "Gastos editado";
			}else{
				$errors[] = "No se pudo editar. Por favor, vuelva a intentarlo. result_update_gasto</br>". mysqli_error($conexion);
			}
		}
	}else{
		$errors[] = "ERROR edit_gasto";
	}
	
	if (isset($errors)){
		foreach ($errors as $error) {
			echo "<font color='red'><b>Error: ". $error ."</b></font>";
		}
	}
	if (isset($messages)){
		foreach ($messages as $message) {
			echo $message;
		}
	}
?>	