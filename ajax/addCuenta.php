<?php
	$error = null;
	if (empty($_POST['add_nombre_banco'])){
		$error = "Debe ingresar el nombre del banco";
	} else if (!empty($_POST['add_nombre_banco'])){
		require_once ("conexion_2.php");//Contiene función que conecta a la base de datos
		$add_nombre_banco = strtoupper($_POST["add_nombre_banco"]);
		$add_cbu_banco = $_POST["add_cbu_banco"];
		$add_cvu_banco = $_POST["add_cvu_banco"];
		$add_alias_banco = strtoupper($_POST["add_alias_banco"]);
		$fecha_add = date('Y-m-d');

		if(empty($add_cbu_banco) && empty($add_cvu_banco)){
			$error = "Debe ingresar, al menos, un número de cuenta";
		} else {
			try{
				$query_insert_cuenta = "INSERT INTO t_cuentas(cuenta, cbu, cvu, alias, fecha) VALUES(:add_nombre_banco, :add_cbu_banco, :add_cvu_banco, :add_alias_banco, :fecha_add)";
				$statement_insert_cuenta = $pdo->prepare($query_insert_cuenta);
				$statement_insert_cuenta->bindParam(':add_nombre_banco', $add_nombre_banco);
				$statement_insert_cuenta->bindParam(':add_cbu_banco', $add_cbu_banco);
				$statement_insert_cuenta->bindParam(':add_cvu_banco', $add_cvu_banco);
				$statement_insert_cuenta->bindParam(':add_alias_banco', $add_alias_banco);
				$statement_insert_cuenta->bindParam(':fecha_add', $fecha_add);
				$statement_insert_cuenta->execute();
				echo "Cuenta agregada con éxito";
			}catch(PDOException $e){
				$error = "No se pudo conectar a la base de datos. ". $e->getMessage();
			}
		}
	} else {
		$error = "Debe ingresar el nombre del banco";
	}
	
    if (isset($error)){
        echo "<font color='red' class='error'>Error: " . $error ."</font>";
    }
?>