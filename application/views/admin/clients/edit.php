<div class="admin-panel">
<div class="page-header">
	<h1>Edit Client</h1>
</div>
<?=form_open(current_url(), 'class="form-horizontal"')?>
	<?=bootstrap_input('username', 'Username', $user->username)?>
	<?=bootstrap_input('first_name', 'First Name', $user->first_name)?>
	<?=bootstrap_input('last_name', 'Last Name', $user->last_name)?>
	<?=bootstrap_input('email', 'Email', $user->email)?>
	<?=bootstrap_input('company', 'Company', $user->company)?>
	<?=bootstrap_input('phone', 'Phone', $user->phone)?>
	<?=bootstrap_textarea('address', 'Address', $user->address)?>
	<?=bootstrap_password('password', 'Password')?>
	<?=bootstrap_password('password_confirm', 'Confirm Password')?>
	<?=bootstrap_dropdown('group_id', 'Group', $groups, $user->group_id)?>
	<div class="controls">
		<?=form_submit('submit', 'Edit Client', 'class="btn btn-primary"'); ?>
		<a href="<?=base_url('admin/clients')?>" class="btn">Cancel</a>
	</div>
<?=form_close()?>
</div>