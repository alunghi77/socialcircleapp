<div class="circles_container">	
	<a href="#" class="circle_scroller prev"></a>
	<a href="#" class="circle_scroller next"></a>

	<?php if(isset($circles) and is_array($circles)):?>

	<div class="circle">
		<div class="image">
			<a href="/circles/create" >
			<?php echo Asset::img('icons/icon-circle.png');?>
			</a>
		</div>
	</div>

	<?php foreach($circles as $circle ):?>

	<div class="circle">
		<div class="image">
			<a href="#" role="button" data-id="<?php echo $circle->id;?>" class="popover-test circle-tooltip switch_circle" data-toggle="popover" data-original-title="A Title" data-content="<?php echo $circle->name;?>">
		<?php if( isset($circle->circlemedia) and count($circle->circlemedia) > 0 ): ?>
			<?php foreach( $circle->circlemedia as $media ):?>
				<?php if ( $media->type === 'profile') : ?>
				<?php $media_url = '/files/circles/circle_'.$media->circle_id.'/'.$media->object['rounded'];?>
					<img src="<?php echo $media_url;?>" />
				<?php break; endif; ?>
			<?php endforeach; ?>
  		<?php endif; ?>
			</a>
		</div>
	</div>

	<?php endforeach; ?>


	<?php else : ?>

		<p>No groups listed</p>

	<?php endif; ?>

</div>

<div class="circle_container">	

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
	  			<?php echo Form::hidden('media_url',0); ?>
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
		  				<li class="meeting"><a href="#" i></a></li>
		  				<li class="venue"><a href="#" ></a></li>
		  				<li class="person"><a href="#"></a></li>
		  				<li class="post"><a href="#" id="action_submit_feed">Add</a></li>
		  			</ul>
		  		</div>
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


<!-- Circle Expand TMPL -->
<script id="circle-tmpl" type="text/x-handlebars-template">
	
	<div class="image circle-profile">
		<img src="{{circle.profile_pic}}" />
	</div>
	<div class="content">
		<h4>{{circle.name}} <span class="pull-right"><a href="/circles/edit/{{circle.id}}" class="edit_circle"><i class="icon-edit icon-white"></i> edit</a></span></h4>
		<p>{{circle.desc}}</p>
		<div class="members">
			{{#each circle.members.data}}
			<div class="member">
				<div class="image">
					<img src="{{this.posted_by.profile_pic}}" />
				</div>
				<div class="content">
					<h6>{{this.posted_by.fullname}}</h6>
				</div>
			</div>
			{{/each}}
		</div>
	</div>
	<div class="circle-menu">
		<ul>
			<li class="switch_circle"><a href="" data-id="{{circle.id}}">Feed</a></li>
			<li><a href="">About</a></li>
			<li><a href="">Events</a></li>
			<li><a href="">Resources</a></li>
			<li><a href="">Members</a></li>
		</ul>
	</div>
</script>

