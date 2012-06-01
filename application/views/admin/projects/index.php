<div class="admin-panel">
<div class="page-header">
	<a href="<?=base_url('admin/projects/create')?>" class="btn btn-primary pull-right">New Project</a>
	<a href="<?=base_url('admin/projects/groups')?>" class="btn btn-info pull-right" style="margin-right:20px;">Project Groups</a>
	<h1>All Projects</h1>
</div>
<table class="table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Assigned Client</th>
			<th>Quote</th>
			<th>Created</th>
			<th>Last Update</th>
			<th>Group</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($projects as $project): ?>
		<tr>
			<td><?=$project->name?></td>
			<td><?=$project->client?></td>
			<td><?=$project->quote?></td>
			<td><?=$project->created?></td>
			<td><?=$project->last_update?></td>
			<td><?=$project->project_group?></td>
			<td><?=$project->status?></td>
			<td>
				<a href="<?=base_url('admin/projects/invoice/'.$project->id)?>" rel="tooltip" title="Create an invoice"><i class="icon-file"></i></a>
				<a href="<?=base_url('admin/projects/update/'.$project->id)?>" rel="tooltip" title="Update on project"><i class="icon-comment"></i></a>
				<a href="<?=base_url('admin/projects/edit/'.$project->id)?>" rel="tooltip" title="Edit project"><i class="icon-pencil"></i></a>
				<a href="<?=base_url('admin/projects/delete/'.$project->id)?>" rel="tooltip" title="Delete project"><i class="icon-trash"></i></a>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>