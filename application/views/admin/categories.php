<div class="welcome">
	<div class="row-fluid fluff">
		<div class="page-header" style="width:95%;">
			<h1>Categories <small>Add a new category, or manage categories</small></h1>
		</div>
		<div class="span4">
			<?php echo form_open($this->uri->uri_string(), array('class'=>'form-horizontal')); ?>
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="cat_title">Category Title</label>
						<div class="controls">
							<input type="text" class="input-xlarge" name="cat_title" id="cat_title" style="width:200px;">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="cat_parent">Parent Category</label>
						<div class="controls">
							<select name="cat_parent">
								<option value="">None</option>
								<?php foreach($categories as $category){ ?>
								<option value="<?php echo $category->id; ?>"><?php echo $category->cat_title; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button type="submit" name="new_cat" class="btn btn-primary">Make new category</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
		<div class="span7">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Category Title</th>
						<th>Category Parent</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($categories as $category){ ?>
					<tr>
						<td><?php echo $category->cat_title; ?></td>
						<td><?php echo $category->parent_title; ?></td>
						<td><a href="<?php $this->uri->uri_string(); ?>?delete_cat&cat_id=<?php echo $category->id; ?>">Delete</a></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>