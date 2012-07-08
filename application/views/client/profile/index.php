<div class="panel">
	<div class="page-header">
		<h1>Your Profile</h1>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?=form_open(current_url(), 'class="form-horizontal"')?>
				<?=bootstrap_input_disabled('username', 'Your Username', $user->username)?>
				<?=bootstrap_input('email', 'Your Email', $user->email)?>
				<?=bootstrap_input('first_name', 'First Name', $user->first_name)?>
				<?=bootstrap_input('last_name', 'Last Name', $user->last_name)?>
				<?=bootstrap_input('company', 'Company', $user->company)?>
				<?=bootstrap_input('phone', 'Phone', $user->phone)?>
				<?=bootstrap_textarea('address', 'Address', $user->address)?>
				<?=bootstrap_dropdown('timezone', 'Timezone', $timezones, $user->timezone)?>
				<div class="controls">
					<?=form_submit('update_profile', 'Update Profile', 'class="btn btn-primary"')?>
				</div>
			<?=form_close()?>
			<br>
		</div>
		<div class="span4">
			<h3>Update Password</h3><hr>
			<?=form_open(current_url(), 'class="form-horizontal"')?>
				<?=bootstrap_password('old_password', 'Old Password')?>
				<?=bootstrap_password('new_password', 'New Password')?>
				<?=bootstrap_password('new_password_confirm', 'Confirm New Password')?>
				<div class="controls">
					<?=form_submit('update_password', 'Update Password', 'class="btn btn-primary"')?>
				</div>
			<?=form_close()?>
		</div>
	</div>
</div>
