<!DOCTYPE HTML> 
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="http://www.facebook.com/2008/fbml"> 
<head>
	<meta charset="utf-8"> 
	<title><?=$meta_title?></title> 
	<meta name="description" content="<?=$meta_desc?>"> 
	<meta name="keywords" content="<?=$meta_keywords?>"> 
	
	<!-- Stylesheets -->
	<link href="<?=base_url('public/css/bootstrap.css')?>" rel="stylesheet">
	<link href="<?=base_url('public/css/bootstrap-responsive.css')?>" rel="stylesheet">
	<link href="<?=base_url('public/css/main.css')?>" rel="stylesheet">
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!-- Javascript -->
	<script src="<?=base_url('public/js/jquery.min.js')?>" type="text/javascript" ></script>
	<script src="<?=base_url('public/js/jquery-ui.js')?>" type="text/javascript" ></script>
	<script src="<?=base_url('public/js/bootstrap.min.js')?>" type="text/javascript"></script>
</head>
	
<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="<?=base_url()?>"><?=$settings['site_name']?></a>
				<div class="nav-collapse">
					<ul class="nav">
						<?php if(logged_in()){ ?>
						<li <?php if ($this->uri->segment(2) == '') echo 'class="active"'; ?>><a href="<?=base_url()?>">Home</a></li>
						<li <?php if ($this->uri->segment(2) == 'invoices') echo 'class="active"'; ?>><a href="<?=base_url('client/invoices')?>">Invoices</a></li>
						<li <?php if ($this->uri->segment(2) == 'projects') echo 'class="active"'; ?>><a href="<?=base_url('client/projects')?>">Projects</a></li>
						<li <?php if ($this->uri->segment(2) == 'tickets') echo 'class="active"'; ?>><a href="<?=base_url('client/tickets')?>">Tickets</a></li>
						<li <?php if ($this->uri->segment(2) == 'profile') echo 'class="active"'; ?>><a href="<?=base_url('client/profile')?>">Your Profile</a></li>
						<?php } else { ?>
						<li <?php if ($this->uri->segment(2) == 'login') echo 'class="active"'; ?>><a href="<?=base_url('auth/login')?>">Login</a></li>
						<?php } ?>
					</ul>
					<?php if(logged_in()){ ?>
					<ul class="nav pull-right">
						<li class="divider-vertical"></li>
						<?php if(is_admin()){ ?>
						<li><a href="<?=base_url()?>admin">Admin</a></li>
						<?php } ?>
						<li><a href="<?=base_url()?>auth/logout">Logout</a></li>
					</ul>
					<?php } ?>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	
    <div class="container content">	
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
	