<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css(array(
		'bootstrap.css',
		'style.css',

	)); ?>

	<?php echo Asset::js(array(
		'//code.jquery.com/jquery-1.9.1.min.js',
		'app.js',

	)); ?>
	
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="span9">
				<?php echo $nav; ?>
			</div>
			<?php if(Auth::check()):?>
			<div id="profile" class="span3">
				<div class="image">

				</div>
				<div class="content">
					<p class="title">Welcome, <strong><?php echo session::get('username');?></strong>! <a href="/logout">Logout</a></p>
				</div>
			</div>
			<?php endif; ?>
		</div>
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
