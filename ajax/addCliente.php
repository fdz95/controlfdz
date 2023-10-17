<?php
$message = null;
$error = null;
if (empty($_POST['add_cliente_name'])){
    $error = "Debe ingresar el nombre del cliente";
} else if (!empty($_POST['add_cliente_name'])){
    require_once ("conexion_2.php"); // Contiene función que conecta a la base de datos

    try {
	
        // Escapar y eliminar cualquier código que podría ser (html/javascript)
        $add_cliente_name = strtoupper(htmlspecialchars($_POST["add_cliente_name"], ENT_QUOTES));
        $add_cliente_lastname = strtoupper(htmlspecialchars($_POST["add_cliente_lastname"], ENT_QUOTES));
        $add_cliente_celular = htmlspecialchars($_POST["add_cliente_celular"], ENT_QUOTES);
        $add_cliente_email = htmlspecialchars($_POST["add_cliente_email"], ENT_QUOTES);
        $fecha_add = date('Y-m-d');

        if (empty($add_cliente_celular) || strlen($add_cliente_celular) < 10){
            $error = "Debe ingresar el celular del cliente";
        } else {
            if (substr($add_cliente_celular, 0, 2) !== "54"){
                $add_cliente_celular = "54" . $add_cliente_celular;
            }

            $query_search_cliente = "SELECT * FROM t_clientes WHERE estado = 'A' AND nombre = :add_cliente_name AND apellido = :add_cliente_lastname";
            $stmt_search_cliente = $pdo->prepare($query_search_cliente);
            $stmt_search_cliente->bindParam(":add_cliente_name", $add_cliente_name);
            $stmt_search_cliente->bindParam(":add_cliente_lastname", $add_cliente_lastname);
            $stmt_search_cliente->execute();

            if ($stmt_search_cliente->rowCount() > 0){
                $error = "El cliente <b>$add_cliente_name $add_cliente_lastname</b> ya existe";
            } else {
                $query_insert_cliente = "INSERT INTO t_clientes(estado, nombre, apellido, celular, email, fecha_alta)
                VALUES('A', :add_cliente_name, :add_cliente_lastname, :add_cliente_celular, :add_cliente_email, :fecha_add)";
                $stmt_insert_cliente = $pdo->prepare($query_insert_cliente);
                $stmt_insert_cliente->bindParam(":add_cliente_name", $add_cliente_name);
                $stmt_insert_cliente->bindParam(":add_cliente_lastname", $add_cliente_lastname);
                $stmt_insert_cliente->bindParam(":add_cliente_celular", $add_cliente_celular);
                $stmt_insert_cliente->bindParam(":add_cliente_email", $add_cliente_email);
                $stmt_insert_cliente->bindParam(":fecha_add", $fecha_add);
                $stmt_insert_cliente->execute();
				echo "Cliente agregado";
            }
        }
    } catch(PDOException $e) {
        $error = "No se pudo agregar. Por favor, vuelva a intentarlo. " . $e->getMessage();
    }
} else {
    $error = "Debe ingresar el nombre del cliente";
}

if (isset($error)){
    echo "<font color='red' class='error'>Error: " . $error ."</font>";
}

?>