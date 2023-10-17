<div id="addCuentaModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="add_cuenta_modal" id="add_cuenta_modal">
				<div class="modal-header">
					<h4 class="modal-title">Agregar cuenta</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Nombre del banco</label>
						<input type="text" name="add_nombre_banco" id="add_nombre_banco" placeholder="Ingrese el nombre..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Numero CBU</label>
						<input type="number" name="add_cbu_banco" id="add_cbu_banco" placeholder="Ingrese el numero de CBU..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Numero CVU</label>
						<input type="number" name="add_cvu_banco" id="add_cvu_banco" placeholder="Ingrese el numero de CVU..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Alias</label>
						<input type="text" name="add_alias_banco" id="add_alias_banco" placeholder="Ingrese el alias" class="form-control" />
					</div>
					<div class="form-group">
						<label id="response_add_cuenta"></label>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
					<input type="submit" id="button_add_cuenta" class="btn btn-success" value="Agregar">
				</div>
			</form>
		</div>
	</div>
</div>