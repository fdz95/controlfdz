<?php
	$output = "";
	$break = "\r\n</br>";
	if (empty($_GET['id_trabajo'])){
		$output = "ERROR id_trabajo";
	} else if (!empty($_GET['id_trabajo'])){
		$nombre_cliente = "";
		$tipo_trabajo = "";
		require_once ("conexion.php");
		
		// escaping, additionally removing everything that could be (html/javascript-) code
		$id_trabajo = mysqli_real_escape_string($conexion,(strip_tags($_GET["id_trabajo"],ENT_QUOTES)));
		
		$query_select_trabajo = "SELECT * FROM t_trabajos WHERE Id = '$id_trabajo';";
		$result_select_trabajo = mysqli_query($conexion,$query_select_trabajo);
		if($result_select_trabajo){
			if(mysqli_num_rows($result_select_trabajo) > 0){
				$row = mysqli_fetch_assoc($result_select_trabajo);
				$getID = $row['Id'];
				$getCliente = $row['cliente'];
				$getEquipo= $row['equipo'];
				$getTrabajo = $row['trabajo'];
				$getNotas = $row['observ'];
				$getFecha = $row['fecha'];
				$fecha_format = date_format(date_create($getFecha), 'd/m/Y');
				$getHora = $row['hora'];
				$hora_format = date_format(date_create($getHora), 'H:i');
				
				// select datos cliente
				$query_select_cliente = "SELECT * FROM t_clientes WHERE Id = '$getCliente';";
				$result_select_cliente = mysqli_query($conexion,$query_select_cliente);
				if($result_select_cliente){
					if(mysqli_num_rows($result_select_cliente) > 0){
						$row_cliente = mysqli_fetch_assoc($result_select_cliente);
						$nombre_cliente = $row_cliente['nombre'] ." ".  $row_cliente['apellido'];
						$nombre_cliente = recortar_texto($nombre_cliente);
					}
				}else{
					$output .= "ERROR result_select_cliente: ". mysqli_error($conexion);
				}
				
				// select tipo de trabajo
				$query_select_tipo = "SELECT * FROM t_tipos WHERE Id = '$getTrabajo';";
				$result_select_tipo = mysqli_query($conexion,$query_select_tipo);
				if($result_select_tipo){
					if(mysqli_num_rows($result_select_tipo) > 0){
						$row_tipo = mysqli_fetch_assoc($result_select_tipo);
						$tipo_trabajo = $row_tipo['tipo'];
					}
				}else{
					$output .= "ERROR result_select_tipo: ". mysqli_error($conexion);
				}
				
				$output .= "$break FDZ$break===================================$break";
				$output .= "<b><h2>N° ". $id_trabajo ."</b> - ". $fecha_format ." ". $hora_format ."</h2>";

				$output .= "<b>CLIENTE:</b>$break";
				$output .= $nombre_cliente ."$break";
				$output .= "-----------------------------------------------------------$break$break";
				
				$output .= "<b>EQUIPO/REPUESTO:</b>$break";
				$output .= $getEquipo ."$break";
				$output .= "-----------------------------------------------------------$break$break";
				
				$output .= "<b>TRABAJO:</b>$break";
				$output .= $tipo_trabajo ."$break";
				$output .= "-----------------------------------------------------------$break$break";
				
				if(!empty($getNotas)){
					$output .= "<b>NOTAS:</b>$break";
					$output .= $getNotas ."$break";
				$output .= "-----------------------------------------------------------";
				}
				
				$output .= "$break$break======== TICKET DE CONTROL ========$break";
				
				$output .= "$break$break$break
						<style>
							@media print{
								.hidden-print{
									display:none;
								}
							}
						</style>
						<button class='hidden-print' onclick='window.print();'>Imprimir</button>";
			}else{
				$output .= "No se encontro el trabajo. Por favor, vuelva a intentarlo. num_rows</br>";
			}
			
		}else{
			$output .= "ERROR result_select_trabajo: ". mysqli_error($conexion);
		}
	}else{
		$output .= "ERROR id_trabajo";
	}
	
	echo $output;

	function recortar_texto($texto, $limite=20){
		$texto = trim($texto);
		$texto = strip_tags($texto);
		$tamano = strlen($texto);
		$resultado = '';
		if($tamano <= $limite){
			return $texto;
		}else{
			$texto = substr($texto, 0, $limite);
			$palabras = explode(' ', $texto);
			$resultado = implode(' ', $palabras);
			$resultado .= '...';
		}
		return $resultado;
	}
?>	