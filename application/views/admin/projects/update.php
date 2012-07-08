<div class="admin-panel">
<div class="row-fluid">
	<div class="span5">
		<div class="page-header">
			<h3>Project Updates</h3>
		</div>
		<?php foreach ($updates as $update): ?>
			<div class="alert alert-info">
				<div style="float:left;margin-right:10px;"><h1>#<?=$update->id?></h1></div>
				<h4 class="alert-heading"><?=$update->title?></h4>
				<?=$update->description?>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="span7">
		<div class="page-header">
			<a href="<?=base_url('admin/projects')?>" class="btn pull-right">Back to Projects</a>
			<h3>New Update</h3>
		</div>
		<?=form_open(current_url(), 'class="form-horizontal"')?>
			<?=bootstrap_input('title', 'Update Title')?>
			<?=bootstrap_input('description', 'Update Description')?>
			<div class="controls">
				<?=form_submit('new_update', 'Create Update', 'class="btn btn-primary"')?>
			</div>
		<?=form_close()?>
	</div>
</div>