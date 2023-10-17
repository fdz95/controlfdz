<div id="deleteClienteModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="delete_cliente_modal" id="delete_cliente_modal">
				<div class="modal-header">						
					<h4 class="modal-title">Borrar cliente</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<p><label id="id_delete_title_cliente"></label></p>
					<label id="response_delete_cliente"></label>
					<input type="hidden" name="id_delete_cliente" id="id_delete_cliente">
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
					<input type="submit" id="button_delete_cliente" class="btn btn-danger" value="Borrar">
				</div>
			</form>
		</div>
	</div>
</div>