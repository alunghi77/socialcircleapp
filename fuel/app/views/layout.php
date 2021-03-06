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
		'bgstretcher/bgstretcher.js',
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
	<div class="top-nav">
		<div class="container">
			<div class="row">
				<div class="span9">
					<?php echo $nav; ?>
				</div>
				<?php if(Auth::check()):?>
				<div id="profile" class="span3">
					<div class="content">
						<p class="title">Welcome, <?php echo $current_user_fullname;?> <a href="/logout">Logout</a></p>
					</div>
					<div class="image">
		  				<img src="<?php echo $media_url;?>" />
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="span12">
				<div id="content"> 
					<?php echo $content; ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
