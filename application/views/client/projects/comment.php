<div class="panel">
<div class="row-fluid">
	<div class="span5">
		<div class="page-header">
			<h3>Project Comments</h3>
		</div>
		<?php foreach ($updates as $update): ?>
			<div class="alert alert-<?php if(strstr($update->title, "Comment by Client:")){ ?>success<?php } else { ?>info<?php } ?>">
				<div style="float:left;margin-right:10px;"><h1>#<?=$update->id?></h1></div>
				<h4 class="alert-heading"><?=$update->title?></h4>
				<?=$update->description?>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="span7">
		<div class="page-header">
			<a href="<?=base_url('client/projects')?>" class="btn pull-right">Back to Projects</a>
			<h3>Compose New Comment</h3>
		</div>
		<?=form_open(current_url(), 'class="form-horizontal"')?>
			<?=bootstrap_input('title', 'Comment Title')?>
			<?=bootstrap_input('description', 'Comment Description')?>
			<div class="controls">
				<?=form_submit('new_update', 'Submit Comment', 'class="btn btn-primary"')?>
			</div>
		<?=form_close()?>
	</div>
</div>