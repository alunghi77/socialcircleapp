<fieldset>
	<div class="clearfix">
		<label for="xlInput">Group Name: <span class="required">*</span></label>
		<div class="input">
	  		<?php echo Form::input('groupName','', array('class' =>'xlarge', 'placeholder' => 'Name')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<label for="xlInput">Description: <span class="required">*</span></label>
		<div class="input">
	  		<?php echo Form::input('description','', array('class' =>'xlarge', 'placeholder' => 'Enter description of the group')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<label for="xlInput">Invite People: <span class="required">*</span></label>
		<div class="input">
	  		<?php echo Form::input('invites','', array('class' =>'xlarge')); ?>
		</div>	
	</div><!-- /clearfix -->
	<div class="clearfix">
		<div class="input">
			<?php echo Form::submit('submit', 'Go', array( 'class' => 'btn btn-primary','id' => 'signin_button')); ?>
		</div>	
	</div><!-- /clearfix -->
</fieldset>