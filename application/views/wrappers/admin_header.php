<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Clients Manager | Administration</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="Ronald A. Richardson">
		<!-- Stylesheets -->
		<link href="<?=base_url()?>public/css/bootstrap.css" rel="stylesheet">
		<link href="<?=base_url()?>public/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="<?=base_url()?>public/css/main.css" rel="stylesheet">
		<link href="<?=base_url()?>public/css/skins/markitup/style.css" rel="stylesheet">
		<link href="<?=base_url()?>public/js/sets/default/style.css" rel="stylesheet">
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- Javascript -->
		<script type="text/javascript" src="<?=base_url()?>public/js/jquery.js"></script>
		<script type="text/javascript" src="<?=base_url()?>public/js/jquery.markitup.js"></script>
		<script type="text/javascript" src="<?=base_url()?>public/js/sets/default/set.js"></script>
		<script type="text/javascript" src="<?=base_url()?>public/js/jquery-ui.js"></script>
		<script type="text/javascript" src="<?=base_url()?>public/js/bootstrap.min.js"></script>
	</head>
	
	<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="<?=base_url()?>">Clients Manager Admin</a>
				<div class="nav-collapse">
					<ul class="nav">
						<li <?php if($page==''){ ?>class="active"<?php } ?>><a href="<?=base_url()?>admin">Dashboard</a></li>
						<li <?php if($page=='clients'){ ?>class="active"<?php } ?>><a href="<?=base_url()?>admin/clients">Clients</a></li>
						<li <?php if($page=='invoices'){ ?>class="active"<?php } ?>><a href="<?=base_url()?>admin/invoices">Invoices</a></li>
					</ul>
					<ul class="nav pull-right">
						<li class="divider-vertical"></li>
						<li><a href="<?=base_url()?>">Frontend</a></li>
						<li><a href="<?=base_url()?>auth/logout">Logout</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	
    <div class="container content">