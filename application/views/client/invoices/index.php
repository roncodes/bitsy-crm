<div class="panel">
<div class="page-header">
	<h1>Your Invoices</h1>
</div>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Invoice ID</th>
				<th>Project</th>
				<th>Due Date</th>
				<th>Recurring</th>
				<th>Amount Paid</th>
				<th>Amount Due</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php for($i=$row_start;$i<($per_page+$row_start);$i++){ 
				if(isset($invoices[$i])){
					$invoice = $invoices[$i];
			?>
			<tr>
				<td><?=$invoice->invoice_id?></td>
				<td><?=$invoice->project->name?></td>
				<td><?=date('F j, Y, g:i a', strtotime($invoice->date)).' '.past_due($invoice->date)?></td>
				<td><?php if($invoice->recurring){ list($recur,$by) = explode('|', $invoice->recur_every); echo 'Every '.$recur.' '.$by; } else { echo "Non recurring"; } ?></td>
				<td><?=_money_format($invoice->amount_paid)?></td>
				<td><?=_money_format($invoice->amount_due)?></td>
				<td><?=$invoice->status?></td>
				<td>
					<a href="<?=base_url('client/invoices/view/'.$invoice->id)?>" rel="tooltip" title="View this invoice"><i class="icon-eye-open"></i></a>
					<a href="<?=base_url('client/invoices/download/'.$invoice->id)?>" rel="tooltip" title="Download this invoice as PDF"><i class="icon-download"></i></a>
					<?php if($invoice->status!='Paid'){ ?>
					<a href="<?=base_url('client/invoices/pay/'.$invoice->id)?>" title="Make a payment">Make a payment</a>
					<?php } ?>
				</td>
			</tr>
		<?php }} ?>
		</tbody>
	</table>
	<?=$links?>
</div>
