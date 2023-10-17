<?php
    session_start();
    if (!isset($_SESSION['user_session'])) {
        header("Location: login.php");
        exit;
    }
	
	// Obtengo el usuario ingresado mediante $_SESSION
	$login_user = $_SESSION['user_session'];
	$user_name = null;
	$user_lastname = null;
	$version = null;
	$author = null;
	$app_name = null;
	$app_img = null;
	$app_img_ico = null;
	$error = null;
	
    try {
		// Obtener datos del usuario
		require_once "ajax/conexion_2.php";
		$query_select_user = "SELECT * FROM t_users WHERE estado = 'A' AND user = :login_user";
		$statement_user = $pdo->prepare($query_select_user);
		$statement_user->bindParam(':login_user', $login_user);
		$statement_user->execute();
		$columna_user = $statement_user->fetch(PDO::FETCH_ASSOC);
		if ($columna_user) {
			$user_name = $columna_user['nombre'];
			$user_lastname = $columna_user['apellido'];
		}

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
			$title = "Cotizaciones | $app_name";
			$subtitle = "Cotizaciones";
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
		<title><?php echo $title; ?></title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="dist/css/adminlte.min.css">
		 <!-- Toastr -->
		<link rel="stylesheet" href="plugins/toastr/toastr.min.css">
		<!-- Icono -->   
		<link rel="icon" href="img/<?php echo $app_img_ico; ?>">
		<!-- Select2 CSS -->
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Navbar -->
			<?php include("nav.php"); ?>
			<!-- /.navbar -->
			<!-- Main Sidebar Container -->
			<?php 
				$active7 = "active";
				include("sidebar.php");
			?>
			<!-- /.sidebar -->
			
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0 text-dark"><?php echo $subtitle; ?></h1>
							</div><!-- /.col -->
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-right">
									<li class="breadcrumb-item"><a href="#">Inicio</a></li>
									<li class="breadcrumb-item active"><?php echo $subtitle; ?></li>
								</ol>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->
				
				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<a href="cotizContent.php" class="btn btn-info"><b>+</b> Nueva cotizaci&oacute;n</a>
									</div>
									<div class="card-body">
										<!-- Main content -->
										<div id="loader_cotiz"></div>
										<div id="response_cotiz" class="card-body"></div>
										<div class='outer_div_cotiz'></div>
									</div>
								</div>
								<!-- /.card -->
							</div>
							  <!-- /.col -->
						</div>
							<!-- /.row -->
					</div>
				  <!-- /.container-fluid -->
				</section>
				<!-- /.section -->
			</div>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		
		<!-- Delete Cotiz Modal HTML -->
		<?php include("html/modal_delete_cotiz.php");?>
		<!-- Logout Modal HTML -->
		<?php include("html/modal_logout.php");?>
		<!-- Footer -->
		<?php include("footer.php");?>
		
		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Bootstrap -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
		<!-- DataTables -->
		<script src="plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
		<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
		<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
		<!-- Select2 -->
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
		<!-- Funciones -->
		<script type="text/javascript" src="js/scriptCotiz.js"></script>
		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.js"></script><!-- page script -->
		<!-- Toastr -->
		<script src="plugins/toastr/toastr.min.js"></script>
		<script>
		  $(function () {
			$("#example1").DataTable({
			  "responsive": true,
			  "autoWidth": false,
			});
			$('#example2').DataTable({
			  "paging": true,
			  "lengthChange": false,
			  "searching": false,
			  "ordering": true,
			  "info": true,
			  "autoWidth": false,
			  "responsive": true,
			});
		  });
		</script>
	</body>
</html>