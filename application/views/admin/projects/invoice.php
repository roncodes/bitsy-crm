<div class="admin-panel">
<div class="row-fluid">
	<div class="span6">
		<div class="page-header">
			<h3>Invoice Details</h3>
		</div>
		<?=form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'generate_invoice'))?>
			<?=bootstrap_input('id', 'Invoice ID')?>
			<?=bootstrap_input('description', 'Invoice Description')?>
			<div class="items"></div>
			<input type="hidden" name="project_id" value="<?php echo $project->id; ?>">
			<div class="controls">
				<button type="button" onclick="update_preview()" class="btn btn-info">Update Preview</button>
				<button type="button" onclick="add_invoice_item()" class="btn btn-success">Add Item</button>
				<?=form_submit('new_invoice', 'Generate Invoice', 'class="btn btn-primary"')?>
			</div>
		<?=form_close()?>
	</div>
	<div class="span6">
		<div class="page-header">
			<a href="<?=base_url('admin/projects')?>" class="btn pull-right">Back to Projects</a>
			<h3>Preview Invoice</h3>
		</div>
		<div id="invoice-preview"></div>
	</div>
</div>