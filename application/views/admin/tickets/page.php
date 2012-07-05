<div class="admin-panel">
	<div class="page-header">
		<h1>Tickets</h1>
	</div>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Subject</th>
				<th>Date Opened</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
		<?php for($i=$row_start;$i<($per_page+$row_start);$i++){ 
			if(isset($tickets[$i])){
				$ticket = $tickets[$i];
		?>
		<tr>
			<td><?=$ticket->subject?></td>
			<td><?=date("F j, Y", strtotime($ticket->date_opened))?></td>
			<td><?=$ticket->status?></td>
			<td>
				<a href="<?=base_url('admin/tickets/view/'.$ticket->id)?>" rel="tooltip" title="View this ticket"><i class="icon-eye-open"></i></a>
			</td>
		</tr>
	<?php }} ?>
	</tbody>
</table>
<?=$links?>
</div>
