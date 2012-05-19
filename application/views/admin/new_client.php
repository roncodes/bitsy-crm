<div class="panel">
	<div class="row-fluid fluff">
		<?php if($new_client_success){ ?>
		<div class="alert alert-success" style="width:600px;"><a href="<?php echo $new_page_link; ?>">New client created</a></div>
		<?php } ?>
		<div class="span9">
			<div class="page-header">
				<h1>Add New Client <small>Create a new client</small></h1>
			</div>
			<?php echo form_open($this->uri->uri_string(), array('class'=>'form-horizontal')); ?>
				<fieldset>
					<div class="control-group <?php if(form_error('username')){ echo "error"; } ?>">
						<label class="control-label" for="username">Username</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="username" name="username">
							<?php echo form_error('username', '<p class="help-inline">', '</p>'); ?>
						</div>
					</div>
					<div class="control-group <?php if(form_error('name')){ echo "error"; } ?>">
						<label class="control-label" for="username">Name</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="name" name="name">
							<?php echo form_error('name', '<p class="help-inline">', '</p>'); ?>
						</div>
					</div>
					<div class="control-group <?php if(form_error('email')){ echo "error"; } ?>">
						<label class="control-label" for="email">Email Address</label>
						<div class="controls">
							<input type="text" class="input-xlarge" id="email" name="email">
							<?php echo form_error('email', '<p class="help-inline">', '</p>'); ?>
						</div>
					</div>
					<div class="control-group <?php if(form_error('password')){ echo "error"; } ?>">
						<label class="control-label" for="password">Password</label>
						<div class="controls">
							<input type="password" class="input-xlarge" id="password" name="password">
							<?php echo form_error('password', '<p class="help-inline">', '</p>'); ?>
						</div>
					</div>
					<div class="control-group <?php if(form_error('confirm_password')){ echo "error"; } ?>">
						<label class="control-label" for="confirm_password">Confirm Password</label>
						<div class="controls">
							<input type="password" class="input-xlarge" id="confirm_password" name="confirm_password">
							<?php echo form_error('confirm_password', '<p class="help-inline">', '</p>'); ?>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button type="submit" name="new_client" class="btn btn-primary">Make new Client</button>
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