<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($groupnav, "list" ); ?>'><?php echo Html::anchor('/circles/list','<i class="icon-th-list"></i>');?></li>
	<li class='<?php echo Arr::get($groupnav, "create" ); ?>'><?php echo Html::anchor('/circles/create','<i class="icon-plus-sign"></i>');?></li>
	<li class='<?php echo Arr::get($groupnav, "invite" ); ?>'><?php echo Html::anchor('/circles/invite','<i class="icon-flag"></i>');?></li>
</ul>

<div class="create_group panel">
	<h2>Create Circle</h2>
	<div class="alert alert-success"></div>
	<div class="alert alert-error"></div>
	<?php echo Form::open(array('action' => '/', 'method' => 'post', 'id' => 'form_signup', 'name' => 'form_signup')); ?>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	<?php echo render('forms/_form_create_group'); ?>
	<?php echo Form::close(); ?>
</div>