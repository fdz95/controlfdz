		$(function() {
			loadAccount();
		});
		
		function loadAccount(){
			$.ajax({
				url:'ajax/getAccount.php',
				beforeSend: function(objeto){
					$('#loader').html("Cargando...");
				},
				success:function(data){
					$('.outer_div').html(data);
					$('#loader').html('');
				}
			});
		}
		
		$('#form_edit_account').submit(function( event ) {
			console.log('a1');
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/editAccount.php',
				data: parametros,
				beforeSend: function(objeto){
					$('#response_form_account').html('Espere, por favor...');
				},
				success: function(datos){
					$('#loader').html('');
					$('#response_form_account').html(datos);
					loadAccount();
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
		