<div id="editGastoModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="edit_gasto_modal" id="edit_gasto_modal">
				<div class="modal-header">
					<h4 class="modal-title">Editar gasto</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="id_edit_gasto" name="id_edit_gasto" />
					<div class="icheck-primary d-inline">
						<input type="checkbox" name="edit_checkbox_gasto_fijo" id="edit_checkbox_gasto_fijo" /><label for="checkbox_gasto_fijo"> Es un gasto fijo</label>
					</div></br></br>
					
					<div class="form-group">
						<label>Gasto</label>
						<input type="text" name="edit_gasto" id="edit_gasto" placeholder="Ingrese el gasto..." class="form-control" />
					</div>
					
					<div class="form-group">
						<label>Importe</label>
						<input type="number" name="edit_gasto_importe" id="edit_gasto_importe" placeholder="Ingrese el importe del gasto..." class="form-control" />
					</div>
					
					<div class="form-group">
						<label>Notas</label>
						<textarea name="edit_gasto_notas" id="edit_gasto_notas" rows="4" cols="50" placeholder="Ingrese una nota..." class="form-control"></textarea>
					</div>
					
					<div class="form-group">
						<label>Fecha</label>
						<input type="date" name="edit_gasto_fecha" id="edit_gasto_fecha" class="form-control" />
					</div>
					
					<div class="form-group">
						<label id="label_response_edit_gasto"></label>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
					<input type="submit" class="btn btn-success" value="Agregar">
				</div>
			</form>
		</div>
	</div>
</div>