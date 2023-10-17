<div id="addUserModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="add_user_modal" id="add_user_modal">
				<div class="modal-header">
					<h4 class="modal-title">Agregar usuario</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Usuario</label>
						<input type="user" name="add_user" id="add_user" placeholder="Ingrese el usuario..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Contrase&ntilde;a</label>
						<input type="password" name="add_user_password" id="add_user_password" placeholder="Ingrese la contrase&ntilde;a..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Nombre</label>
						<input type="text" name="add_user_name" id="add_user_name" placeholder="Ingrese el nombre..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Apellido</label>
						<input type="text" name="add_user_lastname" id="add_user_lastname" placeholder="Ingrese el apellido..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="add_user_email" id="add_user_email" placeholder="Ingrese un email..." class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label id="response_add_user"></label>
				</div>
				<div class="modal-footer justify-content-between">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
					<input type="submit" class="btn btn-success" value="Agregar">
				</div>
			</form>
		</div>
	</div>
</div>