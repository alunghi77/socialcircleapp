<?php $data['user'] = $user;?>
<div class="settings panel">
	<h2>User setting</h2>
	<div class="alert alert-success"></div>
	<div class="alert alert-error"></div>
	<?php echo Form::open(array('action' => '/', 'method' => 'post', 'id' => 'form_settings', 'name' => 'form_settings')); ?>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	<?php echo Form::hidden('id',$user->id); ?>
	<?php echo render('forms/_form_settings', $data); ?>
	<?php echo Form::close(); ?>
</div>