<div id="invoice">
	<div class="invoice-label">INVOICE #<?=$invoice_preview['id']?></div>
	<div class="row-fluid">
		<div class="span7">
			<div class="invoice-client">
				<address>
					<strong><?=$client->company?></strong><br>
					<?=$client->address?>
					<abbr title="Phone">P:</abbr> <?=$client->phone?>
				</address>
				<address>
					<strong><?=$client->first_name?> <?=$client->last_name?></strong><br>
					<a href="mailto:<?=$client->email?>"><?=$client->email?></a>
				</address>
			</div>
		</div>
		<div class="span5">
			<center><img src="<?=base_url($settings['company_logo'])?>"></center>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span5"><?=$invoice_preview['description']?></div>
		<div class="span7">
			<table class="table table-bordered">
				<tbody>
					<tr>
						<td>Invoice #</td>
						<td><?=$invoice_preview['id']?></td>
					</tr>
					<tr>
						<td>Date</td>
						<td><?php if(strlen($invoice_preview['date'])>1){ $d = new DateTime(date_flip_set(str_replace('/', '-', $invoice_preview['date']))); echo $d->format('F j, Y, g:i a'); } else { echo date('F j, Y, g:i a'); } ?></td>
					</tr>
					<tr>
						<td>Amount Due</td>
						<td><?=_money_format($total['total']-$invoice_preview['amount_paid'])?></td>
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
			<?php setlocale(LC_MONETARY, 'en_US'); ?>
			<?php for($i=0;$i<$items['count'];$i++){ ?>
			<tr>
				<td><?=$items['name'][$i]?></td>
				<td><?=$items['description'][$i]?></td>
				<td><?=_money_format($items['unit_cost'][$i])?></td>
				<td><?=$items['quanity'][$i]?></td>
				<td><?=_money_format($items['unit_cost'][$i]*$items['quanity'][$i])?></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="3"></td>
				<td>Subtotal</td>
				<td><?=_money_format($subtotal)?></td>
			</tr>
			<tr>
				<td colspan="3"></td>
				<td>Tax</td>
				<td><?=_money_format($total['tax'])?></td>
			</tr>
			<tr>
				<td colspan="3"></td>
				<td>Total</td>
				<td><?=_money_format($total['total'])?></td>
			</tr>
			<tr>
				<td colspan="3"></td>
				<td>Amount Paid</td>
				<td><?=_money_format($invoice_preview['amount_paid'])?></td>
			</tr>
			<tr>
				<td colspan="3"></td>
				<td>Balance Due</td>
				<td><?=_money_format($total['total']-$invoice_preview['amount_paid'])?></td>
			</tr>
		</tbody>
	</table>
	<div class="invoice-terms">TERMS</div>
	<p style="text-align:center;"><?=$settings['invoice_terms']?></p>
</div>
