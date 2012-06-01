<div class="modal">
	<div class="modal-header">
		<h3>Login <small>Please login with your email address and password below.</small></h3>
	</div>
	<div class="modal-body">
	<?=form_open(current_url(), 'class="form-horizontal"')?>
		<?php bootstrap_input('email', 'Email'); ?>
		<?php bootstrap_password('password', 'Password'); ?>
		<div class="control-group">
			<div class="controls">
				<label class="checkbox"><?=form_checkbox('remember', '1', FALSE)?> Remember me</label>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<a href="<?=base_url('auth/forgot_password')?>">Forgot password?</a>
		<?=form_submit('submit', 'Login', 'class="btn btn-primary"')?>
	</div>
	<?=form_close()?>
	</div>
</div>