		$(function() {
			loadVentasMensuales();
		});
		
		function loadVentasMensuales(){
			$.ajax({
				url:'ajax/getVentasMensualesTabla.php',
				beforeSend: function(objeto){
					$('#response_mensuales').html("Cargando...");
				},
				success:function(data){
					$('.outer_div_mensuales').html(data);
					$('#response_mensuales').html("");
				}
			});
		}
		
		///////////////////// ADD CUENTAS
		$('#detalleVentasMensualesModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var fecha1 = button.data('fecha1')
			var fecha2 = button.data('fecha2')
			var anio = button.data('anio')
			console.log(fecha1);
			$.ajax({
				url:'ajax/getDetalleVentasMensuales.php?fecha1='+ fecha1 +'&fecha2='+ fecha2 +'&anio='+ anio,
				beforeSend: function(objeto){
					$('#response_detalle_vmensuales').html("Cargando...");
				},
				success:function(data){
					$('#response_detalle_vmensuales').html(data);
				}
			});
		})
				
		///////////////////// LOGOUT
		$('#logout_modal').submit(function(event){
			$.ajax({
				type: 'POST',
				url: 'logout.php?logout',
				beforeSend: function(objeto){
					document.querySelector('#button_logout').disabled = true;
					$('#label_logout').html("Cerrando sesi&oacute;n, espere por favor...");
				},
				success: function(datos){
					window.location.reload();
				}
			});
			event.preventDefault();
		});
		
		/*function exportarMensuales(){
			var initial_date = document.getElementById('export_initial_date_m').value;
			var final_date = document.getElementById('export_final_date_m').value;
			window.location.href = "/php/demo/ajax/export.php?etype=M&idate="+ initial_date +"&fdate="+ final_date;
			$('#exportDiariosModal').modal('hide');
		}*/