<fieldset id="create_account">
	<div class="clearfix">
		<label for="xlInput">Username: <span class="required">*</span></label>
		<div class="input">
	  		<?php echo Form::input('username','', array('class' =>'xlarge', 'placeholder' => 'Username')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<label for="xlInput">Email: <span class="required">*</span></label>
		<div class="input">
	  		<?php echo Form::input('email','', array('class' =>'xlarge', 'placeholder' => 'email')); ?>
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
			<?php echo Form::submit('submit', 'Go', array( 'class' => 'btn btn-primary','id' => 'action_signup')); ?>
		</div>	
	</div><!-- /clearfix -->
</fieldset>