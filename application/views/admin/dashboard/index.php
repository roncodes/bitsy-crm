<div class="admin-panel">
<div class="page-header">
	<?=form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'run_cron'))?>
		<?=form_submit('run_cron', 'Run/ Update Cron', 'class="btn btn-info pull-right"')?>
	<?=form_close()?>
	<h1>Dashboard</h1>
</div>
<p class="lead">Welcome to the dashboard of your clients manager.</p>
<h3>Your income this month (<?=date('F')?>): <?=_money_format($monthly_income)?></h3>
</div>