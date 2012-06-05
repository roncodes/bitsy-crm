$(document).ready(function() {
	$("#inline_debug").fancybox({
		scrolling: 'yes',
		titleShow: false,
		autoDimensions: false,
		width: '75%',
		height: '90%'
	});
	
	$("#inline_profiler").fancybox({
		scrolling: 'yes',
		titleShow: false,
		autoDimensions: false,
		width: '75%',
		height: '90%'
	});
	
	$('a').tooltip();
	
	update_preview();
	update_preview_external();
});

var add_invoice_item = function() {
	count = $(".items label").size();
	item = '<div class="control-group" id="item_'+count+'"><label class="control-label"><strong>Invoice Item #'+count+'</strong><br><a href="javascript:remove_item('+count+');">Remove Item</a></label><div class="controls">';
    item += '<input class="span3 grouped" type="text" name="item_name_'+count+'"><span class="help-inline">Item Name</span><br>';
	item += '<input class="span3 grouped" type="text" name="item_description_'+count+'"><span class="help-inline">Item Description</span>';
	item += '<input class="span3 grouped" type="text" name="item_unit_cost_'+count+'"><span class="help-inline">Unit Cost</span>';
	item += '<input class="span3 grouped" type="text" name="item_quanity_'+count+'"><span class="help-inline">Quanity</span>';
	item += '</div></div>';
	$('.items').append(item);
}

var remove_item = function(id) {
	$('#item_'+id).remove();
}

var get_clients_projects = function() {
	id = $('#client').val();
	$.post('../../ajax/get_clients_projects/'+id, function(data){
		data = jQuery.parseJSON(data);
		for(i=0;i<data.length;i++){
			$('#project_id').append(
				$('<option></option>').val(data[i]['id']).html(data[i]['name'])
			);
		}
		update_preview();
	});
}

var update_preview = function() {
	if(get_segment(2)=='projects'&&get_segment(3)=='invoice'){
		$.post('../../../ajax/preview_invoice', $('#generate_invoice').serialize(), function(data){
			$('#invoice-preview').html(data);
		});
	} else if(get_segment(2)=='invoices'&&get_segment(3)=='edit'){
		$.post('../../../ajax/preview_invoice', $('#generate_invoice').serialize(), function(data){
			$('#invoice-preview').html(data);
		});
	} else if(get_segment(2)=='invoices'&&get_segment(3)=='create'){
		$.post('../../ajax/preview_invoice', $('#generate_invoice').serialize(), function(data){
			$('#invoice-preview').html(data);
		});
	}
}

var get_segment = function(segment) {
	var segments = new Array();
	var count = 0;
	parts = window.location.href.split('/');
	for(i=3;i<parts.length;i++){
		segments[count] = parts[i];
		count++;
	}
	return segments[segment];
}

var update_preview_external = function() {
	
}
