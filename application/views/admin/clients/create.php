<div class="admin-panel">
<div class="page-header">
	<h1>Create New Client</h1>
</div>
<?=form_open(current_url(), 'class="form-horizontal"')?>
	<?=bootstrap_input('username', 'Username')?>
	<?=bootstrap_input('first_name', 'First Name')?>
	<?=bootstrap_input('last_name', 'Last Name')?>
	<?=bootstrap_input('email', 'Email')?>
	<?=bootstrap_input('company', 'Company')?>
	<?=bootstrap_input('phone', 'Phone')?>
	<?=bootstrap_textarea('address', 'Address')?>
	<?=bootstrap_password('password', 'Password')?>
	<?=bootstrap_password('password_confirm', 'Confirm Password')?>
	<?=bootstrap_dropdown('group_id', 'Group', $groups)?>
	<div class="controls">
		<?=form_submit('submit', 'Create Client', 'class="btn btn-primary"')?>
		<a href="<?=base_url('admin/clients')?>" class="btn">Cancel</a>
	</div>
<?=form_close()?>
</div>