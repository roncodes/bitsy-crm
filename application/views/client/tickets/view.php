<?=date_default_timezone_set($user->timezone)?>
<div class="panel">
	<div class="page-header">
		<a href=".." class="btn pull-right">Back</a>
		<?php if($ticket->status=='Open'){ ?>
		<a href="../close/<?=$ticket->id?>" class="btn btn-danger pull-right" style="margin-right:6px;">Close Ticket</a>
		<?php } else { ?>
		<a href="../open/<?=$ticket->id?>" class="btn btn-primary pull-right" style="margin-right:6px;">Re-Open Ticket</a>
		<?php } ?>
		<h1>Viewing Ticket #<?=$ticket->code?></h1>
	</div>
	<div class="alert alert-info" style="min-height:100px;border:1px #3b7ca2 solid;">
	<h2 class="alert-heading"><?=$ticket->subject?> <small>posted on <?=date("F j, Y, g:i a", strtotime($ticket->date_opened))?></h2>
	<?=$ticket->issue?>
	</div>
	<hr>
	<?php 
		$count = 0;
		foreach($replies as $reply){ ?>
	<div class="alert alert-<?php if($count++ % 2 == 1 ){ ?>success<?php } else { ?>warning<?php } ?>" style="min-height:100px;">
	<h2 class="alert-heading"><?=$reply->subject?></h2>
	<?=$reply->issue?> (<?=time_ago(strtotime($reply->date_opened))?> ago)
	</div>
	<?php } ?>
	<?=form_open(current_url(), 'class="form-vertical"')?>
        <fieldset>
		<div class="control-group">
			<label class="control-label" for="reply">Reply</label>
			<div class="controls">
				<textarea class="input-xlarge" id="reply" name="reply" style="width:99%;height:140px;"></textarea>
			</div>
		</div>
		<div class="control-group">
			<button type="submit" class="btn btn-primary pull-right">Add Reply</button>
		</div>
        </fieldset>
	</form>
</div>
