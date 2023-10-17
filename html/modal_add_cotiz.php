<div id="newCotizModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="add_cotiz_modal" id="add_cotiz_modal">
				<div class="modal-header">
					<h4 class="modal-title">Agregar cotizaci&oacute;n</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Cliente</label></br>
						<select id="add_trabajo_cliente" name="add_trabajo_cliente" style="width:100%;"></select>
					</div>
					<input type="hidden" id="add_trabajo_id_cliente" name="add_trabajo_id_cliente" />
					
					<div class="form-group">
						<label>Trabajo</label></br>
						<select id="add_trabajo_select" name="add_trabajo_select" style="width:100%;"></select>
					</div>
					
					<div class="form-group">
						<label>Equipo</label>
						<input type="text" name="add_trabajo_equipo" id="add_trabajo_equipo" placeholder="Ingrese marca/modelo del equipo..." class="form-control" />
					</div>
					
					<table>
						<tr>
							<td><label for="add_trabajo_costo">Costo</label><input type="number" name="add_trabajo_costo" id="add_trabajo_costo" placeholder="Ingrese el costo..." class="form-control" /></td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td><label for="add_trabajo_importe">Importe</label><input type="number" name="add_trabajo_importe" id="add_trabajo_importe" placeholder="Ingrese el importe..." class="form-control" /></td>
						</tr>
					</table>
					</br>
					<div class="form-group">
						<label>Observaciones</label>
						<textarea name="add_trabajo_notas" id="add_trabajo_notas" rows="4" cols="50" placeholder="Ingrese una nota..." class="form-control"></textarea>
					</div>
					
					<div class="form-group">
						<label>Fecha</label>
						<input type="date" name="add_trabajo_fecha" id="add_trabajo_fecha" placeholder="Ingrese la fecha..." class="form-control" /></br>
					</div>
					
					<div class="form-group">
						<label id="label_response_add_trabajo"></label>
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