<?php
	if (empty($_POST['add_tipo_trabajo'])){
		$error = "Debe ingresar el tipo de trabajo";
	} else if (!empty($_POST['add_tipo_trabajo'])){
		try{
			require_once ("conexion_2.php");
			$tipo_trabajo = strtoupper($_POST['add_tipo_trabajo']);
			$query_insert_payment = "INSERT INTO t_tipos(tipo) VALUES(:tipo_trabajo)";
			$stmt_insert_payment = $pdo->prepare($query_insert_payment);
			$stmt_insert_payment->bindParam(':tipo_trabajo', $tipo_trabajo);
			$stmt_insert_payment->execute();
			echo "Tipo de trabajo agregado";
		}catch(PDOException $e){
			$error = "No se pudo agregar. ". $e->getMessage();
		}
	}else{
		$error = "Debe ingresar el tipo de trabajo";
	}
	
	if(isset($error)){
		echo "<font color='red' class='error'>". $error ."</font>";
	}
?>	