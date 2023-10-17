<div id="editClienteModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="edit_cliente_modal" id="edit_cliente_modal">
				<div class="modal-header">
					<h4 class="modal-title">Editar cliente</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<input type="hidden" name="id_edit_cliente" id="id_edit_cliente">
				<div class="modal-body">
					<div class="form-group">
						<label>Nombre</label>
						<input type="text" name="edit_cliente_name" id="edit_cliente_name" placeholder="Ingrese el nombre..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Apellido</label>
						<input type="text" name="edit_cliente_lastname" id="edit_cliente_lastname" placeholder="Ingrese el apellido..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Celular</label>
						<input type="number" name="edit_cliente_celular" id="edit_cliente_celular" placeholder="Ingrese el celular, sin el 0 y sin el 15..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="edit_cliente_email" id="edit_cliente_email" placeholder="Ingrese un email..." class="form-control" />
					</div>
					<div class="form-group">
						<label id="response_edit_cliente"></label>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
					<input type="submit" id="button_edit_cliente" class="btn btn-success" value="Guardar">
				</div>
			</form>
		</div>
	</div>
</div>