<div class="modal">
	<div class="modal-header">
	<h3>Forgot Password <small>Please enter your <?=$identity_human?> to reset your password.</small></h3>
	</div>
	<div class="modal-body">
	<?=form_open(current_url(), 'class="form-horizontal"')?>
		<?php bootstrap_input($identity, $identity_human); ?>
		<div class="controls">
			<?=form_submit('submit', 'Submit', 'class="btn btn-primary"')?>
		</div>
	<?=form_close()?>
	</div>
</div>