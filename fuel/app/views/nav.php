<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($subnav, "home" ); ?>'><?php echo Html::anchor('/','<i class="icon-home"></i>');?></li>
	<li class='<?php echo Arr::get($subnav, "login" ); ?>'><?php echo Html::anchor('/login','<i class="icon-user"></i>');?></li>
	<li class='<?php echo Arr::get($subnav, "groups" ); ?>'><?php echo Html::anchor('/groups','<i class="icon-leaf"></i>');?></li>
	<li class='<?php echo Arr::get($subnav, "settings" ); ?>'><?php echo Html::anchor('/settings','<i class="icon-list"></i>');?></li>
	<li class='<?php echo Arr::get($subnav, "feed" ); ?>'><?php echo Html::anchor('/feed','<i class="icon-th-list"></i>');?></li>
</ul>