<fieldset>
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('username','', array('class' =>'xlarge', 'placeholder' => 'Username')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('email','', array('class' =>'xlarge', 'placeholder' => 'Email')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('profilePic','', array('class' =>'xlarge')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
			<?php echo Form::submit('submit', 'Go', array( 'class' => 'btn btn-primary','id' => 'action_update_settings')); ?>
		</div>	
	</div><!-- /clearfix -->
</fieldset>