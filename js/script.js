		// VERIFICO SI HAY ACTUALIZACIONES LEYENDO EL VALOR DEVUELTO POR LA BD, 
		// Y MUESTRO EL CARTEL DE ACTUALIZACION
		window.onload = function () {
			if(document.getElementById("input_show_updates").value == "1"){
				$("#updatesModal").modal('show');
			}
		};
		
		// REFRESCO LA PAGINA (read js) SI HAY ACTUALIZACIONES
		$('#form_updates_modal').submit(function(event){
			$.ajax({
				type: 'POST',
				url: 'ajax/updatesModal.php',
				success: function(datos){
					$('#updatesModal').modal('hide');
					window.location.reload(true);
				}
			});
			event.preventDefault();
		});
		
		// CTRL + F5
		$(document).keydown(function(e) {
			if (e.keyCode == 116 && e.ctrlKey) {
				$.ajax({
					type: 'POST',
					url: 'ajax/updatesModal.php',
					success: function(datos){
						$('#updatesModal').modal('hide');
					}
				});
			}
		});
		
		$(function() {
			loadTrabajos();
		});
		
		// CARGA DE TRABAJOS
		function loadTrabajos(){
			$.ajax({
				url:'ajax/getTrabajos.php',
				beforeSend: function(objeto){
					$('#loader_trabajo').html("<h3><b>Cargando...</b></h3>");
				},
				success:function(data){
					$('#loader_trabajo').html("");
					$('.outer_div_trabajo').html(data);
					loadTrabajosF();
				}
			});
		}
		
		// CARGA DE TRABAJOS - ORDENAR POR ESTADO (ONCLICK COLUMNA ESTADO)
		function ordenar(){
			$.ajax({
				url:'ajax/getTrabajos.php?ordenar=1',
				beforeSend: function(objeto){
					$('#loader_trabajo').html("<h4><b>Cargando...</b></h4>");
				},
				success:function(data){
					$('#loader_trabajo').html("");
					$('.outer_div_trabajo').html(data);
				}
			});
		}
		
		// CARGA DE TRABAJOS FINALIZADOS
		function loadTrabajosF(buscar = false){
			var url_trabajosf = "";
			if(buscar){
				url_trabajosf = "?search="+ document.getElementById("input_search_trabajof").value;
			}
			$.ajax({
				url:'ajax/getTrabajosFinalizados.php'+ url_trabajosf,
				beforeSend: function(objeto){
					if(buscar){
						$('#loader_trabajo_finalizados').html("<b>Buscando...</b>");
					}
				},
				success:function(data){
					$('#loader_trabajo_finalizados').html("");
					$('.outer_div_trabajo_finalizados').html(data);
				}
			});
		}
	
		function copyStringToClipboard (str) {
			// Create new element
			var el = document.createElement('textarea');
			// Set value (string to be copied)
			el.value = str;
			// Set non-editable to avoid focus and move outside of view
			el.setAttribute('readonly', '');
			el.style = {position: 'absolute', left: '-9999px'};
			document.body.appendChild(el);
			// Select text inside element
			el.select();
			// Copy text to clipboard
			document.execCommand('copy');
			// Remove temporary element
			document.body.removeChild(el);
			// Show toast to user
			toastr.info("Copiado al portapapeles");
		}
		
		///////////////////// CUENTAS
		$('#cuentasModal').on('show.bs.modal', function (event) {
			loadCuentas();
		})
		
		///////////////////// ADD CUENTAS
		$('#addCuentaModal').on('show.bs.modal', function (event) {
			$('#add_nombre_banco').val("");
			$('#add_cbu_banco').val("");
			$("#add_cvu_banco").val("");
			$('#add_alias_banco').val("");
			$('#response_add_cuenta').html("");
		})

		$('#add_cuenta_modal').submit(function( event ) {
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/addCuenta.php',
				data: parametros,
				beforeSend: function(objeto){
					document.querySelector('#button_add_cuenta').disabled = true;
					$('#response_add_cuenta').html('Espere, por favor...');
				},
				success: function(datos){
					if(datos.includes("Error")){
						$('#response_add_cuenta').html(datos);
					}else{
						toastr.success(datos);
						$('#addCuentaModal').modal('hide');
						loadCuentas();
					}
					document.querySelector('#button_add_cuenta').disabled = false;
				}
			});
			event.preventDefault();
		});
		
		// CARGA DE CUENTAS
		function loadCuentas(){
			$.ajax({
				url:'ajax/getCuentas.php',
				beforeSend: function(objeto){
					$('#loader_cuentas').html("Cargando...");
				},
				success:function(data){
					$('#response_cuentas').html(data);
					$('#loader_cuentas').html("");
				}
			});
		}
		
		///////////////////// MENU BORRAR CUENTA
		$('#deleteCuentaModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id_cuenta = button.data('id')
			var nombre_cuenta = button.data('cuenta')
			$('#id_delete_cuenta').val(id_cuenta);
			$('#title_delete_cuenta').html("¿Borrar la cuenta de "+ nombre_cuenta +"?");
		})
		
		// FUNCION BORRAR CUENTA
		$('#delete_cuenta_modal').submit(function(event){
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/deleteCuenta.php',
				data: parametros,
				beforeSend: function(objeto){
					document.querySelector('#button_delete_cuenta').disabled = true;
					$('#response_delete_cuenta').html("Espere, por favor...");
				},
				success: function(datos){
					$('#response_delete_cuenta').html("");
					if(datos.includes("error")){
						$('#response_delete_cuenta').html(datos);
					}else{
						toastr.success(datos);
						$('#deleteCuentaModal').modal('hide');
						loadCuentas();
					}
					document.querySelector('#button_delete_cuenta').disabled = false;
				}
			});
			event.preventDefault();
		});
		
		///////////////////// MENU ADD TRABAJO
		$('#newTrabajoModal').on('show.bs.modal', function (event) {
			$("#add_trabajo_select").val(null).trigger("change");
			$("#add_trabajo_cliente").val(null).trigger("change");
			$("#add_trabajo_equipo").val("");
			$('#add_trabajo_costo').val("0");
			$('#add_trabajo_importe').val("");
			$('#add_trabajo_notas').val("");
			$('#add_trabajo_fecha').val("");
			$('#label_response_add_trabajo').html("");
			setFechaHoy('add_trabajo_fecha');
		})
		
		// SELECT2 ADD - CLIENTES
		$('#add_trabajo_cliente').select2({
			ajax: {
				url: "ajax/getClientesSelect2.php",
                type: "POST",
                dataType: "JSON",
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id: obj.id, text: obj.text };
						})
					};
				},
                cache: true
			},
			placeholder: 'Seleccione un cliente',
			theme: "classic",
            casesensitive: false
        });
		
		$('#add_trabajo_cliente').on('select2:select', function (e) {
			var id_cliente = e.params.data.id;
			$('#add_trabajo_id_cliente').val(id_cliente);
		});
		
		// SELECT2 ADD - TRABAJOS
		$('#add_trabajo_select').select2({
			ajax: {
				url: "ajax/getTrabajosSelect2.php",
                type: "POST",
                dataType: "JSON",
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
				processResults: function (data) {
					return {
						results: $.map(data, function(obj) {
							return { id: obj.id, text: obj.text };
						})
					};
				},
                cache: true
			},
			placeholder: 'Seleccione un trabajo',
			theme: "classic",
            casesensitive: false
        });
		
		// FUNCION AGREGAR TRABAJO
		$('#add_trabajo_modal').submit(function( event ) {
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/addTrabajo.php',
				data: parametros,
				beforeSend: function(objeto){
					document.querySelector('#button_add_trabajo').disabled = true;
					$('#label_response_add_trabajo').html('Espere, por favor...');
				},
				success: function(datos){
					if(datos.includes("error")){
						$('#label_response_add_trabajo').html(datos);
					}else{
						loadTrabajos();
						toastr.success(datos);
						$('#newTrabajoModal').modal('hide');
					}
					document.querySelector('#button_add_trabajo').disabled = false;
				}
			});
			event.preventDefault();
		});
		
		///////////////////// MENU EDIT TRABAJO
		$('#editTrabajoModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id_trabajo = button.data('id')
			var trabajo_fecha = button.data('fecha')
			var trabajo_cliente = button.data('cliente')
			var trabajo_equipo = button.data('equipo')
			var trabajo_tipo = button.data('tipo')
			var trabajo_observ = button.data('observ')
			var trabajo_costo = button.data('costo')
			var trabajo_importe = button.data('importe')
			
			$('#id_edit_trabajo').val(id_trabajo);;
			$('#edit_trabajo_cliente').val(trabajo_cliente);
			$('#edit_trabajo_select').val(trabajo_tipo);
			$("#edit_trabajo_equipo").val(trabajo_equipo);
			$('#edit_trabajo_costo').val(trabajo_costo);
			$('#edit_trabajo_importe').val(trabajo_importe);
			$('#edit_trabajo_notas').val(trabajo_observ);
			$('#edit_trabajo_fecha').val(trabajo_fecha);
			setFechaHoy('edit_trabajo_fecha');
		})
		
		// FUNCION EDITAR TRABAJO
		$('#edit_trabajo_modal').submit(function( event ) {
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/editTrabajo.php',
				data: parametros,
				beforeSend: function(objeto){
					document.querySelector('#button_edit_trabajo').disabled = true;
					$('#response').html('Espere, por favor...');
				},
				success: function(datos){
					if(datos.includes("error")){
						$('#label_response_edit_trabajo').html(datos);
					}else{
						loadTrabajos();
						toastr.success(datos);
						$('#editTrabajoModal').modal('hide');
					}
					document.querySelector('#button_edit_trabajo').disabled = false;
				}
			});
			event.preventDefault();
		});		
		
		///////////////////// MENU PAGOS TRABAJO
		$('#pagosTrabajoModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id_trabajo = button.data('id')
			var trabajo_idcliente = button.data('idcliente')
			var trabajo_cliente = button.data('cliente')
			var trabajo_equipo = button.data('equipo')
			var trabajo_importe = button.data('importe')
			var trabajo_saldo = button.data('saldo')
			var trabajo_saldof = button.data('saldof')
			var pago_visible = button.data('visible')
			$('#id_trabajo').val(id_trabajo);
			$('#saldo_trabajo').val(trabajo_saldo);
			$('#cliente_trabajo').val(trabajo_idcliente);
			$('#pago_trabajo').val("");
			$('#response_pago').html("");
			$('#label_pago_trabajo').html("<h4><b>Cliente: </b>"+ trabajo_cliente +"-"+ trabajo_equipo +"</h4><h4><b>Importe total: </b> $"+ trabajo_importe +"</h4><h4><b>Saldo: </b><font color='green'>$"+ trabajo_saldof +"</font></h4>");
			setFechaHoy('pago_trabajo_fecha');
			
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

		///////////////////// MENU PAGOS TRABAJOS FINALIZADOS
		$('#pagosTrabajoModal2').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id_trabajo = button.data('id')
			var trabajo_cliente = button.data('cliente')
			var trabajo_equipo = button.data('equipo')
			var trabajo_importe = button.data('importe')
			var trabajo_saldof = button.data('saldof')
			$('#label_pago_trabajo2').html("<h4><b>Cliente: </b>"+ trabajo_cliente +"-"+ trabajo_equipo +"</h4><h4><b>Importe total: </b> $"+ trabajo_importe +"</h4><h4><b>Saldo: </b><font color='green'>$"+ trabajo_saldof +"</font></h4>");
			
			$.ajax({
				type: 'POST',
				url: 'ajax/getPagosTrabajo.php?id_trabajo='+ id_trabajo,
				beforeSend: function(objeto){
					$('#historial_pagos2').html('Espere, por favor...');
				},
				success: function(datos){
					$('#historial_pagos2').html(datos);
				}
			});
		})
		
		// FUNCION AGREGAR PAGO
		$('#pagos_trabajo_modal').submit(function(event){
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/addPagoTrabajo.php',
				data: parametros,
				beforeSend: function(objeto){
					document.querySelector('#button_add_pago').disabled = true;
					$('#response_pago').html("Espere, por favor...");
				},
				success: function(datos){
					$('#response_pago').html("");
					if(datos.includes("error")){
						$('#response_pago').html(datos);
					}else{
						loadTrabajos();
						toastr.success(datos);
						$('#pagosTrabajoModal').modal('hide');
					}
					document.querySelector('#button_add_pago').disabled = false;
				}
			});
			event.preventDefault();
		});

		///////////////////// MENU INFO TRABAJO
		$('#infoTrabajoModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id_trabajo = button.data('id')
			var id_cliente = button.data('idcliente')
			var nombre_cliente = button.data('cliente')
			var celular_cliente = button.data('celular');
			var notas_trabajo = button.data('notas')
			var fecha_trabajo = button.data('fecha') +" a las "+ button.data('hora');
			$('#id_label_info_trabajo').html("<b>Cliente:</b> "+ id_cliente +"-"+ nombre_cliente +"</br></br><b>Celular:</b> <a href='https://api.whatsapp.com/send?phone="+ celular_cliente +"' target='_blank'>+"+ celular_cliente +"</a></br></br><b>Notas:</b> "+ notas_trabajo +"</br></br><b>Generado el dia:</b> "+ fecha_trabajo +"</br>");
		})
		
		///////////////////// MENU DELETE TRABAJO
		$('#deleteTrabajoModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id_trabajo = button.data('id')
			var trabajo_cliente = button.data('cliente')
			var trabajo_equipo = button.data('equipo')
			$('#id_delete_trabajo').val(id_trabajo);
			$('#title_delete_trabajo').html("¿Borrar "+ trabajo_cliente +"-"+ trabajo_equipo +"?");
		})
		
		// FUNCION BORRAR TRABAJO
		$('#delete_trabajo_modal').submit(function(event){
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/deleteTrabajo.php',
				data: parametros,
				beforeSend: function(objeto){
					document.querySelector('#button_delete_trabajo').disabled = true;
					$('#response_delete_trabajo').html("Espere, por favor...");
				},
				success: function(datos){
					$('#response_delete_trabajo').html("");
					if(datos.includes("error")){
						$('#response_delete_trabajo').html(datos);
					}else{
						toastr.success(datos);
						$('#deleteTrabajoModal').modal('hide');
						loadTrabajos();
					}
					document.querySelector('#button_delete_trabajo').disabled = false;
				}
			});
			event.preventDefault();
		});
		
		///////////////////// MENU CAMBIAR ESTADO TRABAJO
		$('#cambiarEstadoTrabajoModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id_trabajo = button.data('id')
			$('#id_trabajo_estado').val(id_trabajo);
			$('#response_cambiar_estado').html("");
		})
		
		// FUNCION CAMBIAR ESTADO TRABAJO
		$('#cambiar_estado_trabajo_modal').submit(function( event ) {
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/changeEstadoTrabajo.php',
				data: parametros,
				beforeSend: function(objeto){
					document.querySelector('#button_change_estado').disabled = true;
					$('#response_cambiar_estado').html("Espere, por favor...");
				},
				success: function(datos){
					if(datos.includes("error")){
						$('#response_cambiar_estado').html(datos);
					}else{
						$('#cambiarEstadoTrabajoModal').modal('hide');
						loadTrabajos();
					}
					document.querySelector('#button_change_estado').disabled = false;
				}
			});
			event.preventDefault();
		});	
		
		////////////////////// MENU AGREGAR CLIENTE
		$('#addClienteModal').on('show.bs.modal', function (event) {
			$('#add_cliente_name').val("");
			$('#add_cliente_lastname').val("");
			$('#add_cliente_celular').val("");
			$('#add_cliente_email').val("");
			$('#response_add_cliente').html("");
		})
		
		// FUNCION AGREGAR CLIENTE
		$('#add_cliente_modal').submit(function( event ) {
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/addCliente.php',
				data: parametros,
				beforeSend: function(objeto){
					document.querySelector('#button_add_cliente').disabled = true;
					$('#response_add_cliente').html("<b>Espere, por favor...</b>");
				},
				success: function(datos){
					if(datos.includes("error")){
						$('#response_add_cliente').html(datos);
					}else{
						toastr.success(datos);
						$('#addClienteModal').modal('hide');
					}
					document.querySelector('#button_add_cliente').disabled = false;
				}
				
			});
			event.preventDefault();
		});
		
		/////////////////// MENU AGREGAR TIPO DE TRABAJO
		$('#addTipoTrabajoModal').on('show.bs.modal', function (event) {
			$('#add_tipo_trabajo').val("");
			$('#response_add_tipo_trabajo').html("");
		});
		
		// FUNCION AGREGAR TIPO DE TRABAJO
		$('#form_add_tipo_trabajo').submit(function( event ) {
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/addTipoTrabajo.php',
				data: parametros,
				beforeSend: function(objeto){
					document.querySelector('#button_tipo_trabajo').disabled = true;
					$('#response_add_tipo_trabajo').html("Espere, por favor...");
				},
				success: function(datos){
					if(datos.includes("error")){
						$('#response_add_tipo_trabajo').html(datos);
					}else{
						toastr.success(datos);
						$('#addTipoTrabajoModal').modal('hide');
					}
					document.querySelector('#button_tipo_trabajo').disabled = false;
				}
			});
			event.preventDefault();
		});
		
		///////////////////// CALCULADORA
		$('#calculadoraModal').on('show.bs.modal', function (event) {
			$('#calc_costo').val("");
			$('#calc_porcentaje').val(50);
			$('#calc_cuotas').val(0);
			$('#response_calc').html("");
		});
		
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
		
		var a = false;
		var b = false;
		var c = true;
		
		function calcular(solo_mitad,tomar_costo,tomar_importe){
			var result = 0;
			var result_c = 0;
			var ganancia = 0;
			var data = null;
			var calc_costo = Number(document.getElementById("calc_costo").value);
			var calc_porcentaje = Number(document.getElementById("calc_porcentaje").value);
			var calc_cuotas = Number(document.getElementById("calc_cuotas").value);
			
			if(solo_mitad){
				if(tomar_costo){
					result = calc_costo;
					ganancia = result - calc_costo;
				}else if(tomar_importe){
					result = calc_costo + (calc_costo * calc_porcentaje / 100);
					ganancia = result - calc_costo;
				}
				result = result / 2;
			}else{
				if(tomar_costo){
					result = calc_costo;
					ganancia = result - calc_costo;
				}else if(tomar_importe){
					result = calc_costo + (calc_costo * calc_porcentaje / 100);
					ganancia = result - calc_costo;
				}
			}
			
			result_c = result / calc_cuotas;
			
			let pesoARS = Intl.NumberFormat("es-AR", {
				style: "currency",
				currency: "ARS",
			});
			
			data = "<h3><b>Importe:</b> "+ pesoARS.format(result) +"</b></h3></br><h3><font color='green'><b>Ganancia:</b> "+ pesoARS.format(ganancia) +"</b></font></h3>";
			if(calc_cuotas != 0){
				//if(result_c != NaN){
				data = data + "</br></br><h3><b>"+ calc_cuotas +" cuotas de "+ pesoARS.format(result_c) +"</b></h3>";
			}
			$("#response_calc").html(data);
		}
		
		// mitad en cuotas
		function onClickCheckbox(cb) {
			if(cb.checked){
				a = true;
				if(b)calcular(true,true,false);
				if(c)calcular(true,false,true);
			}else{
				a = false;
				if(b)calcular(false,true,false);
				if(c)calcular(false,false,true);
			}
		}
		
		// tomo costo
		function onClickRadio1(cb) {
			if(cb.checked){
				c = false;
				b = true;
				if(a)calcular(true,true,false);
				if(!a)calcular(false,true,false);
			}
		}
		
		// tomo importe
		function onClickRadio2(cb) {
			if(cb.checked){
				b = false;
				c = true;
				if(a)calcular(true,false,true);
				if(!a)calcular(false,false,true);
			}
		}