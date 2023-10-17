<div id="newGastoModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="add_gasto_modal" id="add_gasto_modal">
				<div class="modal-header">
					<h4 class="modal-title">Agregar gasto</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="icheck-primary d-inline">
						<input type="checkbox" name="checkbox_gasto_fijo" id="checkbox_gasto_fijo" /><label for="checkbox_gasto_fijo"> Es un gasto fijo</label>
					</div></br></br>
					
					<div class="form-group">
						<label>Gasto</label>
						<input type="text" name="add_gasto" id="add_gasto" placeholder="Ingrese el gasto..." class="form-control" />
					</div>
					
					<div class="form-group">
						<label>Importe</label>
						<input type="number" name="add_gasto_importe" id="add_gasto_importe" placeholder="Ingrese el importe del gasto..." class="form-control" />
					</div>
					
					<div class="form-group">
						<label>Notas</label>
						<textarea name="add_gasto_notas" id="add_gasto_notas" rows="4" cols="50" placeholder="Ingrese una nota..." class="form-control"></textarea>
					</div>
					
					<div class="form-group">
						<label>Fecha</label>
						<input type="date" name="add_gasto_fecha" id="add_gasto_fecha" class="form-control" />
					</div>
					
					<div class="form-group">
						<label id="label_response_add_gasto"></label>
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