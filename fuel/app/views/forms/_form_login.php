<fieldset id="login_user">
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('username','', array('class' =>'xlarge', 'placeholder' => 'Username or email')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::password('password','', array('class' =>'xlarge', 'placeholder' => 'Password')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
			<?php echo Form::submit('submit', 'Login', array( 'class' => 'btn btn-primary','id' => 'action_signin')); ?>
		</div>	
	</div><!-- /clearfix -->
</fieldset>