<fieldset id="create_circle">
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('name','', array('class' =>'xlarge', 'placeholder' => 'Name')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('desc','', array('class' =>'xlarge', 'placeholder' => 'Enter description of the group')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('invites','', array('class' =>'xlarge','placeholder' => 'Invite friends')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
	  		<div class="input-toolbar">
	  			<?php $media_url = "0"; ?>

	  			<?php if( isset($circle->circlemedia) and count($circle->circlemedia) > 0 ): ?>
	  				<?php foreach( $circle->circlemedia as $media ):?>
		  				<?php if ( $media->type === 'profile') : ?>
		  				<?php $media_url = '/files/circles/circle_'.$media->circle_id.'/'.$media->object['normal'];?>
		  				<div class="media_current">
		  					<img src="<?php echo $media_url;?>" />
		  				</div>
		  				<?php endif; ?>
	  				<?php endforeach; ?>
		  		<?php endif; ?>

	  			<?php echo Form::hidden('media_url',$media_url, array('data-media'=> $media_url)); ?>
	  			<div class="media_film_strip">
  				<a href="" class="nav_photo_sprite" id="scroller_left"></a>
  				<div id="media_upload_preview">
  					<!-- Load Upload Preview Content Here -->
  				</div>
  				<a href="" class="nav_photo_sprite" id="scroller_right"></a>
  				</div>	
	  			<ul>
	  				<li class="upload"><a href="#" id="upload_btn"></a></li>
	  				<li class="label">Upload a profile pic</li>		
	  			</ul>
	  		</div>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
			<?php echo Form::submit('submit', 'Create circle', array( 'class' => 'btn btn-primary','id' => 'action_create_circle')); ?>
		</div>	
	</div><!-- /clearfix -->
</fieldset>