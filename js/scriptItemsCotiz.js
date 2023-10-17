		$(function() {
			var id_cliente = document.getElementById("add_id_cliente").value;
			if(id_cliente == ""){
				document.getElementById("div-add-cliente").style.visibility = "visible";
			}else{
				document.getElementById("div-add-cliente").style.visibility = "hidden";
				document.getElementById("div-add-item").style.visibility = "visible";
				var id_cotiz = document.getElementById("add_id_cotiz").value;
				loadDataCotiz(id_cotiz);
			}
		});
		
		// SELECT2 CLIENTES SEARCH
		$('#search_cliente').select2({
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
			placeholder: 'Seleccione un cliente, por codigo o nombre',
			theme: "classic",
            casesensitive: false
        });
		
		$('#search_cliente').on('select2:select', function (e) {
			var id_cliente = e.params.data.id;
			$('#add_id_cliente').val(id_cliente); 	
			var id_cotiz = document.getElementById("add_id_cotiz").value;
			loadDataCotiz(id_cotiz);
			document.getElementById("div-add-item").style.visibility = "visible";
		});
		
		function loadDataCotiz(id_cotiz){
			console.log("id_cotiz: "+ id_cotiz);
			$.ajax({
				url:'ajax/getDataCotiz.php?c='+ id_cotiz,
				beforeSend: function(objeto){
					$('#loader_items_cotiz').html("Cargando...");
				},
				success:function(data){
					$('.outer_div_items_cotiz').html(data);
					$('#loader_items_cotiz').html("");
					limpiarCampos();
				}
			});
		}
		
		function agregarItemCotiz(){
			var add_id_cotiz = document.getElementById("add_id_cotiz").value;
			var add_id_cliente = document.getElementById("add_id_cliente").value;
			var add_cotiz_prov = document.getElementById("add_cotiz_prov").value;
			var add_cotiz_tipo = document.getElementById("add_cotiz_tipo").value;
			var add_cotiz_item = document.getElementById("add_cotiz_item").value;
			var add_cotiz_cant = document.getElementById("add_cotiz_cant").value;
			var add_cotiz_precio = document.getElementById("add_cotiz_precio").value;
			var add_cotiz_porc = document.getElementById("add_cotiz_porc").value;
			
			$.ajax({
				type: 'POST',
				url: 'ajax/addItemCotiz.php?add_id_cotiz='+ add_id_cotiz +'&add_id_cliente='+ add_id_cliente +'&add_cotiz_prov='+ add_cotiz_prov +'&add_cotiz_tipo='+ add_cotiz_tipo +'&add_cotiz_item='+ add_cotiz_item +'&add_cotiz_cant='+ add_cotiz_cant +'&add_cotiz_precio='+ add_cotiz_precio +'&add_cotiz_porc='+ add_cotiz_porc,
				beforeSend: function(objeto){
					$('#loader_items_cotiz').html('Espere, por favor...');
				},
				success: function(datos){
					console.log(datos);
					$('#loader_items_cotiz').html("");
					if(datos.includes("Error")){
						$('#response_items_cotiz').html(datos);
					}else{
						loadDataCotiz(add_id_cotiz);
					}
				}
			});
		}
		
		$(document).on('click','#delete_item_cotiz',function(event) {
			var id_cotiz = $(this).data('cotiz');
			var id_item = $(this).data('item');
			$.ajax({
				type: 'POST',
				url: 'ajax/deleteItemCotiz.php?delete_id_cotiz='+ id_cotiz +'&delete_item_cotiz='+ id_item,
				success: function(datos){
					console.log(datos);
					loadDataCotiz(id_cotiz);
				}
			});
		});
		
		function limpiarCampos(){
			$('#add_cotiz_tipo').val("");
			$('#add_cotiz_item').val("");
			$('#add_cotiz_cant').val("1");
			$('#add_cotiz_precio').val("");
			$('#response_items_cotiz').html("");
			document.getElementById("add_cotiz_prov").focus();
		}
		
		///////////////////// CREAR COTIZ
		$('#generarCotizModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id_cotiz = button.data('cotiz')
			$('#id_generar_cotiz').val(id_cotiz);
			var id_cliente = button.data('cliente')
			$('#id_generar_cotiz_cliente').val(id_cliente);
			$('#title_generar_cotiz').html("Se generar&aacute; una cotizaci&oacute;n para el cliente");
		})
		
		$('#generar_cotiz_modal').submit(function(event){
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/generarCotiz.php',
				data: parametros,
				beforeSend: function(objeto){
					$('#loader_items_cotiz').html("Espere, por favor...");
				},
				success: function(datos){
					$('#loader_items_cotiz').html("");
					if(datos.includes("Error")){
						$('#response_items_cotiz').html(datos);
					}else{
						toastr.success(datos);
						$('#generarCotizModal').modal('hide');
						$('#loader_items_cotiz').html("Espere, por favor...");
						setTimeout(() => {  window.location.href = "cotiz.php"; }, 1000);
					}
				}
			});
			event.preventDefault();
		});
		
		///////////////////// CANCEL COTIZ
		$('#cancelCotizModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var id_cotiz = button.data('cotiz')
			$('#id_cancel_cotiz').val(id_cotiz);
			$('#title_cancel_cotiz').html("¿Seguro que desea cancelar la cotizaci&oacute;n del cliente?");
		})
		
		$('#cancel_cotiz_modal').submit(function(event){
			var parametros = $(this).serialize();
			$.ajax({
				type: 'POST',
				url: 'ajax/cancelCotiz.php',
				data: parametros,
				beforeSend: function(objeto){
					$('#loader_items_cotiz').html("Espere, por favor...");
				},
				success: function(datos){
					$('#loader_items_cotiz').html("");
					if(datos.includes("Error")){
						$('#response_items_cotiz').html(datos);
					}else{
						toastr.success(datos);
						$('#cancelCotizModal').modal('hide');
						$('#loader_items_cotiz').html("Espere, por favor...");
						setTimeout(() => {  window.location.href = "cotiz.php"; }, 1000);
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