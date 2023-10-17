<?php
	session_start();
	if(isset($_SESSION['user_session'])){
		$login_user = "";
		$login_user = $_SESSION['user_session'];
		$user_name = "USUARIO";
		$user_email = "";
		require ("ajax/conexion.php");
		$query_select_user = "SELECT * FROM t_users WHERE estado = 'A' AND user = '$login_user';";
		$result_select_user = mysqli_query($conexion,$query_select_user);
		if($result_select_user){
			$columna = mysqli_fetch_assoc($result_select_user);
			$user_name = $columna['nombre'];
			$user_lastname = $columna['apellido'];
		}
		$query_select_config = "SELECT * FROM t_config WHERE Id = '1';";
		$result_select_config = mysqli_query($conexion,$query_select_config);
		if($result_select_config){
			$columna = mysqli_fetch_assoc($result_select_config);
			$version = $columna['version'];
			$author = $columna['author'];
			$app_name = $columna['app_name'];
			$app_img = $columna['app_img'];
			$app_img_ico = $columna['app_img_ico'];
			$title = "Cotizaciones | $app_name";
			$subtitle = "Cotizaci&oacute;n";
		}
		
		$output = null;
		$visibility1 = null;
		$visibility2 = null;
		$getIdCliente = null;
		if(isset($_GET['idcotiz'])){
			$id_cotiz = $_GET['idcotiz'];
			$query_select_id_cliente = "SELECT cliente FROM t_cotiz WHERE Id = '$id_cotiz';";
			$result_id_cliente = mysqli_query($conexion,$query_select_id_cliente);
			if($result_id_cliente){
				$row_id_cliente = mysqli_fetch_assoc($result_id_cliente);
				$getIdCliente = $row_id_cliente['cliente'];
				$query_select_cliente = "SELECT nombre,apellido FROM t_clientes WHERE Id = '$getIdCliente';";
				$result_cliente = mysqli_query($conexion,$query_select_cliente);
				if($result_cliente){
					$row_cliente = mysqli_fetch_assoc($result_cliente);
					$getNombreCliente = " - <b>". $row_cliente['nombre'] ." ". $row_cliente['apellido'] ."</b>";
				}else{
					$getNombreCliente = "error result_cliente";
				}
			}else{
				$getNombreCliente = "error result_id_cliente";
			}
		}else{
			$query_select_max_cotiz = "SELECT Id, MAX(Id) FROM t_cotiz;";
			$result_max_cotiz = mysqli_query($conexion,$query_select_max_cotiz);
			if($result_max_cotiz){
				$row_max = mysqli_fetch_assoc($result_max_cotiz);
				$id_cotiz = $row_max['Id'] + 1;
			}else{
				$output = "No se pudo cargar el n&uacute;mero de la cotizaci&oacute;n. Error result_max_cotiz";
			}
		}
	}else{
		header("Location: login.php");
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
								<h1 class="m-0 text-dark"><?php echo $subtitle; if(isset($getNombreCliente)) echo $getNombreCliente;?></h1>
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
										<a href="cotiz.php" class="btn btn-info">Volver</a>
									</div>
									<!-- Main content -->
									<div class="card-body">
										<div id="div-add-cliente" style="visibility:hidden">
											<h4><b>Seleccionar cliente</b></h4>
											<select name="search_cliente" id="search_cliente" style="width:20%;"></select>
											<div id="loader_cliente"></div>
										</div></br></br>
										<div id="div-add-item" style="visibility:hidden">
											<h4><b>Agregar items</b></h4>
											<input type='hidden' name='add_id_cotiz' id='add_id_cotiz' value="<?php echo $id_cotiz; ?>"/>
											<input type='hidden' name='add_id_cliente' id='add_id_cliente' value="<?php echo $getIdCliente; ?>"/>
											<table class='table'>
												<thead>
													<tr>
														<th width='10%' class='text-center'>Proveedor</th>
														<th width='10%' class='text-center'>Tipo</th>
														<th width='10%' class='text-center'>Item/Producto</th>
														<th width='10%' class='text-center'>Cantidad</th>
														<th width='10%' class='text-center'>Precio unit.</th>
														<th width='10%' class='text-center'>Porcentaje</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td width='10%'><input type='text' id='add_cotiz_prov' name='add_cotiz_prov' placeholder='Ingrese el proveedor...' class='form-control'/></td>
														<td width='10%'><input type='text' id='add_cotiz_tipo' name='add_cotiz_tipo' placeholder='Ingrese el tipo...' class='form-control'/></td>
														<td width='10%'><input type='text' id='add_cotiz_item' name='add_cotiz_item' placeholder='Ingrese un item/producto...' class='form-control'/></td>
														<td width='10%'><input type='number' id='add_cotiz_cant' name='add_cotiz_cant' placeholder='Ingrese la cantidad...' class='form-control' /></td>
														<td width='10%'><input type='number' id='add_cotiz_precio' name='add_cotiz_precio' placeholder='Precio...' class='form-control' /></td>
														<td width='10%'><input type='number' id='add_cotiz_porc' name='add_cotiz_porc' value="20" placeholder='Ingrese el porcentaje...' class='form-control' /></td>
														</td>
													</tr>
													<tr>
														<td><div id='loader_add_item'></div></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td class='text-right'>
															<input type='button' onclick='agregarItemCotiz()' class='btn btn-success' value='Agregar' />
															<input type='button' onclick='limpiarCampos()' class='btn btn-info' value='Limpiar' />
														</td>
													</tr>
												</tbody>
											</table>
										</div></br>
										<?php if(isset($output)) echo $output; ?>
										<div id="loader_items_cotiz"></div>
										<div id="response_items_cotiz"></div>
										<div class="outer_div_items_cotiz"></div>
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
		
		<!-- Generar Cotiz Modal HTML -->
		<?php include("html/modal_generar_cotiz.php");?>
		<!-- Cancel Cotiz Modal HTML -->
		<?php include("html/modal_cancel_cotiz.php");?>
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
		<script type="text/javascript" src="js/scriptItemsCotiz.js"></script>
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