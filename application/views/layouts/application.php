<!DOCTYPE HTML> 
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="http://www.facebook.com/2008/fbml"> 
<head>
	<meta charset="utf-8"> 
	<title><?=$meta_title?></title> 
	<meta name="description" content="<?=$meta_desc?>"> 
	<meta name="keywords" content="<?=$meta_keywords?>"> 
	
	<link href="<?=base_url('public/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet" media="all">
	<link href="<?=base_url('public/c/fancybox.css')?>" rel="stylesheet" media="all">
	<link href="<?=base_url('public/c/main.css')?>" rel="stylesheet" media="all">
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="<?=base_url('public/bootstrap/js/bootstrap.min.js')?>"></script>
	<script src="<?=base_url('public/j/main.js')?>"></script>
	<?php if (is_admin()): ?>
	<script src="<?=base_url('public/j/jquery.fancybox-1.3.1.pack.js')?>"></script>
	<script src="<?=base_url('public/j/admin.js')?>"></script>
	<?php endif; ?>
	
	<!--[if IE]>
	  	<script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]--> 
</head>
<body>
	<?php if (is_admin()): ?>
	<div style="display: none;">
		<div id="codeigniter_debug" style="width: 100%;">
			<?php
			$vars = get_defined_vars();
			$filtered_vars = array_diff_key($vars['_ci_CI']->load->_ci_cached_vars, array_flip(array('yield')));
			dumpVars($filtered_vars);
			?>
		</div>
	</div>
	<?php endif; ?>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="<?=base_url()?>"><?=$settings['site_name']?></a>
				<div class="nav-collapse">
					<ul class="nav">
						
					</ul>
					<ul class="nav pull-right">
					<?php if (logged_in()): ?>
						<?php if (is_admin()): ?>
						<li><a href="<?=base_url('admin')?>">Admin</a></li>
						<li><a id="inline_debug" href="#codeigniter_debug">Debug Vars</a></li>
						<li><a id="inline_profiler" href="#codeigniter_profiler">Profiler</a></li>
						<?php endif; ?>
						<li><a href="<?=base_url('auth/logout')?>">Logout</a></li>
					<?php else: ?>
						<li><a href="<?=base_url('auth/login')?>">Login</a></li>
						<li><a href="<?=base_url('auth/register')?>">Register</a></li>
					<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="container" style="margin-top: 60px;">
		<?php 
		if ( ! empty($folder_name))
		{
			if (file_exists(APPPATH.'views/'.$folder_name.'subnav.php'))
			{
				echo '<div class="subnav"><ul class="nav nav-pills">';
				$this->load->view($folder_name.'subnav.php', true);
				echo '</ul></div>';
			}
		}
		?>
		<?php echo showflashmsg(); ?>
		<?php echo $yield; ?>
	</div>
	<div class="container">
		<footer class="footer">
			<p class="pull-right"><?=$settings['site_name']?>. Copyright <?=date('Y')?>. all rights reserved.</p>
			<p>
				Built by <a href="http://vuurr.com/">Vuurr</a> at <a href="http://gangplankhq.com/">Gangplank</a> in Chandler, Arizona.<br>
				Parts of this code licensed under the <a href="http://www.apache.org/licenses/LICENSE-2.0" target="_blank">Apache License v2.0</a>.
			</p>
		</footer>
	</div>
</body>
</html>