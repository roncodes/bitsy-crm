<div class="welcome">
	<div class="row-fluid fluff">
		<?php if($edit_post_success){ ?>
		<div class="alert alert-success" style="width:600px;">Post has been updated</div>
		<?php } ?>
		<div class="span9">
			<div class="page-header">
				<h1>Edit Post <small>Modify and make changes to a post</small></h1>
			</div>
			<?php echo form_open($this->uri->uri_string(), array('class'=>'form-horizontal')); ?>
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="post_title">Post Title</label>
						<div class="controls">
							<input type="text" class="input-xlarge" name="post_title" value="<?php echo $post->post_title; ?>" id="post_title" style="width:500px;">
							<input type="hidden" class="input-xlarge" name="post_id" value="<?php echo $post_id; ?>" id="post_id" style="width:500px;">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="post_category">Post Category</label>
						<div class="controls">
							<select name="post_category">
								<option><?php echo $post->post_category_title; ?></option>
								<?php foreach($categories as $category){ ?>
								<option value="<?php echo $category->id; ?>"><?php echo $category->cat_title; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="post_content">Post Content</label>
						<div class="controls">
							<textarea class="input-xlarge" name="post_content" id="post_content" rows="3" style="width:500px;height:250px;"><?php echo $post->post_content; ?></textarea>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button type="submit" name="edit_post" class="btn btn-primary">Update post</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>