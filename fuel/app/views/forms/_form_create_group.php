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
			<?php echo Form::submit('submit', 'Create circle', array( 'class' => 'btn btn-primary','id' => 'action_create_circle')); ?>
		</div>	
	</div><!-- /clearfix -->
</fieldset>