<div id="pagosTrabajoModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="pagos_trabajo_modal" id="pagos_trabajo_modal">
				<div class="modal-header">
					<h4 class="modal-title">Pagos</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<input type="hidden" name="id_trabajo" id="id_trabajo">
				<input type="hidden" name="saldo_trabajo" id="saldo_trabajo">
				<input type="hidden" name="cliente_trabajo" id="cliente_trabajo">
				<div class="modal-body">
					<div class="form-group">
						<label id="label_pago_trabajo"></label>
					</div>
					<hr>
					<div class="form-group">
						<div id="historial_pagos" class="form-group"></div>
					</div>
					<hr>
					<div class="container">
						<div class="row">
							<div class="col">
								<label>Pago</label>
								<input type="number" name="pago_trabajo" id="pago_trabajo" placeholder="Ingrese el importe..." class="form-control" />
							</div>
							<div class="col">
								<label>Fecha</label>
								<input type="date" name="pago_trabajo_fecha" id="pago_trabajo_fecha" placeholder="Ingrese la fecha..." class="form-control" />
							</div>
						</div>
					</div>
					</br>
					<div id="response_pago"></div>
				</div>
				<div class="modal-footer justify-content-between">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
					<input type="submit" id="button_add_pago" class="btn btn-success" value="Listo">
				</div>
			</form>
		</div>
	</div>
</div>