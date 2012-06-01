<div class="admin-panel">
<div class="row-fluid">
	<div class="span5">
		<div class="page-header">
			<h3>Project Groups</h3>
		</div>
		<table class="table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($groups as $group): ?>
				<tr>
					<td><?=$group->id?></td>
					<td><?=$group->name?></td>
					<td><?=$group->description?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div class="span7">
		<div class="page-header">
			<a href="<?=base_url('admin/projects')?>" class="btn pull-right">Back to Projects</a>
			<h3>New Group</h3>
		</div>
		<?=form_open(current_url(), 'class="form-horizontal"')?>
			<?=bootstrap_input('group_name', 'Group Name')?>
			<?=bootstrap_input('group_description', 'Group Description')?>
			<div class="controls">
				<?=form_submit('new_group', 'Create Group', 'class="btn btn-primary"')?>
			</div>
		<?=form_close()?>
	</div>
</div>