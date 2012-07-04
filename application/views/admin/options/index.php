<div class="admin-panel">
<div class="page-header">
	<a href="<?=base_url('admin/options/create')?>" class="btn btn-primary pull-right">Create Option</a>
	<h1>All Options</h1>
</div>
<?php if ( ! empty($settings)): ?>
<table class="table">
	<thead>
		<tr>
			<th>Option Name</th>
			<th>Option Value</th>
			<th class="span1"></th>
		</tr>
	</thead>
	<tbody>
	<?=var_dump($settings)?>
	<?php for($i=$row_start;$i<($per_page+$row_start);$i++){ 
		if(isset($settings[$i])){
			$setting = $settings[$i];
	?>
		<tr>
			<td><?=$name?></td>
			<td><?=$setting?></td>
			<td><a href="<?=base_url('admin/options/edit/'.$name)?>"><i class="icon-pencil"></i></a></td>
		</tr>
	<?php }} ?>
	</tbody>
</table>
<?=$links?>
<?php else: ?>
<div class="alert alert-error">There are currently no options in the database.</div>
<?php endif; ?>
</div>