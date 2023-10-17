<?php
if (!empty($_POST['id_delete_cliente'])) {
    require_once("conexion_2.php"); // Contiene la función que conecta a la base de datos

    // Escapando, y además eliminando cualquier cosa que pudiera ser código (HTML/JavaScript)
    $id_delete_cliente = intval($_POST['id_delete_cliente']);
    $fecha_delete = date('Y-m-d');
    $hora_delete = date('H:i');

    try {
        // DELETE FROM database
        $query_delete_cliente = "DELETE FROM t_clientes WHERE Id = :id_delete_cliente";
        $stmt = $pdo->prepare($query_delete_cliente);
        $stmt->bindParam(':id_delete_cliente', $id_delete_cliente, PDO::PARAM_INT);
        $result_delete_cliente = $stmt->execute();
		echo "Cliente borrado";
		
    } catch (PDOException $e) {
        $errors = "No se pudo borrar. " . $e->getMessage();
    }
} else {
    $errors = "ERROR id_delete_cliente";
}

if (isset($errors)) {
    echo "<font color='red' class='error'>Error: " . $errors . "</font>";
}

?>