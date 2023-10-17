<?php
	require_once ("conexion.php");
	require_once ("../funciones.php");
	// DEFINO EL FORMATO DE MONEDA
	setlocale(LC_MONETARY, 'es_ES');
	$tdProp = null;
	
	//main query to fetch the data
	$query_select_cotiz = "SELECT * FROM t_cotiz;";
	$result_select_cotiz = mysqli_query($conexion,$query_select_cotiz);
	if($result_select_cotiz){
		if ($numrows = mysqli_num_rows($result_select_cotiz) > 0){?>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class='text-center'>N&uacute;mero</th>
						<th class='text-center'>Fecha</th>
						<th class='text-center'>Cliente</th>
						<th class='text-center'>Costo</th>
						<th class='text-center'>Importe</th>
						<th class='text-center'>Ganancia</th>
						<th class='text-center'>Opciones</th>
					</tr>
				</thead>
				<tbody>
			<?php
			while($row1 = mysqli_fetch_array($result_select_cotiz)){
				$getID = $row1['Id'];
				$getFecha = $row1['fecha'];
				$fecha_format = date_format(date_create($getFecha), 'd/m/Y');
				$getHora = $row1['hora'];
				$hora_format = date_format(date_create($getHora), 'H:m');
				
				$getNombreCliente = "";
				$getCelularCliente = "";
				$getIdCliente = $row1['cliente'];
				$query_select_cliente = "SELECT nombre, apellido, celular FROM t_clientes WHERE Id = '$getIdCliente';";
				$result_select_cliente = mysqli_query($conexion,$query_select_cliente);
				if($result_select_cliente){
					$row2 = mysqli_fetch_assoc($result_select_cliente);
					$getNombreCliente = $row2['nombre']." ".$row2['apellido'];
					$getCelularCliente = $row2['celular'];
				}
				
				$getCosto = $row1['costo'];
				$costo_format = moneyFormat($getCosto);
				
				$getImporte = $row1['importe_cliente'];
				$importe_format = moneyFormat($getImporte);
				
				$ganancia_format = moneyFormat($getImporte - $getCosto);
				
				echo "<tr>
					<td class='text-center'>000$getID</td>
					<td class='text-center'>$fecha_format $hora_format</td>
					<td class='text-center'>$getNombreCliente</a></td>
					<td class='text-center'>$ $costo_format</td>
					<td class='text-center'>$ $importe_format</td>
					<td class='text-center'><font color='green'><b>$ $ganancia_format</b></font></td>
					<td class='text-center'>
						<button type='button' class='btn btn-tool dropdown-toggle' data-toggle='dropdown'></button>
						<div class='dropdown-menu dropdown-menu-right' role='menu'>
							<a href='https://api.whatsapp.com/send?phone=$getCelularCliente&text=TOTAL%20COTIZACION%20%20$$importe_format' target='_blank' class='dropdown-item' title='Enviar'>Enviar por WhatsApp</a>
							<a href='ajax/exportCotizComprasPDF.php?idcotiz=$getID' class='dropdown-item' title='Exportar'>Exportar PDF COMPRAS</a>
							<a href='ajax/exportCotizClientePDF.php?idcotiz=$getID' class='dropdown-item' title='Exportar'>Exportar PDF CLIENTE</a>
							<a href='cotizContent.php?idcotiz=$getID' class='dropdown-item' title='Editar'>Editar</a>
							<a href='#' data-target='#deleteCotizModal' class='dropdown-item' title='Borrar' data-toggle='modal' data-id='$getID' data-cliente='$getNombreCliente'>Borrar</a>
						</div>
					</td>
					</tr></a>";
			}
			?>
				</tbody>
			</table>
			<?php
		}else{
			echo "No hay cotizaciones agregadas";
		}
	}else{
		echo "No se pudieron cargar las cotizaciones. Error result_select_cotiz: ". mysqli_error($conexion);
	}
?>