<div class="panel">
<div class="page-header">
	<h1>Close Ticket</h1>
</div>
<p>Are you sure you want to close this ticket 'TICKET #<?=$ticket->code?>'?</p>
<?=form_open(current_url())?>
	<div class="control-group">
		<div class="controls">
			<label class="radio"><input type="radio" name="confirm" value="yes" checked="checked"> Yes</label>
			<label class="radio"><input type="radio" name="confirm" value="no"> No</label>
		</div>
	</div>
	<?=form_hidden(array('id' => $ticket->id))?>
	<div class="controls">
		<?=form_submit('close_ticket', 'Submit', 'class="btn btn-danger"')?>
		<a href="<?=base_url('client/tickets')?>" class="btn">Cancel</a>
	</div>
<?=form_close()?>
</div>