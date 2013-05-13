<fieldset>
	<div class="clearfix">
		<label for="xlInput">Name: <span class="required">*</span></label>
		<div class="input">
	  		<?php echo Form::input('username','', array('class' =>'xlarge', 'placeholder' => 'Name')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<label for="xlInput">Email: <span class="required">*</span></label>
		<div class="input">
	  		<?php echo Form::input('username','', array('class' =>'xlarge', 'placeholder' => 'Username or email')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<label for="xlInput">Profile Pic: <span class="required">*</span></label>
		<div class="input">
	  		<?php echo Form::input('profilePic','', array('class' =>'xlarge')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
			<?php echo Form::submit('submit', 'Go', array( 'class' => 'btn btn-primary','id' => 'signin_button')); ?>
		</div>	
	</div><!-- /clearfix -->
</fieldset>