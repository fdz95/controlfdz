<div id="deleteCuentaModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="delete_cuenta_modal" id="delete_cuenta_modal">
				<div class="modal-header">						
					<h4 class="modal-title">Borrar cuenta</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<label id="title_delete_cuenta"></label>
					<label id="response_delete_cuenta"></label>
					<input type="hidden" name="id_delete_cuenta" id="id_delete_cuenta">
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
					<input type="submit" id="button_delete_cuenta" class="btn btn-danger" value="Borrar">
				</div>
			</form>
		</div>
	</div>
</div>