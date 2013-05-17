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
		'//code.jquery.com/jquery-1.9.1.min.js',
		'handlebars/handlebars-1.0.rc.1.js',
		'lazyload/jquery.lazyload.min.js',
		'scrollTo/jquery.scrollTo-min.js',
		'bootstrap/bootstrap.js',
		'ajaxupload/ajax-uploader.js',
		'scroller/CSSPlugin.min.js',
		'scroller/jquery.mCustomScrollbar.js',
		'scroller/jquery.mousewheel.js',
		'scroller/TweenLite.min.js',
		'tinyscrollbar/jquery.tinyscrollbar.min.js',
		'pusher/pusher.min.js',

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
