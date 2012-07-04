<div class="panel">
	<div class="page-header">
		<a href="<?=base_url('client/invoices')?>" class="btn pull-right">Back</a>
		<h1>Make a Payment</h1>
	</div>
	<?php if(isset($_POST['submit'])){ ?>
		<?php if($_POST['gateway']=='paypal'){ ?>
			<p>You are about to make a payment for <?=$_POST['amount']?> using Paypal</p>
			<?=$paypal_form?> 
		<?php } else if($_POST['gateway']=='stripe'){ ?>
			<?php if(isset($stripe_form)){ ?>
				<p>You are about to make a payment for <?=$_POST['amount']?> using Stripe</p>
				<?=form_open(current_url(), 'class="form-horizontal"')?>
					<?=bootstrap_input('number', 'Credit Card Number')?>
					<?=bootstrap_input('exp_month', 'Expiration Month')?>
					<?=bootstrap_input('exp_year', 'Expiration Year')?>
					<?=bootstrap_input('cvc', 'CVC Code')?>
					<?=bootstrap_hidden('submit', 'submit', 'submit')?>
					<?=bootstrap_hidden('amount', 'amount', $_POST['amount'])?>
					<?=bootstrap_hidden('gateway', 'gateway', 'stripe')?>
					<div class="controls">
						<?=form_submit('stripe_charge', 'Confirm & Pay', 'class="btn btn-success"'); ?>
						<a href="<?=base_url('client/invoices')?>" class="btn">Cancel</a>
					</div>
				<?=form_close()?>
			<?php } ?>
		<?php } ?>
	<?php } else { ?>
	<div class="row-fluid">
		<div class="span5">
		<h3>Balance Due: <?=_money_format(($invoice->subtotal+$invoice->tax)-$invoice->amount_paid)?></h3>
		<p>The total balance due on this invoice is <?=_money_format(($invoice->subtotal+$invoice->tax)-$invoice->amount_paid)?>, you can choose to pay the total amount due or make a partial payment.</p>
		<?=form_open(current_url(), 'class="form-horizontal"')?>
			<?=bootstrap_input('amount', 'Enter payment amount', _money_format(($invoice->subtotal+$invoice->tax)-$invoice->amount_paid))?>
			<div class="control-group">
            <label class="control-label">Select payment method</label>
				<div class="controls">
				<?php foreach($gateways as $gateway){ ?>
				  <label class="radio">
					<input type="radio" name="gateway" id="<?=$gateway->name?>" value="<?=$gateway->name?>">
					<?=ucfirst($gateway->name)?>
				  </label>
				<?php } ?>
				</div>
			</div>
			<div class="controls">
				<?=form_submit('submit', 'Make Payment', 'class="btn btn-primary"'); ?>
				<a href="<?=base_url('client/invoices')?>" class="btn">Cancel</a>
			</div>
		<?=form_close()?>
		</div>
		<div class="span7">
			<div id="invoice-view-pay">
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
	</div>
	<?php } ?>
</div>