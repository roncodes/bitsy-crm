<div class="admin-panel">
	<div class="row-fluid">
		<div class="span6">
			<div class="page-header">
				<h3>Invoice Details</h3>
			</div>
			<?=form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'generate_invoice'))?>
				<?=bootstrap_dropdown('client', 'Client', $clients, NULL, 'class="span4" onchange="get_clients_projects()"')?>
				<?=bootstrap_dropdown('project_id', 'Project', array())?>
				<?=bootstrap_input('id', 'Invoice ID')?>
				<div class="control-group">
					<label class="control-label" for="recurring">Recurring</label>
					<div class="controls">
					  <label class="checkbox">
						<input type="checkbox" id="recurring" name="recurring" value="1" onclick="recurring_invoice_opts();" <?php if(isset($_POST['recurring'])){ if(intval($_POST['recurring'])){ ?>checked="yes"<?php }} ?>>
						If this is a recurring invoice, check this box for further options
					  </label>
					</div>
				</div>
				<div class="recurring_options" <?php if(isset($_POST['recurring'])){ if(!intval($_POST['recurring'])){ ?>style="display:none;"<?php }} else { ?>style="display:none;"<?php } ?>>
					<div class="control-group <?php if (form_error('recur_length')) echo 'error'; ?>">
					<label class="control-label" for="recurring">Bill every</label>
						<div class="controls">
							<input class="input-mini" type="text" placeholder="30" name="recur_length">
							<select class="span2" name="recur_by">
								<option>Days</option>
								<option>Months</option>
								<option>Years</option>
							</select>
							<?=form_error('recur_length')?>
						</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="custom_date">Custom Date</label>
					<div class="controls">
					  <label class="checkbox">
						<input type="checkbox" id="custom_date" name="custom_date" value="1" onclick="date_invoice_opts();" <?php if(isset($_POST['custom_date'])){ if(intval($_POST['custom_date'])){ ?>checked="yes"<?php }} ?>>
						If this invoice is to be created in the future or if it is a past invoice
					  </label>
					</div>
				</div>
				<div class="date_options" <?php if(isset($_POST['custom_date'])){ if(!intval($_POST['custom_date'])){ ?>style="display:none;"<?php }} else { ?>style="display:none;"<?php } ?>>
					<div class="control-group <?php if (form_error('date')) echo 'error'; ?>">
					<label class="control-label" for="date">Invoice Date</label>
						<div class="controls">
							<input class="input-small" type="text" placeholder="MM/DD/YYYY" name="date">
							<?=form_error('date')?>
						</div>
					</div>
				</div>
				<?=bootstrap_input('description', 'Invoice Description', '...')?>
				<?=bootstrap_input('amount_paid', 'Amount Paid')?>
				<div class="items"></div>
				<div class="controls">
					<button type="button" onclick="update_preview()" class="btn btn-info">Update Preview</button>
					<button type="button" onclick="add_invoice_item()" class="btn btn-success">Add Item</button>
					<?=form_submit('new_invoice', 'Generate Invoice', 'class="btn btn-primary"')?>
				</div>
			<?=form_close()?>
		</div>
		<div class="span6">
			<div class="page-header">
				<a href="<?=base_url('admin/invoices')?>" class="btn pull-right">Back to Invoices</a>
				<h3>Preview Invoice</h3>
			</div>
			<div id="invoice-preview">Select a client to begin...</div>
		</div>
	</div>
</div>