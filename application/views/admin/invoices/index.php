<div class="admin-panel">
<div class="page-header">
	<a href="<?=base_url('admin/invoices/create')?>" class="btn btn-primary pull-right">New Invoice</a>
	<h1>All Invoices</h1>
</div>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Invoice ID</th>
				<th>Client</th>
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
				<td><?=$invoice->client->first_name.' '.$invoice->client->last_name?></td>
				<td><?=$invoice->project->name?></td>
				<td><?=_money_format($invoice->amount_paid)?></td>
				<td><?=_money_format($invoice->amount_due)?></td>
				<td><?=$invoice->status?></td>
				<td>
					<a href="<?=base_url('admin/invoices/view/'.$invoice->id)?>" rel="tooltip" title="View this invoice"><i class="icon-eye-open"></i></a>
					<a href="<?=base_url('admin/invoices/download/'.$invoice->id)?>" rel="tooltip" title="Download this invoice as PDF"><i class="icon-download"></i></a>
					<a href="<?=base_url('admin/invoices/edit/'.$invoice->id)?>" rel="tooltip" title="Edit invoice"><i class="icon-pencil"></i></a>
					<?php if($invoice->status!='Closed'){ ?>
					<a href="<?=base_url('admin/invoices/close/'.$invoice->id)?>" rel="tooltip" title="Close this invoice"><i class="icon-ban-circle"></i></a>
					<?php } else { ?>
					<a href="<?=base_url('admin/invoices/open/'.$invoice->id)?>" rel="tooltip" title="Open this invoice"><i class="icon-ok-circle"></i></a>
					<?php } ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
