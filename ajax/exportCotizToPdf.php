<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	require "conexion.php";
	require "../funciones.php";
	require "../fpdf/fpdf.php";
	$count1 = 1;
	$agregar_primera = false;
	$getClienteNombre = null;
	$getClienteNombre1 = null;
	$getImporteTotal = 0;
	$fechaActual = date('d/m/Y');
	
	$idcotiz = mysqli_real_escape_string($conexion,(strip_tags($_GET["idcotiz"],ENT_QUOTES)));
	
	$query_select_cotiz = "SELECT * FROM t_cotiz WHERE Id = '$idcotiz';";
	$result_select_cotiz = mysqli_query($conexion,$query_select_cotiz);
	if($result_select_cotiz){
		$row_cotiz = mysqli_fetch_array($result_select_cotiz);
		
		$getIdCliente = $row_cotiz['cliente'];
		$query_select_cliente = "SELECT * FROM t_clientes WHERE Id = '$getIdCliente';";
		$result_select_cliente = mysqli_query($conexion,$query_select_cliente);
		if($result_select_cliente){
			$row_cliente = mysqli_fetch_array($result_select_cliente);
			$getClienteNombre1 = $row_cliente['nombre']. " " .$row_cliente['apellido'];
			$getClienteNombre2 = $row_cliente['nombre']. "_" .$row_cliente['apellido'];
		}
		
		$getCosto = $row_cotiz['costo'];
		$getImporte = $row_cotiz['importe_cliente'];
		$getFechaCotiz = $row_cotiz['fecha'];
		
		// CREO UNA INSTANCIA DE LA CLASE FPDF
		class PDF extends FPDF{
			function Footer(){
				// Go to 1.5 cm from bottom
				$this->SetY(-15);
				// Select Arial italic 8
				$this->SetFont('Arial','I',9);
				// Print current and total page numbers
				$this->Cell(0,10,$this->PageNo().'/{nb}',0,0,'C');
			}
		}
		$pdf = new PDF();
		$pdf->AliasNbPages(); // AGREGO EL FOOTER CON EL NUMERO DE PAGINA
		$pdf->AddPage();
		// DEFINO EL SALTO DE PAGINA Y EL MARGEN
		$pdf->SetAutoPageBreak(false,0.5);
		//$pdf->SetLeftMargin(140);
		//$pdf->Image('../img/serviciosfdz.jpg',10,5,70,35,'JPG');
		$pdf->SetFont('Arial','B',15);
		$pdf->Cell(25,8,'                                                                                                                '. $fechaActual,'C');
		$pdf->Ln(); 
		$pdf->SetLeftMargin(5);
		$pdf->Cell(25,8,'                                                 Cotizacion Num 000'. $idcotiz,'C');
		$pdf->Ln();
		$pdf->Cell(25,8,'                                                    (precios al '. date_format(date_create($getFechaCotiz), 'd/m/y') .')','C');
		$pdf->Ln(25);
		$pdf->Cell(30,8,'Cliente: 0000'. $getIdCliente ." - ". $getClienteNombre1,'C');
		$pdf->Ln(15);
		// AGREGO LA CABECERA DE LA TABLA
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(30,8,'Proveedor',1,0,'C');
		$pdf->Cell(35,8,'Tipo',1,0,'C');
		$pdf->Cell(70,8,'Producto/Item',1,0,'C');
		$pdf->Cell(25,8,'Cant.',1,0,'C');
		$pdf->Cell(25,8,'Importe',1,0,'C');
		$pdf->Ln(8);
		$pdf->SetFont('Arial','',9);
		// BUCLE PARA LLENAR LA TABLA
		$query_select_cotiz_detalle = "SELECT * FROM t_cotiz_detalle WHERE id_cotiz = '$idcotiz';";
		$result_cotiz_detalle = mysqli_query($conexion,$query_select_cotiz_detalle);
		if($result_cotiz_detalle){
			while($row_cotiz_detalle = mysqli_fetch_array($result_cotiz_detalle)){
				
				
				$pdf->Cell(30,10,$row_cotiz_detalle['proveedor'],1,0,'C');
				$pdf->Cell(35,10,$row_cotiz_detalle['tipo'],1,0,'C');
				$pdf->Cell(70,10,trimTexto($row_cotiz_detalle['producto']),1,0,'C');
				$pdf->Cell(25,10,$row_cotiz_detalle['cantidad'],1,0,'C');
				$pdf->Cell(25,10,'$ '. moneyFormat($row_cotiz_detalle['importe']),1,0,'C');
				
				$pdf->Ln();
				// AGREGO UNA HOJA NUEVA DEPENDIENDO LA CANTIDAD DE REGISTROS
				if($agregar_primera){
					if($count1 == 27){
						$pdf->AddPage();
						$count1 = 0;
					}
				}else if($count1 == 22){
					$pdf->AddPage();
					$count1 = 0;
					$agregar_primera = true;
				}
				// SUMO UNO A COUNT1
				$count1++;
			}
		}else{
			echo "ERROR result_cotiz_detalle: " . mysqli_error($conexion);
		}
		$pdf->Ln(8);
		$pdf->SetFont('Arial','B',15);
		$pdf->Cell(30,8,'Importe total: $ '. moneyFormat($getImporte),'C');
		
		// DESCARGO EL PDF
		$pdf->Output('D','cotiz_000'. $idcotiz ."_". $getClienteNombre2 .'.pdf');
	}else{
		echo "ERROR result_select_cotiz: " . mysqli_error($conexion);
	}
	
	function trimTexto($texto, $limit=35){
		$texto = trim($texto);
		$texto = strip_tags($texto);
		$size = strlen($texto);
		$resultado = '';
		if($size <= $limit){
			return $texto;
		}else{
			$texto = substr($texto, 0, $limit);
			$palabras = explode(' ', $texto);
			$resultado = implode(' ', $palabras);
			$resultado .= '...';
		}
		return $resultado;
	}
	
	mysqli_close($conexion);
?>