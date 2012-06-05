<div class="admin-panel">
<div class="row-fluid">
	<div class="span6">
		<div class="page-header">
			<h3>Edit Invoice</h3>
		</div>
		<?=form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'generate_invoice'))?>
			<?=bootstrap_input('id', 'Invoice ID', $invoice->invoice_id)?>
			<?=bootstrap_input('description', 'Invoice Description', $invoice->invoice_description)?>
			<?=bootstrap_input('amount_paid', 'Amount Paid', $invoice->amount_paid)?>
			<div class="items">
			<?php for($i=0;$i<$invoice->items->count;$i++){ ?>
			<div class="control-group" id="item_<?=$i?>">
				<label class="control-label">
					<strong>Invoice Item #<?=$i?></strong>
					<br><a href="javascript:remove_item('<?=$i?>');">Remove Item</a>
				</label>
				<div class="controls">
					<input class="span3 grouped" type="text" value="<?=$invoice->items->name[$i]?>" name="item_name_<?=$i?>"><span class="help-inline">Item Name</span><br>
					<input class="span3 grouped" type="text" value="<?=$invoice->items->description[$i]?>" name="item_description_<?=$i?>"><span class="help-inline">Item Description</span>
					<input class="span3 grouped" type="text" value="<?=$invoice->items->unit_cost[$i]?>" name="item_unit_cost_<?=$i?>"><span class="help-inline">Unit Cost</span>
					<input class="span3 grouped" type="text" value="<?=$invoice->items->quanity[$i]?>" name="item_quanity_<?=$i?>"><span class="help-inline">Quanity</span>
				</div>
			</div>
			<?php } ?>
			</div>
			<input type="hidden" name="project_id" value="<?=$invoice->project_id?>">
			<input type="hidden" name="invoice_id" value="<?=$invoice_id?>">
			<div class="controls">
				<button type="button" onclick="update_preview()" class="btn btn-info">Update Preview</button>
				<button type="button" onclick="add_invoice_item()" class="btn btn-success">Add Item</button>
				<?=form_submit('edit_invoice', 'Update Invoice', 'class="btn btn-primary"')?>
			</div>
		<?=form_close()?>
	</div>
	<div class="span6">
		<div class="page-header">
			<a href="<?=base_url('admin/invoices')?>" class="btn pull-right">Back to Invoices</a>
			<h3>Preview Invoice</h3>
		</div>
		<div id="invoice-preview"></div>
	</div>
</div>