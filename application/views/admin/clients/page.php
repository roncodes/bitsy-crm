<div class="admin-panel">
<div class="page-header">
	<a href="<?=base_url('admin/clients/create')?>" class="btn btn-primary pull-right">New Client</a>
	<h1>All Clients</h1>
</div>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Username</th>
			<th>Email</th>
			<th>Created</th>
			<th>Last Login</th>
			<th>Group</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	<?php for($i=$row_start;$i<($per_page+$row_start);$i++){ 
			if(isset($users[$i])){
				$user = $users[$i];
	?>
		<tr>
			<td><?=trim($user->first_name.' '.$user->last_name)?></td>
			<td><?=$user->username?></td>
			<td><?=$user->email?></td>
			<td><?=date('F jS, Y', $user->created_on)?></td>
			<td><?=date('F jS, Y', $user->last_login)?></td>
			<td><?=ucfirst($user->group_description)?></td>
			<td><?=($user->active) ? anchor(base_url('admin/clients/deactivate/'.$user->id), 'Active') : anchor(base_url('auth/activate/'.$user->id), 'Inactive'); ?></td>
			<td>
				<a href="<?=base_url('admin/clients/edit/'.$user->id)?>" rel="tooltip" title="Edit user"><i class="icon-pencil"></i></a>
				<a href="<?=base_url('admin/clients/delete/'.$user->id)?>" rel="tooltip" title="Delete user"><i class="icon-trash"></i></a>
				<a href="<?=base_url('admin/clients/invoices/'.$user->id)?>" rel="tooltip" title="View this users invoices"><i class="icon-file"></i></a>
			</td>
		</tr>
	<?php }} ?>
	</tbody>
</table>
<?=$links?>