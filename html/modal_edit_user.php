<div id="editUserModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="edit_user_modal" id="edit_user_modal">
				<div class="modal-header">
					<h4 class="modal-title">Editar usuario</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Usuario</label>
						<input type="user" name="edit_user" id="edit_user" placeholder="Ingrese el usuario..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Contrase&ntilde;a</label>
						<input type="password" name="edit_user_password" id="edit_user_password" placeholder="Ingrese la contrase&ntilde;a..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Nombre</label>
						<input type="text" name="edit_user_name" id="edit_user_name" placeholder="Ingrese el nombre..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Apellido</label>
						<input type="text" name="edit_user_lastname" id="edit_user_lastname" placeholder="Ingrese el apellido..." class="form-control" />
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="edit_user_email" id="edit_user_email" placeholder="Ingrese el numero..." class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label id="response_edit_user"></label>
				</div>
				<div class="modal-footer justify-content-between">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
					<input type="submit" class="btn btn-success" value="Guardar">
				</div>
			</form>
		</div>
	</div>
</div>