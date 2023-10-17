<div id="cuentasModal" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Cuentas</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div align="right" class="form-group">
					<a href='#' data-target='#addCuentaModal' class='btn btn-success' data-toggle='modal'>Agregar cuenta</a>
				</div>
				<hr>
				<div class="form-group">
					<div id="loader_cuentas"></div>
					<div id="response_cuentas"></div>
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<input type="button" class="btn btn-default" data-dismiss="modal" value="Cerrar">
			</div>
		</div>
	</div>
</div>