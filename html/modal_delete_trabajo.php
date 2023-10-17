<div id="deleteTrabajoModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="delete_trabajo_modal" id="delete_trabajo_modal">
				<div class="modal-header">						
					<h4 class="modal-title">Borrar trabajo</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<p><label id="title_delete_trabajo"></label></p>
					<label id="response_delete_trabajo"></label>
					<input type="hidden" name="id_delete_trabajo" id="id_delete_trabajo">
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
					<input type="submit" id="button_delete_trabajo" class="btn btn-danger" value="Borrar">
				</div>
			</form>
		</div>
	</div>
</div>