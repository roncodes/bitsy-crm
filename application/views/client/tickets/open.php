<div class="panel">
<div class="page-header">
	<h1>Re-Open Ticket</h1>
</div>
<p>Are you sure you want to re-open this ticket 'TICKET #<?=$ticket->code?>'?</p>
<?=form_open(current_url())?>
	<div class="control-group">
		<div class="controls">
			<label class="radio"><input type="radio" name="confirm" value="yes" checked="checked"> Yes</label>
			<label class="radio"><input type="radio" name="confirm" value="no"> No</label>
		</div>
	</div>
	<?=form_hidden(array('id' => $ticket->id))?>
	<div class="controls">
		<?=form_submit('open_ticket', 'Submit', 'class="btn btn-success"')?>
		<a href="<?=base_url('client/tickets')?>" class="btn">Cancel</a>
	</div>
<?=form_close()?>
</div>