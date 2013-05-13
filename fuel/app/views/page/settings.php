<div class="settings_panel">
	<h2>User setting</h2>

	<?php echo Form::open(array('action' => '/', 'method' => 'post', 'id' => 'form_settings', 'name' => 'form_settings')); ?>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	<?php echo render('forms/_form_settings'); ?>
	<?php echo Form::close(); ?>
</div>