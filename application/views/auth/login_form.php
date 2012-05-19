<div class="fluff">
	<div class="row-fluid">
		<div class="span8">
			<?php echo form_open($this->uri->uri_string(), array('class'=>'form-horizontal')); ?>
				<fieldset>
					<legend>Login</legend>
					<div class="control-group <?php if(form_error('login')){ echo "error"; } ?>">
						<label class="control-label" for="login">Email or login</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="login" name="login">
							<?php echo form_error('login', '<p class="help-inline">', '</p>'); ?>
						</div>
					</div>
					<div class="control-group <?php if(form_error('password')){ echo "error"; } ?>">
						<label class="control-label" for="password">Password</label>
						<div class="controls">
							<input type="password" class="input-xlarge" id="password" name="password">
							<?php echo form_error('password', '<p class="help-inline">', '</p>'); ?>
						</div>
					</div>
					<?php if ($show_captcha) { ?>
					<div class="control-group">
						<label class="control-label <?php if(form_error('captcha')){ echo "error"; } ?>" for="captcha">Confirmination Code</label>
						<div class="controls">
							<?php echo $captcha_html; ?><br><br>
							<input type="text" class="input-xlarge" id="captcha" name="captcha">
							<?php echo form_error('captcha', '<p class="help-inline">', '</p>'); ?>
							<p class="help-block">Enter the code as it exactly appears above</p>
						</div>
					</div>
					<?php } ?>
					<div class="control-group">
						<div class="controls">
							<input type="submit" class="btn btn-primary" id="submit" name="submit" value="Let me in!">
							<p class="help-block"><?php echo anchor('/auth/forgot_password/', 'Forgot password'); ?> | <?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Register'); ?></p>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>