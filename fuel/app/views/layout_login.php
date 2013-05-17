<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css(array(
		'//fonts.googleapis.com/css?family=Open+Sans',
		'bootstrap.css',
		'style.css',

	)); ?>

	<?php Asset::add_path('assets/js/libs','js');?>
	<?php echo Asset::js(array(
		'//code.jquery.com/jquery-1.8.2.min.js',
		'bgstretcher/bgstretcher.js',
		'bootstrap/bootstrap.js',
	));?>

	<?php echo Asset::js(array(
		
		'app.js',

	)); ?>
	
</head>
<body class="<?php echo $pageclass;?>">
	
	<div id="content"> 
		<?php echo $content; ?>
	</div>
			
</body>
</html>
