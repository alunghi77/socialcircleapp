<fieldset id="create_account">
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('username','', array('class' =>'xlarge', 'placeholder' => 'Username')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('email','', array('class' =>'xlarge', 'placeholder' => 'email')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
	  		<?php echo Form::input('password','', array('class' =>'xlarge', 'placeholder' => 'password')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
			<?php echo Form::submit('submit', 'Create account', array( 'class' => 'btn btn-primary','id' => 'action_signup')); ?>
		</div>	
	</div><!-- /clearfix -->
</fieldset>