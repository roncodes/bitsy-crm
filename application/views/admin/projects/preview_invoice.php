<div id="invoice">
	<div class="invoice-label">INVOICE #01</div>
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
		<div class="span6">...</div>
		<div class="span6">
			<table class="table table-bordered">
				<tbody>
					<tr>
						<td>Invoice #</td>
						<td>01</td>
					</tr>
					<tr>
						<td>Date</td>
						<td><?=date('F j, Y, g:i a')?></td>
					</tr>
					<tr>
						<td>Amount Due</td>
						<td>$300</td>
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
			<tr>
				<td>...</td>
				<td>...</td>
				<td>...</td>
				<td>...</td>
				<td>...</td>
			</tr>
			<tr>
				<td colspan="3"></td>
				<td>Subtotal</td>
				<td>$300</td>
			</tr>
			<tr>
				<td colspan="3"></td>
				<td>Total</td>
				<td>$300</td>
			</tr>
			<tr>
				<td colspan="3"></td>
				<td>Amount Paid</td>
				<td>$300</td>
			</tr>
			<tr>
				<td colspan="3"></td>
				<td>Balance Due</td>
				<td>$300</td>
			</tr>
		</tbody>
	</table>
	<div class="invoice-terms">TERMS</div>
	<p style="text-align:center;"><?=$settings['invoice_terms']?></p>
</div>
