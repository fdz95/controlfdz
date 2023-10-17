<?php
	if (!empty($_POST['id_cancel_cotiz'])){
		require_once ("conexion.php");
		$id_cancel_cotiz = mysqli_real_escape_string($conexion,(strip_tags($_POST["id_cancel_cotiz"],ENT_QUOTES)));
		
		$query_cancel_item_cotiz = "DELETE FROM t_cotiz_detalle WHERE id_cotiz = '$id_cancel_cotiz';";
		$result_cancel_item_cotiz = mysqli_query($conexion,$query_cancel_item_cotiz);
		if ($result_cancel_item_cotiz){
			
			$query_cancel_cotiz = "DELETE FROM t_cotiz WHERE Id = '$id_cancel_cotiz';";
			$result_cancel_cotiz = mysqli_query($conexion,$query_cancel_cotiz);
			if ($result_cancel_cotiz){
				$messages = "Cotizaci&oacute;n cancelada";
			}else{
				$errors = "No se pudo cancelar. Por favor, vuelva a intentarlo. result_cancel_cotiz: </br>". mysqli_error($conexion);
			}
			
		}else{
			$errors = "No se pudo cancelar. Por favor, vuelva a intentarlo. result_cancel_item_cotiz: </br>". mysqli_error($conexion);
		}		
	}else{
		$errors = "ERROR id_cancel_cotiz";
	}
	
	if(isset($errors)){
		echo "<font color='red'>Error: ". $errors ."</font>";
	}
	
	if(isset($messages)){
		echo $messages;
	}
?>