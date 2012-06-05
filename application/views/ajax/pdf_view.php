<div style="position:relative;border:1px #000 solid;background:#fff;padding:20px;overflow:auto;width:700px;margin:1px;">
	<div style="background:#000;padding:5px;text-align:center;color:#fff;margin-bottom:10px;">INVOICE #<?=$invoice->invoice_id?></div>
	<div style="width:700px;">
		<div style="float:left;width:350px;">
			<div class="invoice-client">
				<strong><?=$invoice->client->company?></strong><br>
				<?=$invoice->client->address?><br>
				<abbr title="Phone">P:</abbr> <?=$invoice->client->phone?><br><br>
				<strong><?=$invoice->client->first_name?> <?=$invoice->client->last_name?></strong><br>
				<a href="mailto:<?=$invoice->client->email?>"><?=$invoice->client->email?></a><br>
			</div>
		</div>
		<div style="float:left;width:350px;">
			<center><img src="<?=base_url($settings['company_logo'])?>"></center>
		</div>
	</div>
	<div style="width: 700px;clear: both !important;display: inline-block;height:10px;"></div>
	<table>
		<tr>
			<td width="270">
				<table cellspacing="0" style="border-color:#ccc;" cellpadding="5" width="100%">
					<tbody>
						<tr valign="top">
							<td colspan="3" valign="top"><?=$invoice->invoice_description?></td>
						</tr>
				  </tbody>
				</table>
			</td>
			<td width="250">
				<table border="1" cellspacing="0" style="border-color:#ccc;" cellpadding="5" width="100%">
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
			</td>
		</tr>
	</table>
	<div style="width: 700px;clear: both !important;display: inline-block;height:10px;"></div>
	<table border="1" cellspacing="0" style="border-color:#ccc;position:relative;" cellpadding="5" width="100%">
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
	<div style="width: 700px;clear: both !important;display: inline-block;height:10px;"></div>
	<div style="background:#000;padding:5px;text-align:center;color:#fff;margin-bottom:10px;">TERMS</div>
	<p style="text-align:center;"><?=$settings['invoice_terms']?></p>
</div>