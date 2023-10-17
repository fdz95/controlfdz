<?php
    if (empty($_POST['add_gasto'])){
        $error = "Debe ingresar el gasto";
    } else if (!empty($_POST['add_gasto'])){
        $add_gasto = strtoupper($_POST["add_gasto"]);
        $add_gasto_importe = $_POST["add_gasto_importe"];
        $add_gasto_notas = strtoupper($_POST["add_gasto_notas"]);
        $add_gasto_fecha = $_POST["add_gasto_fecha"];
        $add_gasto_fijo = $_GET["add_gasto_fijo"];
        $fecha_add = date('Y-m-d');
        $hora_add = date('H:i');
		
        if(empty($add_gasto_importe) || $add_gasto_importe <= 0){
            $error = "Debe ingresar el importe del gasto";
        } else if(empty($add_gasto_fecha)){
            $error = "Debe ingresar la fecha del gasto";
        } else {
			try{
				require_once ("conexion_2.php");
				$query_insert = "INSERT INTO t_gastos(estado, fijo, gasto, importe, saldo, notas, fecha_gasto, fecha, hora)
				VALUES('', :add_gasto_fijo, :add_gasto, :add_gasto_importe, :add_gasto_importe, :add_gasto_notas, :add_gasto_fecha, :fecha_add, :hora_add)";
				$statement_insert = $pdo->prepare($query_insert);
				$statement_insert->bindParam(':add_gasto_fijo', $add_gasto_fijo);
				$statement_insert->bindParam(':add_gasto', $add_gasto);
				$statement_insert->bindParam(':add_gasto_importe', $add_gasto_importe);
				$statement_insert->bindParam(':add_gasto_notas', $add_gasto_notas);
				$statement_insert->bindParam(':add_gasto_fecha', $add_gasto_fecha);
				$statement_insert->bindParam(':fecha_add', $fecha_add);
				$statement_insert->bindParam(':hora_add', $hora_add);
				$statement_insert->execute();
				echo "Gasto agregado";
			}catch(PDOException $e){
				$error = "No se pudo conectar a la base de datos. ". $e->getMessage();
			}
        }
    } else {
        $error = "Debe ingresar el gasto";
    }
	
    if (isset($error)){
        echo "<font color='red' class='error'>" . $error ."</font>";
    }
?>