<!-- /.navbar -->
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="index.php" class="brand-link">
		<img src="img/<?php echo $app_img; ?>" alt="<?php echo $app_name; ?> logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light"><?php echo $app_name; ?></span>
	</a>
	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="info">
				<a href="#" class="d-block"><?php echo $user_name ." ". $user_lastname; ?></a>
				<a href="#logoutModal" data-toggle="modal"><span class="glyphicon glyphicon-log-out"></span><b>Cerrar sesi&oacute;n</b></a>
			</div>
		</div>
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
				<li class="nav-item has-treeview menu-open">
					<a href="#" class="nav-link active">
						<i class="nav-icon fas fa-tachometer-alt"></i><p> Inicio <i class="right fas fa-angle-left"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item"><a href="./index.php" class="nav-link <?php echo $active1; ?>"><i class="fas fa-tasks"></i>&nbsp;&nbsp;<p>Trabajos</p></a></li>
						<li class="nav-item"><a href="./cotiz.php" class="nav-link <?php echo $active7; ?>"><i class="fas fa-tasks"></i>&nbsp;&nbsp;<p>Cotizaciones</p></a></li>
						<li class="nav-item"><a href="./gastos.php" class="nav-link <?php echo $active2; ?>"><i class="fas fa-arrow-alt-circle-left"></i>&nbsp;&nbsp;<p>Gastos</p></a></li>
						<li class="nav-item"><a href="./clientes.php" class="nav-link <?php echo $active3; ?>"><i class="fas fa-users"></i>&nbsp;&nbsp;<p>Clientes</p></a></li>
						<li class="nav-item"><a href="./estadisticas.php" class="nav-link <?php echo $active4; ?>"><i class="fas fa-chart-line"></i>&nbsp;&nbsp;<p>Estadisticas y reportes</p></a></li>
						<li class="nav-item"><a href="./account.php" class="nav-link <?php echo $active5; ?>"><i class="fas fa-user"></i>&nbsp;&nbsp;<p>Mi cuenta</p></a></li>
						<li class="nav-item"><a href="./config.php" class="nav-link <?php echo $active6; ?>"><i class="fas fa-cog"></i>&nbsp;&nbsp;<p>Configuracion</p></a></li>
					</ul>
				</li>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>