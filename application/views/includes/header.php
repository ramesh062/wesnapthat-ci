<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<meta name="theme-color" content="#FAC678" />
<link rel="shortcut icon" type="image/x-icon" href="favicon.png" />
<title>MonDoc-Patient</title>
<!-- Bootstrap -->
<link href="<?php echo SITE_FRONTEND_CSS?>bootstrap.min.css" rel="stylesheet">
<link href="<?php echo SITE_FRONTEND_CSS?>style.css" rel="stylesheet">
<link href="<?php echo SITE_FRONTEND_CSS?>responsive.css" rel="stylesheet">
<link href="<?php echo SITE_FRONTEND_CSS?>font-awesome.css" rel="stylesheet">
</head>
<body>
<!-- Header -->
<header>
<div class="container">
	<nav class="navbar m-0 p-0">
		<a class="navbar-brand" href="#"><img src="<?php echo SITE_FRONTEND_IMAGES?>logo.png" alt=""></a>            
		<div class="switch-button">
			<a id="langid1" href="javascript:void(0)" onClick="change_language('En')"  class="switch-button-case active-case"><img src="<?php echo SITE_FRONTEND_IMAGES?>flag1.png" alt=""> <span>En</span></a>
			<a id="langid2" href="javascript:void(0)" onClick="change_language('Fr')" class="switch-button-case"><img src="<?php echo SITE_FRONTEND_IMAGES?>flag2.png" alt=""> <span>Fr</span></a>
		</div>
	</nav>
</div>
</header>
