<div class="circles_container">	
	<a href="#" class="circle_scroller prev"></a>
	<a href="#" class="circle_scroller next"></a>

	<?php if(isset($circles) and is_array($circles)):?>

	<div class="circles">

	<?php foreach($circles as $circle ):?>

	<div class="circle">
		<div class="image span2">
			<a href="#" role="button" data-id="<?php echo $circle->id;?>" class="popover-test circle-tooltip" data-toggle="popover" data-original-title="A Title" data-content="<?php echo $circle->name;?>"></a>
		</div>
	</div>

	<?php endforeach; ?>

	</div>

	<?php else : ?>

		<p>No groups listed</p>

	<?php endif; ?>

</div>

<div class="feeds-container">
	<div class="create-feed">
		<div class="clearfix">
		<div class="input">
			
			<?php echo Form::hidden('circle_id',0); ?>
			<?php echo Form::hidden('media_url',0); ?>
	  		<?php echo Form::input('discussion','', array('class' =>'xlarge', 'placeholder' => 'start a discussion...')); ?>
	  		
	  		<div class="input-toolbar">
	  			<div class="media_film_strip">
	  				<a href="" class="nav_photo_sprite" id="scroller_left"></a>
	  				<div id="media_upload_preview">
	  					<!-- Load Upload Preview Content Here -->
	  				</div>
	  				<a href="" class="nav_photo_sprite" id="scroller_right"></a>
  				</div>	
	  			<ul>
	  				<li class="upload"><a href="#" id="upload_btn"></a></li>
	  				<li class="post"><a href="#" id="action_submit_feed">Post</a></li>
	  			</ul>
	  		</div>
	  		
		</div>	
	</div><!-- /clearfix -->

	</div>
	<div class="feeds">
		<!-- Feeds loaded here -->
	</div>
</div>

<div class="tasks-container">
	<div class="create-task">
		<div class="clearfix">
			<div class="input">
	  			<?php echo Form::input('status','', array('class' =>'xlarge', 'placeholder' => 'add a todo list...')); ?>
			</div>	
		</div><!-- /clearfix -->
	</div>
</div>


<!-- Feed TL TMPL -->
<script id="feedTL-tmpl" type="text/x-handlebars-template">
	
	{{#each feeds}}
	<div class="feed feed-{{this.id}}">
		<div class="feed-posted-by">
			<div class="image">
			{{#if this.posted_by.profile_pic}}
				<img src="{{this.posted_by.profile_pic}}" />
			{{/if}}
			</div>
		</div>
		<div class="feed-content">
			{{#if this.posted_by.username}}
			<div class="feed-intro">
				<strong><a href="">{{this.posted_by.username}}</a></strong> shared a new <strong>{{this.media.object.type}}</strong>
			</div>
			{{/if}}
			{{media this.media}}
			{{#if this.message}}
			<div class="feed-message">
				<p>{{this.message}}</p>
			</div>
			{{/if}}
		</div>
	</div>
	<div class="feed-comments">
		{{#each this.comments}}
		<div class="feed-comment">
			<div class="image">
			{{#if this.posted_by.profile_pic}}
				<img src="{{this.posted_by.profile_pic}}" />
			{{/if}}
			</div>
			<div class="content">
				<p>
					{{this.message}}
				</p>
				<ul class="meta">
					<li>{{this.time_ago}}</li>
				</ul>
			</div>
		</div>
		{{/each}}
		<div class="create-comment">
			<div class="clearfix">
				<div class="image image-small">
					{{#if this.posted_by.profile_pic}}
						<img src="{{this.posted_by.profile_pic}}" />
					{{/if}}
				</div>
				<div class="input content" >
					<input class="xlarge" placeholder="add a comment..." name="feed_comment" value="" type="text" id="form_feed_comment" data-id="{{this.id}}"/>
				</div>	
			</div>
		</div>
	</div>

	{{/each}}
	
</script>



<!-- Feed Comments Expand TMPL -->
<script id="feedComments-tmpl" type="text/x-handlebars-template">
	
	{{#each comments}}		
	<div class="feed-comment">
		<div class="image">
		{{#if this.posted_by.profile_pic}}
			<img src="{{this.posted_by.profile_pic}}" />
		{{/if}}	
		</div>
		<div class="content">
			<p>
				{{this.message}}
			</p>
		</div>
	</div>
	{{/each}}
	
</script>


