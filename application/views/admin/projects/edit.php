<div class="admin-panel">
<div class="page-header">
	<h1>Edit Project</h1>
</div>
<?=form_open(current_url(), 'class="form-horizontal"')?>
	<?=bootstrap_input('project_name', 'Project Name', $project->name)?>
	<?=bootstrap_input('project_description', 'Project Description', $project->description)?>
	<?=bootstrap_dropdown('project_client', 'Client', $clients, $project->client)?>
	<?=bootstrap_input('project_quote', 'Quote', $project->quote)?>
	<?=bootstrap_dropdown('project_group', 'Group', $groups, $project->project_group)?>
	<?=bootstrap_dropdown('project_status', 'Status', $status, $project->status)?>
	<div class="controls">
		<?=form_submit('edit_project', 'Edit Project', 'class="btn btn-primary"')?>
		<a href="<?=base_url('admin/projects')?>" class="btn">Cancel</a>
	</div>
<?=form_close()?>
</div>