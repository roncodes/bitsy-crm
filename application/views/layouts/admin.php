<!DOCTYPE HTML> 
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="http://www.facebook.com/2008/fbml"> 
<head>
	<meta charset="utf-8"> 
	<title><?=$meta_title?></title> 
	<meta name="description" content="<?=$meta_desc?>"> 
	<meta name="keywords" content="<?=$meta_keywords?>"> 
	
	<link href="<?=base_url('public/css/bootstrap.min.css')?>" rel="stylesheet" media="all">
	<link href="<?=base_url('public/css/fancybox.css')?>" rel="stylesheet" media="all">
	<link href="<?=base_url('public/css/main.css')?>" rel="stylesheet" media="all">
	
	<script src="<?=base_url('public/js/jquery.min.js')?>"></script>
	<script src="<?=base_url('public/js/bootstrap.min.js')?>"></script>
	<script src="<?=base_url('public/js/jquery.fancybox-1.3.1.pack.js')?>"></script>
	<script src="<?=base_url('public/js/admin.js')?>"></script>
	
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
						<li <?php if ($this->uri->segment(2) == '') echo 'class="active"'; ?>><a href="<?=base_url('admin')?>">Dashboard</a></li>
						<li <?php if ($this->uri->segment(2) == 'clients') echo 'class="active"'; ?>><a href="<?=base_url('admin/clients')?>">Clients</a></li>
						<li <?php if ($this->uri->segment(2) == 'projects') echo 'class="active"'; ?>><a href="<?=base_url('admin/projects')?>">Projects</a></li>
						<li <?php if ($this->uri->segment(2) == 'invoices') echo 'class="active"'; ?>><a href="<?=base_url('admin/invoices')?>">Invoices</a></li>
						<li <?php if ($this->uri->segment(2) == 'tickets') echo 'class="active"'; ?>><a href="<?=base_url('admin/tickets')?>">Tickets</a></li>
						<li <?php if ($this->uri->segment(2) == 'options') echo 'class="active"'; ?>><a href="<?=base_url('admin/options')?>">Options</a></li>
					</ul>
					<ul class="nav pull-right">
						<li><a href="<?=base_url()?>">Frontend</a></li>
						<li><a href="<?=base_url('auth/logout')?>">Logout</a></li>
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
</body>
</html>