<div class="admin-panel">
<div class="page-header">
	<h1>Deactivate Client</h1>
</div>
<p>Are you sure you want to deactivate the client '<?=$user->username?>'?</p>
<?=form_open(current_url())?>
	<div class="control-group">
		<div class="controls">
			<label class="radio"><input type="radio" name="confirm" value="yes" checked="checked"> Yes</label>
			<label class="radio"><input type="radio" name="confirm" value="no"> No</label>
		</div>
	</div>
	<?=form_hidden($csrf)?>
	<?=form_hidden(array('id' => $user->id))?>
	<div class="controls">
		<?=form_submit('submit', 'Submit', 'class="btn btn-danger"')?>
		<a href="<?=base_url('admin/clients')?>" class="btn">Cancel</a>
	</div>
<?=form_close()?>
</div>