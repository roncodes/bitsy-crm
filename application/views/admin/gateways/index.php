<div class="admin-panel">
	<div class="page-header">
		<h1>Payment Gateways</h1>
	</div>
	<ul class="nav nav-tabs" id="gateways">
		<li class="active"><a href="#paypal" data-toggle="tab">Paypal</a></li>
		<li><a href="#stripe" data-toggle="tab">Stripe</a></li>
		<li><a href="#alertpay" data-toggle="tab">Alertpay</a></li>
		<li><a href="#2co" data-toggle="tab">2 Checkout</a></li>
		<li><a href="#authorize" data-toggle="tab">Authorize.NET</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="paypal">
		<?=form_open(current_url(), array('class' => 'form-horizontal'))?>
			<?=bootstrap_input('login', 'Your Paypal Email', &$gateways['paypal']->login)?>
			<?=bootstrap_hidden('gateway', 'gateway', 'Paypal')?>
			<?=bootstrap_checkbox('active', 'Active', 1, &$gateways['paypal']->active)?>
			<div class="controls">
				<?=form_submit('update_gateway', 'Update Paypal Gateway', 'class="btn btn-primary"')?>
			</div>
		<?=form_close()?>
		</div>
		<div class="tab-pane" id="stripe">
		<?=form_open(current_url(), array('class' => 'form-horizontal'))?>
			<?=bootstrap_input('auth1', 'Your Secret Key', &$gateways['stripe']->auth1)?>
			<?=bootstrap_input('auth2', 'Your Publishable Key', &$gateways['stripe']->auth2)?>
			<?=bootstrap_hidden('gateway', 'gateway', 'Stripe')?>
			<?=bootstrap_checkbox('active', 'Active', 1, &$gateways['stripe']->active)?>
			<div class="controls">
				<?=form_submit('update_gateway', 'Update Stripe Gateway', 'class="btn btn-primary"')?>
			</div>
		<?=form_close()?>
		</div>
		<div class="tab-pane" id="alertpay">
			<p>Payment Gateway Coming Soon...</p>
		</div>
		<div class="tab-pane" id="2co">
			<p>Payment Gateway Coming Soon...</p>
		</div>
		<div class="tab-pane" id="authorize">
			<p>Payment Gateway Coming Soon...</p>
		</div>
	</div>
 
<script>
  $(function () {
    $('#gateways a:first').tab('show');
  })
</script>
</div>
