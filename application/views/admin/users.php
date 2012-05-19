<div class="welcome">
	<div class="row-fluid fluff">
		<div class="page-header" style="width:95%;">
			<h1>Users <small>Manage users</small></h1>
		</div>
		<div class="span10">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>Email</th>
						<th>Last Login</th>
						<th>Last IP</th>
						<th>Role</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($users as $user){ ?>
					<tr>
						<td><?php echo $user->id; ?></td>
						<td><?php echo $user->email; ?></td>
						<td><?php echo date('Y-m-d', strtotime($user->last_login)); ?></td>
						<td><?php echo $user->last_ip; ?></td>
						<td><?php echo $user->role; ?></td>
						<td><a href="<?php $this->uri->uri_string(); ?>?delete_user&user_id=<?php echo $user->id; ?>">Delete</a></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>