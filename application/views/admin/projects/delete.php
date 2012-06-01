<div class="admin-panel">
<div class="page-header">
	<h1>Delete Project</h1>
</div>
<p>Are you sure you want to delete this project '<?=$project->name?>'?</p>
<?=form_open(current_url())?>
	<div class="control-group">
		<div class="controls">
			<label class="radio"><input type="radio" name="confirm" value="yes" checked="checked"> Yes</label>
			<label class="radio"><input type="radio" name="confirm" value="no"> No</label>
		</div>
	</div>
	<?=form_hidden($csrf)?>
	<?=form_hidden(array('id' => $project->id))?>
	<div class="controls">
		<?=form_submit('delete_project', 'Submit', 'class="btn btn-danger"')?>
		<a href="<?=base_url('admin/projects')?>" class="btn">Cancel</a>
	</div>
<?=form_close()?>
</div>