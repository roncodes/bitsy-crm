<?php if($display_head){ ?>
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
<?php } ?>
<?php echo $yield; ?>