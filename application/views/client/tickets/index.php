<div class="panel">
	<div class="page-header">
		<h1>Tickets</h1>
	</div>
	<div class="row-fluid">
		<div class="span5">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Subject</th>
						<th>Date Opened</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($tickets as $ticket): ?>
					<tr>
						<td><?=$ticket->subject?></td>
						<td><?=date("F j, Y", strtotime($ticket->date_opened))?></td>
						<td><?=$ticket->status?></td>
						<td>
							<a href="<?=base_url('client/tickets/view/'.$ticket->id)?>" rel="tooltip" title="View this ticket"><i class="icon-eye-open"></i></a>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="span6 section-panel">
			<div class="page-header">
				<h3>Compose New Ticket</h3>
			</div>
			<?=form_open(current_url(), 'class="form-horizontal"')?>
				<?=bootstrap_input('subject', 'Ticket Subject')?>
				<?=bootstrap_textarea('issue', 'Issue Description')?>
				<?=bootstrap_dropdown('project', 'Project', $projects)?>
				<div class="controls">
					<?=form_submit('new_ticket', 'Submit Ticket', 'class="btn btn-primary"')?>
				</div>
			<?=form_close()?>
		</div>
	</div>
</div>
