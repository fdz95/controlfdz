<?php 
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	require_once ("conexion.php");
	$output = "";
	
	$query_select_cuentas = "SELECT * FROM t_cuentas;";
	$result_select_cuentas = mysqli_query($conexion,$query_select_cuentas);
	if($result_select_cuentas){
		if (mysqli_num_rows($result_select_cuentas) > 0){
			while($row = mysqli_fetch_assoc($result_select_cuentas)){
				$getFormatCuenta = null;
				$getCuentaCompleta = null;
				$getFormatCBU = null;
				$getFormatCBU = null;
				$getFormatCVU = null;
				$getFormatAlias = null;
				
				$getID = $row['Id'];
				$getCuenta = $row['cuenta'];
				$getNumeroCBU = $row['cbu'];
				$getNumeroCVU = $row['cvu'];
				$getAlias = $row['alias'];
				
				if(!empty($getCuenta)){
					$getFormatCuenta = "<b>Cuenta:</b> <a href='#' title='Click para copiar todo al portapapeles'><font color='#000000'>". $getCuenta ."</font></a></br>";
					$getCuentaCompleta = "Cuenta: ". $getCuenta ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				if(!empty($getNumeroCBU)){
					$getFormatCBU = "<b>CBU:</b> <a href='#' title='Click para copiar CBU al portapapeles'><font color='#000000'>". $getNumeroCBU ."</font></a></br>";
					$getCuentaCompleta .= "Numero CBU: ". $getNumeroCBU ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				if(!empty($getNumeroCVU)){
					$getFormatCVU = "<b>CVU:</b> <a href='#' title='Click para copiar CVU al portapapeles'><font color='#000000'>". $getNumeroCVU ."</font></a></br>";
					$getCuentaCompleta .= "Numero CVU: ". $getNumeroCVU ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				if(!empty($getAlias)){
					$getFormatAlias = "<b>Alias:</b> <a href='#' title='Click para copiar Alias al portapapeles'><font color='#000000'>". $getAlias ."</font></a></br>";
					$getCuentaCompleta .= "Alias: ". $getAlias;
				}
				
				?>
					<div onclick="copyStringToClipboard('<?php echo $getCuentaCompleta; ?>')"><?php echo $getFormatCuenta; ?></div>
					<div onclick="copyStringToClipboard('<?php echo $getNumeroCBU; ?>')"><?php echo $getFormatCBU; ?></div>
					<div onclick="copyStringToClipboard('<?php echo $getNumeroCVU; ?>')"><?php echo $getFormatCVU; ?></div>
					<div onclick="copyStringToClipboard('<?php echo $getAlias; ?>')"><?php echo $getFormatAlias; ?></div>
					<div align="right"><a href='#' data-target='#deleteCuentaModal' class='info' data-toggle='modal' data-id='<?php echo $getID; ?>' data-cuenta='<?php echo $getCuenta; ?>'><font color='red'><i class='fas fa-trash'></i></font></a></div><hr>
				<?php
			}
			
		}else{
			$output = "No hay cuentas agregadas";
		}
	}else{
		$output = "No se pudieron cargar los datos de las cuentas.</br> Error result_select_cuentas";
	}
	echo $output;
?>