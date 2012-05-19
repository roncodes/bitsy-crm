<div class="welcome">
	<div class="row-fluid fluff">
		<div class="span11">
			<div class="page-header">
				<h1>Edit Posts <small>Manage your post</small></h1>
			</div>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>Post Title</th>
						<th>Post Category</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($posts as $post){ ?>
					<tr>
						<td><?php echo $post->id; ?></td>
						<td><?php echo $post->post_title; ?></td>
						<td><?php echo $post->post_category_title; ?></td>
						<td><a href="<?php $this->uri->uri_string(); ?>?delete_post&post_id=<?php echo $post->id; ?>">Delete</a> | <a href="<?=base_url()?>admin/posts/edit_post/<?php echo $post->id; ?>">Edit</a></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>