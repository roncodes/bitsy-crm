<div class="admin-panel">
<div class="page-header">
	<h1>Close Invoice</h1>
</div>
<p>Are you sure you want to close this invoice 'INVOICE #<?=$invoice->invoice_id?>'?</p>
<?=form_open(current_url())?>
	<div class="control-group">
		<div class="controls">
			<label class="radio"><input type="radio" name="confirm" value="yes" checked="checked"> Yes</label>
			<label class="radio"><input type="radio" name="confirm" value="no"> No</label>
		</div>
	</div>
	<?=form_hidden(array('id' => $invoice->id))?>
	<div class="controls">
		<?=form_submit('close_invoice', 'Submit', 'class="btn btn-danger"')?>
		<a href="<?=base_url('admin/invoices')?>" class="btn">Cancel</a>
	</div>
<?=form_close()?>
</div>