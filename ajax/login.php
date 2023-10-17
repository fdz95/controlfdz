<?php
	session_start();
	require_once ("conexion_2.php");
	// Obtener los valores del formulario
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if(empty($password)){
		$error = "Ingrese el usuario";
	}
	if(empty($username)){
		$error = "Ingrese la contraseña";
	}
	
	// Establecer la conexión con la base de datos utilizando PDO
    try {
		// Consulta SQL para verificar las credenciales del usuario
        $query = "SELECT * FROM t_users WHERE user = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró un usuario con el nombre de usuario proporcionado
        if ($user) {
            // Verificar la contraseña
           // if (password_verify($password, $user['password'])) {
                // Inicio de sesión exitoso
				// Defino user_session
                $_SESSION['user_session'] = $username;
            /*} else {
                // Contraseña incorrecta
                $error = "Contraseña incorrecta";
            }*/
        } else {
            // Usuario no encontrado
            $error = "Nombre de usuario no encontrado";
        }
    } catch (PDOException $e) {
        // Error en la conexión a la base de datos
        $error = "Error en la conexión a la base de datos: " . $e->getMessage();
    }
	
	if(isset($error)){
		echo "<font color='red' class='error'>". $error ."</font>";
	}
?>