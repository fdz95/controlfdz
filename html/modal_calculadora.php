<div id="calculadoraModal" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Calculadora de ganancias</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<div class="col">
							<label>Costo</label>
							<input type="number" id="calc_costo" name="calc_costo" onchange="calcular(false,false,true)" placeholder="Ingrese el costo..." class="form-control" />
						</div>
						<div class="col">
							<label>Porc. de ganancia</label>
							<input type="number" id="calc_porcentaje" name="calc_porcentaje" onchange="calcular(false,false,true)" placeholder="Ingrese el porcentaje..." value=50 class="form-control" />
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col">
							<label>Cuotas</label>
							<input type="number" id="calc_cuotas" name="calc_cuotas" onchange="calcular(false,false,true)" placeholder="Ingrese la cantidad de cuotas..." class="form-control" />
						</div>
						<div class="col">
							</br>
							<input type="checkbox" id="calc_checkbox1" name="calc_checkbox1" onclick="onClickCheckbox(this)"> Solo la mitad en cuotas</input></br>
							<input type="radio" name="calc_radio" onclick="onClickRadio1(this)"> Tomar el costo</input>
							<input type="radio" name="calc_radio" onclick="onClickRadio2(this)" checked> Tomar el importe</input>
						</div>
					</div>
				</div>
				<hr></br></br>
				<div align="center" id="response_calc"></div>
			</div>
			<div class="modal-footer justify-content-between">
				<input type="button" class="btn btn-default" data-dismiss="modal" value="Cerrar">
			</div>
		</div>
	</div>
</div>