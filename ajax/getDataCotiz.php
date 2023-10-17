<?php
	if(isset($_GET['c'])){
		$ID_COTIZ = $_GET['c'];
		require_once ("conexion.php");
		require_once ("../funciones.php");
		$getTotalCosto = 0;
		$getTotalImporte = 0;
		$output = null;
		$tableContent = null;
		$count = 0;
		
		$tableContent = "
			<table class='table table-bordered table-hover'>
				<thead>
					<tr>
						<th width='10%' class='text-center'>Proveedor</th>
						<th width='10%' class='text-center'>Tipo</th>
						<th width='10%' class='text-center'>Item/Producto</th>
						<th width='10%' class='text-center'>Cantidad</th>
						<th width='10%' class='text-center'>Precio unit.</th>
						<th width='10%' class='text-center'>Costo</th>
						<th width='10%' class='text-center'>Importe</th>
						<th width='2%' class='text-center'>Opc.</th>
					</tr>
				</thead>
				<tbody>";
				
		$query_select_detalle_cotiz = "SELECT * FROM t_cotiz_detalle WHERE id_cotiz = '$ID_COTIZ';";
		$result_detalle_cotiz = mysqli_query($conexion,$query_select_detalle_cotiz);
		if($result_detalle_cotiz){
			if(mysqli_num_rows($result_detalle_cotiz) > 0){
				while($row = mysqli_fetch_assoc($result_detalle_cotiz)){
					$getIdCliente = $row['id_cliente'];
					$getProveedor = $row['proveedor'];
					$getTipo = $row['tipo'];
					$getItem = $row['producto'];
					$getCantidad = $row['cantidad'];
					$getCostoUnit = $row['costo_unit'];
					$getSubTotalCosto = $row['costo_total'];
					$getPorcentaje = $row['porcentaje'];
					$getSubTotalImporte = $row['importe'];
					$getTotalCosto += $getSubTotalCosto;
					$getTotalImporte += $getSubTotalImporte;
					
					$tableContent .= "
						<tr>
							<td width='10%' class='text-center'>$getProveedor</td>
							<td width='15%' class='text-center'>$getTipo</td>
							<td width='15%' class='text-center'>$getItem</td>
							<td width='15%' class='text-center'>$getCantidad</td>
							<td width='15%' class='text-center'>$ ". moneyFormat($getCostoUnit). "</td>
							<td width='15%' class='text-center'>$ ". moneyFormat($getSubTotalCosto). "</td>
							<td width='15%' class='text-center'>$ ". moneyFormat($getSubTotalImporte). "</td>
							<td width='2%' class='text-center'><a href='#' id='delete_item_cotiz' title='Borrar' data-cotiz='$ID_COTIZ' data-item='$getItem'><font color='red'><i class='fas fa-trash'></i></font></a></td>
						</tr>";
					$count++;
				}
				
				$output .= "Hay $count items</br></br>$tableContent</tbody></table></br></br>
						<table align='right'>
								<tbody>
									<tr>
										<td>
											<h2><b>Costo Total:</b> $ ". moneyFormat($getTotalCosto). "</h2></br>
											<h2><b>Importe Total:</b> $ ". moneyFormat($getTotalImporte). "</h2></br>
										</td>
									</tr>
									<tr>
										<td class='text-right'>
											<a href='#' data-target='#generarCotizModal' data-cotiz='$ID_COTIZ' data-cliente='$getIdCliente' class='btn btn-success' data-toggle='modal'>Generar cotizaci&oacute;n</a>
											<a href='#' data-target='#cancelCotizModal' data-cotiz='$ID_COTIZ' class='btn btn-danger' data-toggle='modal'>Cancelar</a>
										</td>
									</tr>
								</tbody>
							</table>";
			}else{
				$output = "No hay items agregados";
			}
				
		}else{
			$output = "No se pudo cargar el detalle de la cotizaci&oacute;n. Error result_detalle_cotiz";
		}
	}else{
		$output = "No se pudo cargar la cotizaci&oacute;n. Error GET_COTIZ";
	}
	
	echo $output;
?>