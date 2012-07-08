<div class="admin-panel">
<div class="page-header">
	<a href="<?=base_url('admin/options/create')?>" class="btn btn-primary pull-right">Create Option</a>
	<h1>All Options</h1>
</div>
<?php if ( ! empty($options)): ?>
<table class="table">
	<thead>
		<tr>
			<th>Option Name</th>
			<th>Option Value</th>
			<th class="span1"></th>
		</tr>
	</thead>
	<tbody>
	<?php for($i=$row_start;$i<($per_page+$row_start);$i++){ 
			if(isset($options[$i])){
				$option = $options[$i];
	?>
		<tr>
			<td><?=$option->option_name?></td>
			<td><?=$option->option_value?></td>
			<td><a href="<?=base_url('admin/options/edit/'.$option->option_name)?>"><i class="icon-pencil"></i></a></td>
		</tr>
	<?php }} ?>
	</tbody>
</table>
<?=$links?>
<?php else: ?>
<div class="alert alert-error">There are currently no options in the database.</div>
<?php endif; ?>
</div>