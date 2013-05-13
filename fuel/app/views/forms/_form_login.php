<fieldset id="login_user">
	<div class="clearfix">
		<label for="xlInput">Username: <span class="required">*</span></label>
		<div class="input">
	  		<?php echo Form::input('username','', array('class' =>'xlarge', 'placeholder' => 'Username or email')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<label for="xlInput">Password: <span class="required">*</span></label>
		<div class="input">
	  		<?php echo Form::input('password','', array('class' =>'xlarge')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
			<?php echo Form::submit('submit', 'Go', array( 'class' => 'btn btn-primary','id' => 'action_signin')); ?>
		</div>	
	</div><!-- /clearfix -->
</fieldset>