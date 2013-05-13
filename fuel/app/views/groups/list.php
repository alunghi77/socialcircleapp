<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($groupnav, "list" ); ?>'><?php echo Html::anchor('/groups/list','<i class="icon-th-list"></i>');?></li>
	<li class='<?php echo Arr::get($groupnav, "create" ); ?>'><?php echo Html::anchor('/groups/create','<i class="icon-plus-sign"></i>');?></li>
	<li class='<?php echo Arr::get($groupnav, "invite" ); ?>'><?php echo Html::anchor('/groups/invite','<i class="icon-flag"></i>');?></li>
</ul>

<?php if(isset($circles) and is_array($circles)):?>
<div class="groups span12">

<?php foreach($circles as $group ):?>

<div class="group">
		<div class="image span2">

		</div>
		<div class="content span10">
			<h3 class="title"><?php echo $group->name;?></h3>
			<p class="desc"><?php echo $group->desc;?></p>
			<ul class="meta">
				<li><a href="" class="join_group">join</a></li>
			</ul>
		</div>
	</div>

<?php endforeach; ?>

</div>

<?php else : ?>

	<p>No groups listed</p>

<?php endif; ?>
