		$(function() {
			loadClientes();
		});
		
		// CARGA DE CLIENTES
		function loadClientes(){
			$.ajax({
				url:'ajax/getClientes.php',
				beforeSend: function(objeto){
					$('#loader').html("Cargando...");
				},
				success:function(data){
					$('.outer_div').html(data);
					$('#loader').html('');
				}
			});
			$('#response_add_cliente').html("");
			$('#response_edit_cliente').html("");
		}
		
		// MENU AGREGAR CLIENTE
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
						loadClientes();
						toastr.success(datos);
						$('#addClienteModal').modal('hide');
					}
					document.querySelector('#button_add_cliente').disabled = false;
				}
				
			});
			event.preventDefault();
		});
		
		// MENU EDITAR CLIENTE
		$('#editClienteModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id = button.data('id')
			$('#id_edit_cliente').val(id)
			var nombre = button.data('nombre')
			$('#edit_cliente_name').val(nombre)
			var apellido = button.data('apellido')
			$('#edit_cliente_lastname').val(apellido)
			var celular = button.data('celular')
			$('#edit_cliente_celular').val(celular)
			var email = button.data('email')
			$('#edit_cliente_email').val(email)
		});
		
		// FUNCION EDITAR CLIENTE
		$('#edit_cliente_modal').submit(function( event ) {
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/editCliente.php',
				data: parametros,
				beforeSend: function(objeto){
					document.querySelector('#button_edit_cliente').disabled = true;
					$('#response_edit_cliente').html("<b>Espere, por favor...</b>");
				},
				success: function(datos){
					if(datos.includes("error")){
						$('#response_edit_cliente').html(datos);
					}else{
						loadClientes();
						toastr.success(datos);
						$('#editClienteModal').modal('hide');
					}
					document.querySelector('#button_edit_cliente').disabled = false;
				}
				
			});
			event.preventDefault();
		});
		
		//MENU BORRAR CLIENTE
		$('#deleteClienteModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id_cliente = button.data('id')
			$('#id_delete_cliente').val(id_cliente)
			var cliente_nombre = button.data('nombre')
			$('#delete_cliente').val(cliente_nombre)
			$('#id_delete_title_cliente').html("¿Seguro que quieres borrar el cliente "+ cliente_nombre +"?")
			$('#response_delete_cliente').html("")
		})
		
		// FUNCION BORRAR CLIENTE
		$('#delete_cliente_modal').submit(function( event ) {
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/deleteCliente.php',
				data: parametros,
				beforeSend: function(objeto){
					document.querySelector('#button_delete_cliente').disabled = true;
					$('#response_delete_cliente').html("<b>Espere, por favor...</b>");
				},
				success: function(datos){
					if(datos.includes("error")){
						$('#response_delete_cliente').html(datos);
					}else{
						loadClientes();
						toastr.success(datos);
						$('#deleteClienteModal').modal('hide');
					}
					document.querySelector('#button_delete_cliente').disabled = false;
				}
				
			});
			event.preventDefault();
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
		
		function isEmpty(str) {
			return (!str || 0 === str.length);
		}