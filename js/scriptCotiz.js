		$(function() {
			loadCotiz();
		});
		
		function loadCotiz(){
			$.ajax({
				url:'ajax/getCotiz.php',
				beforeSend: function(objeto){
					$('#loader_cotiz').html("Cargando...");
				},
				success:function(data){
					$('.outer_div_cotiz').html(data);
					$('#loader_cotiz').html("");
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
			toastr.info('Copiado al portapapeles');
		}
		
		///////////////////// DELETE COTIZ
		$('#deleteCotizModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id_cotiz = button.data('id')
			var cotiz_cliente = button.data('cliente')
			$('#id_delete_cotiz').val(id_cotiz);
			$('#title_delete_cotiz').html("¿Seguro que desea borrar la cotizaci&oacute;n para el cliente "+ cotiz_cliente +"?");
		})
		
		$('#delete_cotiz_modal').submit(function(event){
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/deleteCotiz.php',
				data: parametros,
				beforeSend: function(objeto){
					$('#response_cotiz').html('Espere, por favor...');
				},
				success: function(datos){
					$('#response_cotiz').html(datos);
					$('#deleteCotizModal').modal('hide');
					loadCotiz();
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