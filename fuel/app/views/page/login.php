<?php if(!Auth::check()):?>

<div class="signup panel">
	<h2>Create Account</h2>
	<div class="alert alert-success"></div>
	<div class="alert alert-error"></div>
	<?php echo Form::open(array('action' => '/', 'method' => 'post', 'id' => 'form_signup', 'name' => 'form_signup')); ?>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	<?php echo render('forms/_form_signup'); ?>
	<?php echo Form::close(); ?>
</div>

<?php endif; ?>