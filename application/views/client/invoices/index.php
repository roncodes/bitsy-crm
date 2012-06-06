<div class="panel">
<div class="page-header">
	<h1>Your Invoices</h1>
</div>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Invoice ID</th>
				<th>Project</th>
				<th>Amount Paid</th>
				<th>Amount Due</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($invoices as $invoice): ?>
			<tr>
				<td><?=$invoice->invoice_id?></td>
				<td><?=$invoice->project->name?></td>
				<td><?=_money_format($invoice->amount_paid)?></td>
				<td><?=_money_format($invoice->amount_due)?></td>
				<td><?=$invoice->status?></td>
				<td>
					<a href="<?=base_url('client/invoices/view/'.$invoice->id)?>" rel="tooltip" title="View this invoice"><i class="icon-eye-open"></i></a>
					<a href="<?=base_url('client/invoices/download/'.$invoice->id)?>" rel="tooltip" title="Download this invoice as PDF"><i class="icon-download"></i></a>
					<?php if($invoice->status!='Paid'){ ?>
					<a href="<?=base_url('client/invoices/payments/make/'.$invoice->id)?>" title="Make a payment">Make a payment</a>
					<?php } ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
