<div class="panel">
<div class="page-header">
	<h1>Your Projects</h1>
</div>
<table class="table table-striped">
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
	<?php for($i=$row_start;$i<($per_page+$row_start);$i++){ 
			if(isset($projects[$i])){
				$project = $projects[$i];
		?>
		<tr>
			<td><?=$project->name?></td>
			<td><?=$project->client?></td>
			<td><?=$project->quote?></td>
			<td><?=$project->created?></td>
			<td><?=$project->last_update?></td>
			<td><?=$project->project_group?></td>
			<td><?=$project->status?></td>
			<td>
				<a href="<?=base_url('client/projects/comment/'.$project->id)?>" rel="tooltip" title="Comment on project"><i class="icon-comment"></i></a>
			</td>
		</tr>
	<?php }} ?>
	</tbody>
</table>
<?=$links?>