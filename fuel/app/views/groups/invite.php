<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($groupnav, "list" ); ?>'><?php echo Html::anchor('/groups/list','<i class="icon-th-list"></i>');?></li>
	<li class='<?php echo Arr::get($groupnav, "create" ); ?>'><?php echo Html::anchor('/groups/create','<i class="icon-plus-sign"></i>');?></li>
	<li class='<?php echo Arr::get($groupnav, "invite" ); ?>'><?php echo Html::anchor('/groups/invite','<i class="icon-flag"></i>');?></li>
</ul>

<?php if(isset($invites) and is_array($invites)):?>

<?php foreach($invites as $invite ):?>



<?php endforeach; ?>

<?php else : ?>

	<p>No group invites</p>

<?php endif; ?>