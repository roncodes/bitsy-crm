<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Clients Manager</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="Ronald A. Richardson">
		<!-- Stylesheets -->
		<link href="<?=base_url()?>public/css/bootstrap.css" rel="stylesheet">
		<link href="<?=base_url()?>public/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="<?=base_url()?>public/css/main.css" rel="stylesheet">
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- Javascript -->
		<script type="text/javascript" src="<?=base_url()?>public/js/jquery.js"></script>
		<script type="text/javascript" src="<?=base_url()?>public/js/jquery-ui.js"></script>
		<script type="text/javascript" src="<?=base_url()?>public/js/bootstrap.min.js"></script>
	</head>
	
	<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="<?=base_url()?>">Clients Manager</a>
				<div class="nav-collapse">
					<ul class="nav">
						<?php if(logged_in()){ ?>
						<li class="active"><a href="<?=base_url()?>">Home</a></li>
						<?php } else { ?>
						<li class="active"><a href="<?=base_url()?>">Login</a></li>
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