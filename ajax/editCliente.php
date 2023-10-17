<?php
$message = null;
$error = null;

if (empty($_POST['id_edit_cliente'])) {
    $error = "Error GET id_edit_cliente";
} else if (!empty($_POST['id_edit_cliente'])) {
    require_once("conexion_2.php"); // Contiene la función que conecta a la base de datos

    // Escapando, y además eliminando cualquier cosa que pudiera ser código (HTML/JavaScript)
    $id_edit_cliente = $_POST["id_edit_cliente"];
    $edit_cliente_name = strtoupper($_POST["edit_cliente_name"]);
    $edit_cliente_lastname = strtoupper($_POST["edit_cliente_lastname"]);
    $edit_cliente_celular = $_POST["edit_cliente_celular"];
    $edit_cliente_email = $_POST["edit_cliente_email"];
    $fecha_edit = date('Y-m-d');

    if (empty($edit_cliente_name) || strlen($edit_cliente_name) <= 3) {
        $error = "Debe ingresar el nombre del cliente";
    } else if (empty($edit_cliente_celular) || strlen($edit_cliente_celular) < 10) {
        $error = "Debe ingresar el celular del cliente";
    } else {
        if (substr($edit_cliente_celular, 0, 2) !== "54") {
            $edit_cliente_celular = "54" . $edit_cliente_celular;
        }

        try {
		
            // UPDATE database
            $query_update_user = "UPDATE t_clientes SET nombre = :edit_cliente_name, apellido = :edit_cliente_lastname, celular = :edit_cliente_celular, email = :edit_cliente_email WHERE Id = :id_edit_cliente";
            $stmt = $pdo->prepare($query_update_user);
            $stmt->bindParam(':edit_cliente_name', $edit_cliente_name, PDO::PARAM_STR);
            $stmt->bindParam(':edit_cliente_lastname', $edit_cliente_lastname, PDO::PARAM_STR);
            $stmt->bindParam(':edit_cliente_celular', $edit_cliente_celular, PDO::PARAM_STR);
            $stmt->bindParam(':edit_cliente_email', $edit_cliente_email, PDO::PARAM_STR);
            $stmt->bindParam(':id_edit_cliente', $id_edit_cliente, PDO::PARAM_INT);
            $result_update_user = $stmt->execute();
			echo "Cliente editado";
			
        } catch (PDOException $e) {
            $error = "No se pudo editar. " . $e->getMessage();
        }
    }
} else {
    $error = "Error GET id_edit_cliente";
}

if (isset($error)) {
    echo "<font color='red' class='error'>Error: " . $error . "</font>";
}
?>