<?php	
	require_once "conexion_2.php";
	
	try{
		$query_select_clientes = "SELECT * FROM t_clientes;";
		$stmt_select_clientes = $pdo->query($query_select_clientes);
	}catch (PDOException $e){
		echo"Error: </br>stmt_select_clientes: ". $e->getMessage();
	}
	
	$cabecera_tabla = "
	<tr>
		<td align='center'><b>ID</b></td>
		<td align='center'><b>CLIENTE</b></td>
		<td align='center'><b>CELULAR</b></td>
		<td align='center'><b>EMAIL</b></td>
		<td align='center'><b>FECHA ALTA</b></td>
	</tr>";
	
	// DEFINO LAS CABECERAS Y EL TIPO DE CODIFICACION
	header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
	// FUERZO AL SERVER A DESCARGAR UN ARCHIVO XLS CON EL CONTENIDO DEL HTML
	header('Content-Disposition: attachment; filename=listado_clientes_'. date('Ymd') .'.xls');
?>
<html>
	<body>
		<table border="1" cellpadding="2" width="60%">
			<?php 
			
				echo "<caption><b>Listado de clientes al ". date('d/m/Y') ."</b></caption>";
			
				// MUESTRO LA CABECERA DE LA TABLA
				echo $cabecera_tabla;
				
				// BUCLE QUE RELLENA LA TABLA
				foreach($stmt_select_clientes->fetchAll(PDO::FETCH_ASSOC) as $columna){
					echo "<tr><td align='center'>'" .$columna['Id'] ."</td>
						<td align='center'>". $columna['nombre'] ." ". $columna['apellido'] ."</td>
						<td align='center'>". $columna['celular'] ."</td>
						<td align='center'>". $columna['email'] ."</td>
						<td align='center'>". $columna['fecha_alta'] ."</td>";
				}
				
				echo "</tr>";
			?>
		</table>
		<footer id="footer">
			<div class="container">
				<div class="row text-center">
					<div class="credits">
						<?php echo "<br><br>Listado de clientes descargado el ". date('d/m/Y') ." a las " . date('H:m'); ?>
					</div>
				</div>
			</div>
		</footer>
	</body>
</html>