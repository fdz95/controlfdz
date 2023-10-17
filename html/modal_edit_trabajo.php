<div id="editTrabajoModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="edit_trabajo_modal" id="edit_trabajo_modal">
				<div class="modal-header">
					<h4 class="modal-title">Editar trabajo</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<input type="hidden" name="id_edit_trabajo" id="id_edit_trabajo">
				<input type="hidden" name="edit_trabajo_id_cliente" id="edit_trabajo_id_cliente">
				<input type="hidden" name="id_edit_tipo_trabajo" id="id_edit_tipo_trabajo">
				<div class="modal-body">
					<div class="form-group">
						<label>Cliente</label>
						<input type="text" name="edit_trabajo_cliente" id="edit_trabajo_cliente" placeholder="Ingrese el nombre del cliente..." class="form-control" readonly="readonly"/>
					</div>
					
					<div class="form-group">
						<label>Trabajo</label>
						<input type="text" name="edit_trabajo_select" id="edit_trabajo_select" placeholder="Ingrese un trabajo..." class="form-control" readonly="readonly"/>
					</div>
					
					<div class="form-group">
						<label>Equipo</label>
						<input type="text" name="edit_trabajo_equipo" id="edit_trabajo_equipo" placeholder="Ingrese marca/modelo del equipo..." class="form-control" />
					</div>
					
					<table>
						<tr>
							<td><label for="edit_trabajo_costo">Costo</label><input type="number" name="edit_trabajo_costo" id="edit_trabajo_costo" placeholder="Ingrese el costo..." class="form-control" /></td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td><label for="edit_trabajo_importe">Importe</label><input type="number" name="edit_trabajo_importe" id="edit_trabajo_importe" placeholder="Ingrese el importe..." class="form-control" /></td>
						</tr>
					</table>
					</br>
					<div class="form-group">
						<label>Observaciones</label>
						<textarea name="edit_trabajo_notas" id="edit_trabajo_notas" rows="4" cols="50" placeholder="Ingrese una nota..." class="form-control"></textarea>
					</div>
					
					<div class="form-group">
						<label>Fecha</label>
						<input type="date" name="edit_trabajo_fecha" id="edit_trabajo_fecha" placeholder="Ingrese la fecha..." class="form-control" />
					</div>
					
					<div class="form-group">
						<label id="label_response_edit_trabajo"></label>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
					<input type="submit" id="button_edit_trabajo" class="btn btn-success" value="Guardar">
				</div>
			</form>
		</div>
	</div>
</div>