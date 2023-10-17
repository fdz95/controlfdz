<div id="cambiarEstadoGastoModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="cambiar_estado_gasto_modal" id="cambiar_estado_gasto_modal">
				<div class="modal-header">						
					<h4 class="modal-title">Cambiar estado</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id_gasto_estado" id="id_gasto_estado">
					
					<div class="form-group">
						<input type="radio" id="estado_en_rep" name="cambiar_estado" value="EN_REP">
						<label for="estado_en_rep">En reparacion</label><br>
						<input type="radio" id="estado_esp_rep" name="cambiar_estado" value="ESP_REP">
						<label for="estado_esp_rep">Esperando repuesto</label><br>
						<input type="radio" id="estado_no_rep" name="cambiar_estado" value="NO_REP">
						<label for="estado_no_rep">No se puede reparar</label><br>
						<input type="radio" id="estado_esp_pago" name="cambiar_estado" value="ESP_PAGO">
						<label for="estado_no_rep">Esperando pago</label><br>
						<input type="radio" id="estado_otro" name="cambiar_estado" value="OTRO" checked>
						<label for="estado_otro">Otro</label><br>
					</div>
					<label id="response_cambiar_estado"></label>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
					<input type="submit" class="btn btn-info" value="Cambiar">
				</div>
			</form>
		</div>
	</div>
</div>