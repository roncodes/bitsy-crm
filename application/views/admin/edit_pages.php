<?php 
$pagi_start = 0;
if(!$page_start||$page_start=='edit_pages'){
	$page_start = 0;
}
?>
<div class="welcome">
	<div class="row-fluid fluff">
		<div class="span11">
			<div class="page-header">
				<h1>Edit Pages <small>Manage your pages</small></h1>
				<div style="float:right;margin-top:-30px;">
					Search Pages: <input type="text" class="input-xlarge" name="search" id="search">
					<table id="results_table" class="table table-striped table-bordered table-condensed" style="width:300px;display:none;z-index:999999;position:absolute;margin-left:70px;">
						<tbody id="results">
							
						</tbody>
					</table>
				</div>
			</div>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>Page Title</th>
						<th>Page URI</th>
						<th>Page Parent</th>
						<th>Page Template</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php for($i=$page_start;$i<($page_start+$per_page);$i++){ //echo $i; } ?>
					<?php 
						if($i<count($pages)){
							$page = $pages[$i]; 
						?>
					<tr>
						<td><?php echo $page->id; ?></td>
						<td><?php echo $page->page_title; ?></td>
						<td><a href="<?php echo base_url().$page->page_full_uri; ?>"><?php echo $page->page_uri; ?></a></td>
						<td><?php echo $page->page_parent_title; ?></td>
						<td><?php echo $page->page_template; ?></td>
						<td><a href="<?php $this->uri->uri_string(); ?>?delete_page&page_id=<?php echo $page->id; ?>">Delete</a> | <a href="<?=base_url()?>admin/pages/edit_page/<?php echo $page->id; ?>">Edit</a></td>
					</tr>
					<?php }} ?>
				</tbody>
			</table>
			<div class="pagination">
				<ul>
					<?php for($i=0;$i<$num_of_pages;$i++){ ?>
						<?php if($i<20){ ?>
						<li <?php if($page_start==($i*$per_page)){ ?>class="active"<?php } ?>><a href="<?php echo base_url().'admin/edit_pages/'.($i*$per_page); ?>"><?php echo $i+1; ?></a></li>
						<?php } ?>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	/* Live search by Ronald A. Richardson */
	$('#search').keyup(function() {
		$('#results_table').slideDown();
		if($(this).val()!=''){
			$.post('?search_pages&q='+$(this).val(), function(data){
				$('#results').html(data);
			});
		} else {
			$('#results_table').slideUp();
		}
	});
});
var go_to = function(parent) {
	id = parent.innerHTML.split('<td>');
	id = id[2].split('<');
	id = id[0];
	window.location = '<?=base_url()?>admin/pages/edit_page/'+id;
}
</script>