<div class="panel">
<a class="btn pull-right" href="<?=base_url('client/invoices')?>">Back</a>
<div id="invoice-view">
	<div class="invoice-label">INVOICE #<?=$invoice->invoice_id?></div>
	<div class="row-fluid">
		<div class="span7">
			<div class="invoice-client">
				<address>
					<strong><?=$invoice->client->company?></strong><br>
					<?=$invoice->client->address?>
					<abbr title="Phone">P:</abbr> <?=$invoice->client->phone?>
				</address>
				<address>
					<strong><?=$invoice->client->first_name?> <?=$invoice->client->last_name?></strong><br>
					<a href="mailto:<?=$invoice->client->email?>"><?=$invoice->client->email?></a>
				</address>
			</div>
		</div>
		<div class="span5">
			<center><img src="<?=base_url($settings['company_logo'])?>"></center>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6"><?=$invoice->invoice_description?></div>
		<div class="span6">
			<table class="table table-bordered">
				<tbody>
					<tr>
						<td>Invoice #</td>
						<td><?=$invoice->invoice_id?></td>
					</tr>
					<tr>
						<td>Date</td>
						<td><?=date('F j, Y, g:i a', strtotime($invoice->date))?></td>
					</tr>
					<tr>
						<td>Amount Due</td>
						<td><?=_money_format(($invoice->subtotal+$invoice->tax)-$invoice->amount_paid)?></td>
					</tr>
			  </tbody>
			</table>
		</div>
	</div>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Item</th>
				<th>Description</th>
				<th>Unit Cost</th>
				<th>Quanity</th>
				<th>Price Total</th>
			</tr>
		</thead>
		<tbody>
			<?php for($i=0;$i<$invoice->items->count;$i++){ ?>
			<tr>
				<td><?=$invoice->items->name[$i]?></td>
				<td><?=$invoice->items->description[$i]?></td>
				<td><?=_money_format($invoice->items->unit_cost[$i])?></td>
				<td><?=$invoice->items->quanity[$i]?></td>
				<td><?=_money_format($invoice->items->unit_cost[$i]*$invoice->items->quanity[$i])?></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="3"></td>
				<td>Subtotal</td>
				<td><?=_money_format($invoice->subtotal)?></td>
			</tr>
			<tr>
				<td colspan="3"></td>
				<td>Tax</td>
				<td><?=_money_format($invoice->tax)?></td>
			</tr>
			<tr>
				<td colspan="3"></td>
				<td>Total</td>
				<td><?=_money_format($invoice->subtotal+$invoice->tax)?></td>
			</tr>
			<tr>
				<td colspan="3"></td>
				<td>Amount Paid</td>
				<td><?=_money_format($invoice->amount_paid)?></td>
			</tr>
			<tr>
				<td colspan="3"></td>
				<td>Balance Due</td>
				<td><?=_money_format(($invoice->subtotal+$invoice->tax)-$invoice->amount_paid)?></td>
			</tr>
		</tbody>
	</table>
	<div class="invoice-terms">TERMS</div>
	<p style="text-align:center;"><?=$settings['invoice_terms']?></p>
</div>

</div>