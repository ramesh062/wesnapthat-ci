<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<meta name="theme-color" content="#FAC678" />
<link rel="shortcut icon" type="image/x-icon" href="favicon.png" />
<title>MonDoc-<?php echo $page_name?></title>
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
	</nav>
</div>
</header>
<!-- Hero -->
<section class="mt-5 pt-5">
	<div class="container mt-5 pt-2">
		<div class="row">
			<div class="">
				<?php echo "<p>".$content. "</p>";?>
			</div>
		</div>	
	</div>
</section>

<?php require("includes/footer.php");?>
</body>
</html>
