<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function pagination_links($config)
{
	$links = "<ul class='pagination'>";
	for($i=0;$i<ceil($config['total_rows']/$config['per_page']);$i++){
		if($config['row_start']==($i*$config['per_page'])){
			$links .= "<li class='active'>";
		} else {
			$links .= "<li>";
		}
		$links .= "<a href='$config[base_pagination]/".$i*$config['per_page']."'>".($i+1)."</a></li>";
	}
	$links .= "</ul>";
	return $links;
}

function time_ago($tm, $rcs = 0) 
{
	$cur_tm = time(); $dif = $cur_tm-$tm;
	$pds = array('second','minute','hour','day','week','month','year','decade');
	$lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
	for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);
	$no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
	if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
	return $x;
}

function format_money($amount)
{
	return '$'.number_format($amount/100, 2);
}

function dumpVars($array)
{
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

function _money_format($value)
{
	return '$'.number_format(intval($value), 2, '.', '');
}

function flashmsg($string, $flag = 'info') {
	$CI =& get_instance();
	$CI->session->set_userdata('monolog', $string);
	$CI->session->set_userdata('monolog_flag', $flag);
}

function showflashmsg() {
	$CI =& get_instance();
	$monolog = $CI->session->userdata('monolog');
	$monolog_flag = $CI->session->userdata('monolog_flag');
	
	if (empty($monolog)) return;
	
	?>
	<div id="monolog" class="alert alert-<?=$monolog_flag?>">
		<a class="close" data-dismiss="alert" href="#">x</a>
		<?=$monolog?>
	</div>
	<?php
	$monolog = $CI->session->unset_userdata('monolog');
}

function bootstrap_hidden($name, $label = '', $default = NULL, $extra = 'class="span4"')
{
?>
<input id="<?=$name?>" name="<?=$name?>" type="hidden" value="<?=set_value($name, $default)?>" <?=trim($extra)?>>
<?php
}

function bootstrap_input($name, $label = '', $default = NULL, $extra = 'class="span4"')
{
?>
<div class="control-group <?php if (form_error($name)) echo 'error'; ?>">
	<?php if ( ! empty($label)): ?>
	<label class="control-label" for="<?=$name?>"><?=$label?></label>
	<?php endif; ?>
	<div class="controls">
		<input id="<?=$name?>" name="<?=$name?>" type="text" value="<?=set_value($name, $default)?>" <?=trim($extra)?>>
		<?=form_error($name)?>
	</div>
</div>
<?php
}

function bootstrap_checkbox($name, $label = '', $default = NULL, $checked = false, $extra = 'class="span4"')
{
?>
<div class="control-group <?php if (form_error($name)) echo 'error'; ?>">
	<?php if ( ! empty($label)): ?>
	<label class="control-label" for="<?=$name?>"><?=$label?></label>
	<?php endif; ?>
	<div class="controls">
		<input id="<?=$name?>" name="<?=$name?>" type="checkbox" value="<?=set_value($name, $default)?>" <?php if($checked){ echo "checked"; } ?>>
		<?=form_error($name)?>
	</div>
</div>
<?php
}

function bootstrap_input_disabled($name, $label = '', $default = NULL, $extra = 'class="span4"')
{
?>
<div class="control-group <?php if (form_error($name)) echo 'error'; ?>">
	<?php if ( ! empty($label)): ?>
	<label class="control-label" for="<?=$name?>"><?=$label?></label>
	<?php endif; ?>
	<div class="controls">
		<input id="<?=$name?>" name="<?=$name?>" type="text" value="<?=set_value($name, $default)?>" <?=trim($extra)?> disabled>
		<?=form_error($name)?>
	</div>
</div>
<?php
}

function bootstrap_textarea($name, $label = '', $default = NULL, $extra = 'class="span4"')
{
?>
<div class="control-group <?php if (form_error($name)) echo 'error'; ?>">
	<?php if ( ! empty($label)): ?>
	<label class="control-label" for="<?=$name?>"><?=$label?></label>
	<?php endif; ?>
	<div class="controls">
		<textarea <?=trim($extra)?> id="<?=$name?>" name="<?=$name?>" type="text" rows="3"><?=set_value($name, $default)?></textarea>
		<?=form_error($name)?>
	</div>
</div>
<?php
}

function bootstrap_password($name, $label = '', $default = NULL, $extra = 'class="span4"')
{
?>
<div class="control-group <?php if (form_error($name)) echo 'error'; ?>">
	<?php if ( ! empty($label)): ?>
	<label class="control-label" for="<?=$name?>"><?=$label?></label>
	<?php endif; ?>
	<div class="controls">
		<input id="<?=$name?>" name="<?=$name?>" type="password" value="<?=set_value($name, $default)?>" <?=trim($extra)?>>
		<?=form_error($name)?>
	</div>
</div>
<?php
}

function bootstrap_dropdown($name, $label = '', $options, $default = NULL, $extra = 'class="span4"')
{
?>
<div class="control-group <?php if (form_error($name)) echo 'error'; ?>">
	<?php if ( ! empty($label)): ?>
	<label class="control-label" for="<?=$name?>"><?=$label?></label>
	<?php endif; ?>
	<div class="controls">
		<?=form_dropdown($name, $options, set_value($name, $default), 'id="'.$name.'" '.trim($extra))?>
		<?php if ( ! empty($help_block)): ?>
		<p class="help-block"><?=$help_block?></p>
		<?php endif; ?>
		<?=form_error($name)?>
	</div>
</div>
<?php
}