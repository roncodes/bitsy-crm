<div class="admin-panel">
<div class="page-header">
	<h1>Create New Project</h1>
</div>
<?=form_open(current_url(), 'class="form-horizontal"')?>
	<?=bootstrap_input('project_name', 'Project Name')?>
	<?=bootstrap_input('project_description', 'Project Description')?>
	<?=bootstrap_dropdown('project_client', 'Client', $clients)?>
	<?=bootstrap_input('project_quote', 'Quote')?>
	<?=bootstrap_dropdown('project_group', 'Group', $groups)?>
	<?=bootstrap_dropdown('project_status', 'Status', $status)?>
	<div class="controls">
		<?=form_submit('new_project', 'Create Project', 'class="btn btn-primary"')?>
		<a href="<?=base_url('admin/projects')?>" class="btn">Cancel</a>
	</div>
<?=form_close()?>
</div>