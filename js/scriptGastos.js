		$(function() {
			loadGastos();
		});
		
		function loadGastos(){
			$.ajax({
				url:'ajax/getGastos.php',
				beforeSend: function(objeto){
					$('#loader_gastos').html("Cargando...");
				},
				success:function(data){
					$('.outer_div_gastos').html(data);
					$('#loader_gastos').html("");
				}
			});
			
			$.ajax({
				url:'ajax/getGastosFijos.php',
				beforeSend: function(objeto){
					$('#loader_gastos_fijos').html("Cargando...");
				},
				success:function(data){
					$('.outer_div_gastos_fijos').html(data);
					$('#loader_gastos_fijos').html("");
				}
			});
		}
		
		///////////////////// ADD GASTO
		$('#newGastoModal').on('show.bs.modal', function (event) {
			$('#add_gasto').val("");
			$("#add_gasto_importe").val("");
			$('#add_trabajo_gasto_select').val("");
			$('#add_gasto_notas').val("");
			setFechaHoy('add_gasto_fecha');
		})
		
		$('#add_gasto_modal').submit(function( event ) {
			var gasto_fijo = "0";
			if( $('#checkbox_gasto_fijo').prop('checked') ) {
				gasto_fijo = "1";
			}
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/addGasto.php?add_gasto_fijo='+ gasto_fijo,
				data: parametros,
				beforeSend: function(objeto){
					$('#label_response_add_gasto').html('Espere, por favor...');
				},
				success: function(datos){
					if(datos.includes("Error")){
						$('#label_response_add_gasto').html(datos);
					}else{
						toastr.success(datos);
						$('#newGastoModal').modal('hide');
						loadGastos();
					}
				}
			});
			event.preventDefault();
		});
		
		///////////////////// EDIT GASTO
		$('#editGastoModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id_gasto = button.data('id')
			var edit_gasto = button.data('gasto')
			var gasto_fijo = button.data('fijo')
			var gasto_importe = button.data('importe')
			var gasto_notas = button.data('notas')
			var gasto_fecha = button.data('fecha')
			
			$('#id_edit_gasto').val(id_gasto);
			$('#edit_gasto').val(edit_gasto);
			$('#edit_gasto_importe').val(gasto_importe);
			$("#edit_gasto_notas").val(gasto_notas);
			$('#edit_gasto_fecha').val(gasto_fecha);
			
			// checkbox gasto fijo
			$.ajax({
				url:'ajax/getEstadoGastoFijo.php.php?id_gasto='+ id_gasto,
				success:function(data){
					console.log(data);
					if(data === "1"){
						$("#edit_checkbox_gasto_fijo").prop("checked", true);
					}else{
						$("#edit_checkbox_gasto_fijo").prop("checked", false);
					}
				}
			});
		})
		
		$('#edit_gasto_modal').submit(function( event ) {
			var gasto_fijo = "0";
			if( $('#checkbox_gasto_fijo').prop('checked') ) {
				gasto_fijo = "1";
			}
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/editGasto.php?edit_gasto_fijo='+ gasto_fijo,
				data: parametros,
				beforeSend: function(objeto){
					$('#response').html('Espere, por favor...');
				},
				success: function(datos){
					if(datos.includes("Error")){
						$('#label_response_edit_gasto').html(datos);
					}else{
						toastr.success(datos);
						$('#editGastoModal').modal('hide');
						loadGastos();
					}
				}
			});
			event.preventDefault();
		});		
		
		///////////////////// MOVIMIENTOS GASTO
		$('#movimientosTrabajoModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id_trabajo = button.data('id')
			var trabajo_cliente = button.data('cliente')
			var trabajo_equipo = button.data('equipo')
			var trabajo_importe = button.data('importe')
			var trabajo_saldo = button.data('saldo')
			var trabajo_saldof = button.data('saldof')
			$('#id_trabajo').val(id_trabajo);
			$('#saldo_trabajo').val(trabajo_saldo);
			$('#cliente_trabajo').val(trabajo_cliente);
			$('#pago_trabajo').val("");
			$('#label_pago_trabajo').html("<h4><b>Cliente: </b>"+ trabajo_cliente +"-"+ trabajo_equipo +"</h4><h4><b>Importe total: </b> $"+ trabajo_importe +"</h4><h4><b>Saldo: </b><font color='green'>$"+ trabajo_saldof +"</font></h4>");
			
			$.ajax({
				type: 'POST',
				url: 'ajax/getPagosTrabajo.php?id_trabajo='+ id_trabajo,
				beforeSend: function(objeto){
					$('#historial_pagos').html('Espere, por favor...');
				},
				success: function(datos){
					$('#historial_pagos').html(datos);
				}
			});
		})
		
		$('#mov_trabajo_modal').submit(function(event){
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/addPaymentTrabajo.php',
				data: parametros,
				beforeSend: function(objeto){
					$('#response_gastos').html('Espere, por favor...');
				},
				success: function(datos){
					if(datos.includes("Error")){
						$('#label_response_pago').html(datos);
					}else{
						toastr.success(datos);
						$('#movimientosTrabajoModal').modal('hide');
						loadGastos();
					}
				}
			});
			event.preventDefault();
		});
		
		///////////////////// INFO GASTO
		$('#infoGastoModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id_trabajo = button.data('id')
			var id_cliente = button.data('idcliente')
			var nombre_cliente = button.data('cliente')
			var notas_trabajo = button.data('notas')
			var fecha_trabajo = button.data('fecha') +" a las "+ button.data('hora');
			$('#id_label_info_gasto').html("<b>Cliente:</b> "+ id_cliente +"-"+ nombre_cliente +"</br></br><b>Notas:</b> "+ notas_trabajo +"</br></br><b>Generado el dia:</b> "+ fecha_trabajo +"</br>");
		})
		
		///////////////////// DELETE GASTO
		$('#deleteGastoModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id_gasto = button.data('id')
			var delete_gasto = button.data('gasto')
			$('#id_delete_gasto').val(id_gasto);
			$('#title_delete_gasto').html("¿Borrar "+ delete_gasto +"?");
		})
		
		$('#delete_gasto_modal').submit(function(event){
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/deleteGasto.php',
				data: parametros,
				beforeSend: function(objeto){
					$('#response_gastos').html('Espere, por favor...');
				},
				success: function(datos){
					toastr.success(datos);
					$('#deleteGastoModal').modal('hide');
					loadGastos();
				}
			});
			event.preventDefault();
		});
		
		///////////////////// CAMBIAR ESTADO GASTO
		$('#cambiarEstadoGastoModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id_gasto = button.data('id')
			$('#id_gasto_estado').val(id_gasto);
			$('#response_cambiar_estado').html("");
		})
		
		$('#cambiar_estado_gasto_modal').submit(function( event ) {
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/changeEstadoGasto.php',
				data: parametros,
				beforeSend: function(objeto){
					$('#response_cambiar_estado').html('Espere, por favor...');
				},
				success: function(datos){
					if(datos.includes("Error")){
						$('#response_cambiar_estado').html(datos);
					}else{
						$('#response_cambiar_estado').html(datos);
						$('#cambiarEstadoGastoModal').modal('hide');
						loadGastos();
					}
				}
			});
			event.preventDefault();
		});		
		
		///////////////////// LOGOUT
		$('#logout_modal').submit(function(event){
			$.ajax({
				type: 'POST',
				url: 'logout.php?logout',
				beforeSend: function(objeto){},
				success: function(datos){
					window.location.reload();
				}
			});
			event.preventDefault();
		});
		
		function setFechaHoy(id_label){ // yyyy-MM-dd
			var today = new Date();
			var getDia = today.getDate();
			var getMes = today.getMonth() + 1;
			if(getDia <= 9){
				getDia = "0"+ getDia;
			}	
			if(getMes <= 9){
				getMes = "0"+ getMes;
			}
			var getAnio = today.getFullYear();
			var date = getAnio +'-'+ getMes +'-'+ getDia;
			$('#'+ id_label +'').val(date);
		}
		
		function isEmpty(str) {
			return (!str || 0 === str.length);
		}