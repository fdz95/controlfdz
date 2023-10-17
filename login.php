<?php
    session_start();
    if (isset($_SESSION['user_session'])) {
        header("Location: index.php");
        exit;
    }
	
	$version = null;
	$author = null;
	$app_name = null;
	$app_img = null;
	$app_img_ico = null;
	$error = null;
	
    try {
		require_once "ajax/conexion_2.php";
		// Obtener datos de configuración
		$query_select_config = "SELECT * FROM t_config WHERE Id = '1';";
		$statement_config = $pdo->prepare($query_select_config);
		$statement_config->execute();
		$columna_config = $statement_config->fetch(PDO::FETCH_ASSOC);
		if ($columna_config) {
			$version = $columna_config['version'];
			$author = $columna_config['author'];
			$app_name = $columna_config['app_name'];
			$app_img = $columna_config['app_img'];
			$app_img_ico = $columna_config['app_img_ico'];
		}
	} catch (PDOException $e) {
		// Error en la conexión a la base de datos
        $error = "<font color='red'>Error en la conexión a la base de datos: " . $e->getMessage() ."</font>";
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Iniciar sesion | <?php echo $app_name; ?></title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="dist/css/adminlte.min.css">
		<!-- Icono -->   
		<link rel="icon" href="img/<?php echo $app_img_ico; ?>">
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">
				<p><img src="img/<?php echo $app_img; ?>" width="75" alt="<?php echo $app_name; ?> logo" style="opacity: .8">&nbsp;<b><?php echo $app_name; ?></b></p>Iniciar sesion
			</div>
			<div class="card-body login-card-body">
				<form name="login_form" id="login_form">
					<div class="input-group mb-3">
						<input type="user" name="username" class="form-control" placeholder="Usuario">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" name="password" id="password_id" class="form-control" placeholder="Constrase&ntilde;a">
						<div class="input-group-append">
							<div class="input-group-text">
								<span id="span_lock" onclick="visiblePass()" class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<label id="response"></label>
						<?php if(isset($error)) echo $error; ?>
					</div>
					<div class="row">
						<div class="col-12">
							<button type="submit" id="button_login" class="btn btn-primary btn-block">Iniciar sesion</button>
						</div>
					</div>
				</form>
			</div>
			<!-- /.login-card-body -->
		</div>
		<!-- /.login-box -->
		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Bootstrap -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>
		<!-- Funciones -->
		<script src="js/login.js"></script>
	</body>
</html>