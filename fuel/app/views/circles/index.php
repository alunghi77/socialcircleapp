<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($groupnav, "list" ); ?>'><?php echo Html::anchor('/circles/list','<i class="icon-th-list"></i>');?></li>
	<li class='<?php echo Arr::get($groupnav, "create" ); ?>'><?php echo Html::anchor('/circles/create','<i class="icon-plus-sign"></i>');?></li>
	<li class='<?php echo Arr::get($groupnav, "invite" ); ?>'><?php echo Html::anchor('/circles/invite','<i class="icon-flag"></i>');?></li>
</ul>

<p>Index</p>