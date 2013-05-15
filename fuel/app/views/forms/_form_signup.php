<fieldset id="create_account">
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('fullname','', array('class' =>'xlarge', 'placeholder' => 'Enter your full name')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('username','', array('class' =>'xlarge', 'placeholder' => 'Username')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::password('password','', array('class' =>'xlarge', 'placeholder' => 'password')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('email','', array('class' =>'xlarge', 'placeholder' => 'Enter your email')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('mobile','', array('class' =>'xlarge', 'placeholder' => 'Enter your mobile number')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('resources','', array('class' =>'xlarge', 'data-resources'=>'0','placeholder' => 'Enter resources that you have')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('skills','', array('class' =>'xlarge','data-skills'=>'0', 'placeholder' => 'Enter skills that you have')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
	  		<div class="input-toolbar">
	  			<?php echo Form::hidden('media_url',0, array('data-media'=>'0')); ?>
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
			<?php echo Form::submit('submit', 'Create account', array( 'class' => 'btn btn-primary','id' => 'action_signup')); ?>
		</div>	
	</div><!-- /clearfix -->
</fieldset>