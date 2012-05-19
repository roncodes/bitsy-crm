<div class="welcome">
	<div class="row-fluid fluff">
		<div class="page-header" style="width:95%;">
			<h1>Templates <small>Manage page templates</small></h1>
		</div>
		<div class="span10">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Template</th>
						<th>Template Location</th>
						<th>Template Name</th>
						<th>Template Author</th>
						<th>Template Version</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($templates as $template){ ?>
					<tr>
						<td><?php echo $template['title']; ?></td>
						<td><?php echo $template['url']; ?></td>
						<td><?php echo $template['data'][0]; ?></td>
						<td><?php echo $template['data'][1]; ?></td>
						<td><?php echo $template['data'][2]; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>