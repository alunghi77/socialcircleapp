<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($groupnav, "list" ); ?>'><?php echo Html::anchor('/groups/list','<i class="icon-th-list"></i>');?></li>
	<li class='<?php echo Arr::get($groupnav, "create" ); ?>'><?php echo Html::anchor('/groups/create','<i class="icon-plus-sign"></i>');?></li>
	<li class='<?php echo Arr::get($groupnav, "invite" ); ?>'><?php echo Html::anchor('/groups/invite','<i class="icon-flag"></i>');?></li>
</ul>

<div class="create_group panel">
	<h2>Create Group</h2>

	<?php echo Form::open(array('action' => '/', 'method' => 'post', 'id' => 'form_signup', 'name' => 'form_signup')); ?>
	<?php echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token());?>
	<?php echo render('forms/_form_create_group'); ?>
	<?php echo Form::close(); ?>
</div>