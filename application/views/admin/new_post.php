<div class="welcome">
	<div class="row-fluid fluff">
		<?php if($new_post_success){ ?>
		<div class="alert alert-success" style="width:600px;">New post created</div>
		<?php } ?>
		<div class="span9">
			<div class="page-header">
				<h1>New Post <small>Create a new blog post</small></h1>
			</div>
			<?php echo form_open($this->uri->uri_string(), array('class'=>'form-horizontal')); ?>
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="post_title">Post Title</label>
						<div class="controls">
							<input type="text" class="input-xlarge" name="post_title" id="post_title" style="width:500px;">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="post_category">Post Category</label>
						<div class="controls">
							<select name="post_category">
								<?php foreach($categories as $category){ ?>
								<option value="<?php echo $category->id; ?>"><?php echo $category->cat_title; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="post_content">Post Content</label>
						<div class="controls">
							<textarea class="input-xlarge" name="post_content" id="post_content" rows="3" style="width:500px;height:250px;"></textarea>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button type="submit" name="new_post" class="btn btn-primary">Make new post</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>