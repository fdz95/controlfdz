<?php
if (!empty($_POST['id_delete_cuenta'])) {
    require_once("conexion_2.php"); // Contiene la función que conecta a la base de datos

    // Escapando, y además eliminando cualquier cosa que pudiera ser código (HTML/JavaScript)
    $id_delete_cuenta = $_POST['id_delete_cuenta'];
    $fecha_delete = date('Y-m-d');
    $hora_delete = date('H:i');

    try {
        // DELETE FROM database
        $query_delete_cuenta = "DELETE FROM t_cuentas WHERE Id = :id_delete_cuenta";
        $stmt = $pdo->prepare($query_delete_cuenta);
        $stmt->bindParam(':id_delete_cuenta', $id_delete_cuenta);
        $stmt->execute();
		echo "Cuenta borrada";
		
    } catch (PDOException $e) {
        $error = "No se pudo borrar. " . $e->getMessage();
    }
} else {
    $error = "ERROR id_delete_cuenta";
}

if (isset($error)) {
    echo "<font color='red' class='error'>" . $error . "</font>";
}

?>