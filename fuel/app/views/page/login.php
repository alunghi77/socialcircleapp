<div class="login_panel">
	<h2>Login</h2>

	<?php echo Form::open(array('action' => '/', 'method' => 'post', 'id' => 'form_login', 'name' => 'form_login')); ?>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	<?php echo render('forms/_form_login'); ?>
	<?php echo Form::close(); ?>
</div>

<div class="signup_panel">
	<h2>Create Account</h2>

	<?php echo Form::open(array('action' => '/', 'method' => 'post', 'id' => 'form_signup', 'name' => 'form_signup')); ?>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	<?php echo render('forms/_form_signup'); ?>
	<?php echo Form::close(); ?>
</div>