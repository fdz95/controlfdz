<div id="addClienteModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="add_cliente_modal" id="add_cliente_modal">
				<div class="modal-header">
					<h4 class="modal-title">Agregar cliente</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Nombre</label>
						<input type="text" name="add_cliente_name" id="add_cliente_name" placeholder="Ingrese el nombre..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Apellido</label>
						<input type="text" name="add_cliente_lastname" id="add_cliente_lastname" placeholder="Ingrese el apellido..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Celular</label>
						<input type="number" name="add_cliente_celular" id="add_cliente_celular" placeholder="Ingrese el celular, sin el 0 y sin el 15..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="add_cliente_email" id="add_cliente_email" placeholder="Ingrese un email..." class="form-control" />
					</div>
					<div class="form-group">
						<label id="response_add_cliente"></label>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
					<input type="submit" id="button_add_cliente" class="btn btn-success" value="Agregar">
				</div>
			</form>
		</div>
	</div>
</div>