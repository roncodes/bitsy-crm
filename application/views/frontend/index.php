<?php if(logged_in()){ ?>
<div class="panel">
	<div class="page-header">
		<a href="client/tickets" class="btn btn-info pull-right">Submit Support Ticket</a>
		<h1>Dashboard <small>welcome, here you can view and pay all your invoices, see your projects status and info</small></h1>
	</div>
	<div class="row-fluid">
		<div class="span4 section-panel">
			<h3>Your Recent Invoices</h3>
			<?php foreach($invoices as $invoice){ ?>
			<a href="<?=base_url('client/invoices/view/'.$invoice->id)?>" class="btn invoice-btn"><i class="icon-file"></i> #<?=$invoice->invoice_id?> | <?=date('F j, Y, g:i a', strtotime($invoice->date))?></a>
			<?php } ?>
		</div>
		<div class="span3 section-panel">
			<h3>Your Recent Projects</h3>
			<?php foreach($projects as $project){ ?>
			<a href="<?=base_url('client/projects/comment/'.$project->id)?>" class="btn invoice-btn"><i class="icon-folder-open"></i> <?=$project->name?> | <?=date('F j, Y, g:i a', strtotime($project->last_update))?></a>
			<?php } ?>
		</div>
		<div class="span4 section-panel">
			<h3>Your Details<a href="<?=base_url('client/profile')?>" class="btn pull-right">Update Your Profile</a></h3>
			<b><?=$user->first_name.' '.$user->last_name?></b><br>
			<?=$user->company?><br>
			<?=$user->email?><br>
			<?=$user->phone?><br>
			<?=$user->address?><br>
		</div>
	</div>
</div>
<div class="foot">&copy <?php echo date('Y'); ?> Ronald A. Richardson. All Rights Reserved.</div>
<?php } else { ?>
<div class="modal">
	<div class="modal-header">
		<h3>Login</h3>
	</div>
	<div class="modal-body">
		<?php echo form_open('/auth/login', array('class'=>'form-horizontal')); ?>
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="email">Email</label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="email" name="email">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="password">Password</label>
					<div class="controls">
						<input type="password" class="input-xlarge" id="password" name="password">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label class="checkbox"><?=form_checkbox('remember', '1', FALSE)?> Remember me</label>
					</div>
				</div>
			</fieldset>
	</div>
	<div class="modal-footer">
		<a href="<?=base_url('auth/forgot_password')?>">Forgot password?</a>
		<button type="submit" class="btn btn-primary">Login</button>
	</form>
	</div>
</div>
<?php } ?>