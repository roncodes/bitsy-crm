<div class="fluff">
	<?php echo form_open($this->uri->uri_string(), array('class'=>'form-horizontal')); ?>
		<fieldset>
			<legend>Create an account</legend>
			<div class="control-group <?php if(form_error('username')){ echo "error"; } ?>">
				<label class="control-label" for="username">Username</label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="username" name="username">
					<?php echo form_error('username', '<p class="help-inline">', '</p>'); ?>
				</div>
			</div>
			<div class="control-group <?php if(form_error('email')){ echo "error"; } ?>">
				<label class="control-label" for="email">Email Address</label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="email" name="email">
					<?php echo form_error('email', '<p class="help-inline">', '</p>'); ?>
				</div>
			</div>
			<div class="control-group <?php if(form_error('password')){ echo "error"; } ?>">
				<label class="control-label" for="password">Password</label>
				<div class="controls">
					<input type="password" class="input-xlarge" id="password" name="password">
					<?php echo form_error('password', '<p class="help-inline">', '</p>'); ?>
				</div>
			</div>
			<div class="control-group <?php if(form_error('confirm_password')){ echo "error"; } ?>">
				<label class="control-label" for="confirm_password">Confirm Password</label>
				<div class="controls">
					<input type="password" class="input-xlarge" id="confirm_password" name="confirm_password">
					<?php echo form_error('confirm_password', '<p class="help-inline">', '</p>'); ?>
				</div>
			</div>
			<div class="control-group <?php if(form_error('captcha')){ echo "error"; } ?>">
				<label class="control-label" for="captcha">Confirmination Code</label>
				<div class="controls">
					<?php echo $captcha_html; ?><br><br>
					<input type="text" class="input-xlarge" id="captcha" name="captcha">
					<?php echo form_error('captcha', '<p class="help-inline">', '</p>'); ?>
					<p class="help-block">Enter the code as it exactly appears above</p>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<input type="submit" class="btn btn-success" id="register" name="register" value="Create Account!">
				</div>
			</div>
		</fieldset>
	<?php echo form_close(); ?>
</div>