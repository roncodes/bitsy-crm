<?php if(isLoggedIn()){ ?>
<div class="panel">
	<div class="page-header">
		<h1>Dashboard <small>welcome, here you can view and pay all your invoices, see your projects status and info</small></h1>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<h3>Your Invoices</h3>
		</div>
		<div class="span4">
			<h3>Your Projects</h3>
		</div>
		<div class="span4">
			<h3>Your Details</h3>
		</div>
	</div>
</div>
<div class="foot">&copy <?php echo date('Y'); ?> Ronald A. Richardson. All Rights Reserved.</div>
<?php } else { ?>
<div class="modal" id="myModal">
	<div class="modal-header">
		<h3>Login</h3>
	</div>
	<div class="modal-body">
		<?php echo form_open('/auth/login', array('class'=>'form-horizontal')); ?>
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
<?php } ?>