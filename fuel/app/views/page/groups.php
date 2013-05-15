<?php echo $groupnav;?>
<div class="create_group panel">
	<h2>Create Group</h2>
	<div class="alert alert-success"></div>
	<div class="alert alert-error"></div>
	<?php echo Form::open(array('action' => '/', 'method' => 'post', 'id' => 'form_settings', 'name' => 'form_settings')); ?>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	<?php echo render('forms/_form_settings'); ?>
	<?php echo Form::close(); ?>
</div>
