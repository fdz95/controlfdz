$('#login_form').submit(function( event ) {
	$('#response').html('Iniciando sesi&oacute;n...');
	var parametros = $(this).serialize();
	$.ajax({
		type: 'POST',
		url: 'ajax/login.php',
		data: parametros,
		beforeSend: function(objeto){
			document.querySelector('#button_login').disabled = true;
			$('#response').html('Iniciando sesi&oacute;n, por favor espere...');
		},
		success: function(datos){
			if(datos.includes("error")){
				document.querySelector('#button_login').disabled = false;
				$('#response').html(datos);
			}else{
				window.location.replace("/prod/admin/controlFDZ");
			}
		}
	});
	event.preventDefault();
});

function visiblePass() {
	var x = document.getElementById("password_id");
	var y = document.getElementById("span_lock");
	if (x.type === "password") {
		x.type = "text";
		y.className = "fas fa-unlock";
	}else{
		x.type = "password";
		y.className = "fas fa-lock";
	}
}