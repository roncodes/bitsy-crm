<div class="welcome">
	<div class="row-fluid fluff">
		<?php if($new_page_success){ ?>
		<div class="alert alert-success" style="width:600px;"><a href="<?php echo $new_page_link; ?>">New page created</a></div>
		<?php } ?>
		<div class="span9">
			<div class="page-header">
				<h1>New Page <small>Create a new page</small></h1>
			</div>
			<?php echo form_open($this->uri->uri_string(), array('class'=>'form-horizontal')); ?>
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="page_title">Page Title</label>
						<div class="controls">
							<input type="text" class="input-xlarge" name="page_title" id="page_title" style="width:700px;">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="page_templates">Page Template</label>
						<div class="controls">
							<select name="page_template" style="width:700px;">
								<?php foreach($templates as $template){ ?>
								<option value="<?php echo $template['title']; ?>"><?php echo $template['title']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="page_parent">Page Parent</label>
						<div class="controls">
							<input type="text" class="input-xlarge" name="page_parent" id="page_parent" style="width:700px;">
							<table id="parent_results_table" class="table table-striped table-bordered table-condensed" style="width:700px;display:none;">
								<tbody id="parent_results">
									
								</tbody>
							</table>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="page_content">Page Content</label>
						<div class="controls">
							<textarea name="page_content" id="page_content"></textarea>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button type="submit" name="new_page" class="btn btn-primary">Make new Page</button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
<!--
$(document).ready(function()	{
	// Add markItUp! to your textarea in one line
	// $('textarea').markItUp( { Settings }, { OptionalExtraSettings } );
	$('#page_content').markItUp(mySettings);
	
	// You can add content from anywhere in your page
	// $.markItUp( { Settings } );	
	$('.add').click(function() {
 		$.markItUp( { 	openWith:'<opening tag>',
						closeWith:'<\/closing tag>',
						placeHolder:"New content"
					}
				);
 		return false;
	});
	
	// And you can add/remove markItUp! whenever you want
	// $(textarea).markItUpRemove();
	$('.toggle').click(function() {
		if ($("#markItUp.markItUpEditor").length === 1) {
 			$("#markItUp").markItUpRemove();
			$("span", this).text("get markItUp! back");
		} else {
			$('#markItUp').markItUp(mySettings);
			$("span", this).text("remove markItUp!");
		}
 		return false;
	});
	
	/* Live search by Ronald A. Richardson */
	$('#page_parent').keyup(function() {
		$('#parent_results_table').slideDown();
		if($(this).val()!=''){
			$.post('?search_parents&q='+$(this).val(), function(data){
				$('#parent_results').html(data);
			});
		} else {
			$('#parent_results_table').slideUp();
		}
	});
	
});
-->
var page_parent = function(parent) {
	id = parent.innerHTML.split('<td>');
	id = id[2].split('<');
	id = id[0];
	$('#page_parent').val(id);
	$('#parent_results_table').slideUp();
}
</script>