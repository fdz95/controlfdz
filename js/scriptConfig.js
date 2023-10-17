	$('#form_add_tipo_trabajo').submit(function( event ) {
		var parametros = $(this).serialize();
		$.ajax({
			type: 'POST',
			url: 'ajax/addTipoTrabajo.php',
			data: parametros,
			beforeSend: function(objeto){
				$('#response_add_tipo_trabajo').html('Espere, por favor...');
			},
			success: function(datos){
				$('#response_add_tipo_trabajo').html(datos);
				$('#add_tipo_trabajo').val("");
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
		