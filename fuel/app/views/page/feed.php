<div class="circles_container">	
	<a href="#" class="circle_scroller prev">Prev</a>
	<a href="#" class="circle_scroller next">Next</a>

	<?php if(isset($circles) and is_array($circles)):?>

	<div class="circles">

	<?php foreach($circles as $circle ):?>

	<div class="circle">
		<div class="image span2">
			<?php echo $circle->name;?>
		</div>
	</div>

	<?php endforeach; ?>

	</div>

	<?php else : ?>

		<p>No groups listed</p>

	<?php endif; ?>

</div>

<div class="feeds-container">
	<div class="create-feed">
		<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('status','', array('class' =>'xlarge', 'placeholder' => 'add something...')); ?>
		</div>	
	</div><!-- /clearfix -->

	</div>
	<div class="feeds">
		<div class="feed feed-01">
			<div class="feed-meta">
				<a href="">Alessio</a> has commented on:
			</div>
			<div class="image image-large">


			</div>
			<div class="feed-message">
				<p>This is a message that will be truncated if its too big...</p>
			</div>
		</div>
		<div class="feed-comments">
			<div class="feed-comment comment-01">
				<div class="image image-small">

				</div>
				<div class="content">
					<p>This is my response to your response. Enjoy!</p>
				</div>
			</div>
			<div class="feed-comment comment-02">
				<div class="image image-small">

				</div>
				<div class="content">
					<p>This is my response to your response. Enjoy!</p>
				</div>
			</div>
			<div class="feed-comment comment-03">
				<div class="image image-small">

				</div>
				<div class="content">
					<p>This is my response to your response. Enjoy!</p>
				</div>
			</div>
			<div class="create-comment">
				<div class="clearfix">
					<div class="input">
			  			<?php echo Form::input('status','', array('class' =>'xlarge', 'placeholder' => 'add something...')); ?>
					</div>	
				</div><!-- /clearfix -->
			</div>
		</div>
	</div>
</div>

<div class="tasks-container">
	<div class="create-task">
		<div class="clearfix">
			<div class="input">
	  			<?php echo Form::input('status','', array('class' =>'xlarge', 'placeholder' => 'add something...')); ?>
			</div>	
		</div><!-- /clearfix -->
	</div>
</div>