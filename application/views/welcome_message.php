<div class="modal" id="myModal">
	<div class="modal-header">
		<h3>Login</h3>
	</div>
	<div class="modal-body">
		<?php echo form_open($this->uri->uri_string(), array('class'=>'form-horizontal')); ?>
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="login">Username/ Email</label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="login" name="login">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="password">Password</label>
					<div class="controls">
						<input type="password" class="input-xlarge" id="password" name="password">
					</div>
				</div>
			</fieldset>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary">Login</button>
	</form>
	</div>
</div>