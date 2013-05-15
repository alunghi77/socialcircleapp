# Main app script

# ------------------------------------------------------ 
# Create Comment
# ------------------------------------------------------ 
#
# - create_comment
#
# /POST /api/comments		- create new post
# /POST /api/comments/<id>	- update post with id <id>
# ------------------------------------------------------

create_comment = (e) ->

	# Payload
	obj 			= { }
	obj["message"] 	= e.target.value
	obj["id"]		= e.target.getAttribute("data-id")
	
	# Resource
	$.post "/api/comments/" + obj["id"], obj, ( res, status ) ->

		if res.head.success

			commentdata = []
			commentdata.push res.data

			template 	= Handlebars.compile $("#feedComments-tmpl").html()
			html 	 	= $.trim( template {"comments":commentdata} )

			$target = $(e.target).parent().parent().parent()

			$( html ).insertBefore( $target )

			$(e.target).val('')

			
	# Error
	.fail () ->

		$(".comment_overlay_container").fadeOut "fast"

	false

# ---------------------------
# Create user
# ---------------------------
create_user = () ->

	obj = {}
	obj["username"] 	= $("#create_account #form_username").val()
	obj["password"] 	= $("#create_account #form_password").val()
	obj["fullname"] 	= $("#create_account #form_fullname").val()
	obj["email"] 		= $("#create_account #form_email").val()
	obj["media_data"] 	= JSON.parse $("#create_account #form_media_url").attr("data-media")
	obj["media_url"] 	= $("#create_account #form_media_url").val()
	obj["mobile"] 		= $("#create_account #form_mobile").val()
	obj["resources"] 	= $("#create_account #form_resources").attr("data-resources")
	obj["skills"] 		= $("#create_account #form_skills").attr("data-skills")

	$(".alert").slideUp "fast", () ->

		$(@).empty()

	$.post "/api/users", obj, (res,status)->

		if res.head.success

			$(".alert-success").fadeIn "fast"
			$(".alert-success").animate { height:"40px"}, 500, () ->

				$(@).append("<p>Great! Your have successfully created an account</p>")

	.fail (xhr) ->
	
		res = JSON.parse xhr.responseText
		# handle errors	
		console.log res.head.description

		$(".alert-error").fadeIn "fast"
		$(".alert-error").animate { height:"40px"}, 500, () ->

			$(@).append("<p>Ooops! You didn't fill out all the required fields.</p>")

	false

# ---------------------------
# Update user
# ---------------------------
update_user = () ->

	obj = {}
	obj["username"] 	= $("#form_settings #form_username").val()
	obj["fullname"] 	= $("#form_settings #form_fullname").val()
	obj["email"] 		= $("#form_settings #form_email").val()
	obj["media_url"] 	= $("#form_settings #form_media_url").val()
	obj["mobile"] 		= $("#form_settings #form_mobile").val()
	obj["resources"] 	= $("#form_settings #form_resources").attr("data-resources")
	obj["skills"] 		= $("#form_settings #form_skills").attr("data-skills")

	id = $("#form_settings #form_id").val()

	$(".alert").slideUp "fast", () ->

		$(@).empty()

	$.post "/api/users/#{id}", obj, (res,status)->

		if res.head.success

			$(".alert-success").fadeIn "fast"
			$(".alert-success").animate { height:"40px"}, 500, () ->

				$(@).append("<p>Great! Your settings have been updated successfully</p>")

	.fail (xhr) ->
	
		res = JSON.parse xhr.responseText
		# handle errors	
		console.log res.head.description

		$(".alert-error").fadeIn "fast"
		$(".alert-error").animate { height:"40px"}, 500, () ->

			$(@).append("<p>Ooops! User settings were not updated.</p>")

	false


# ---------------------------
# Create Circle
# ---------------------------
create_circle = () ->

	obj = {}
	obj["name"] 	 = $("#create_circle #form_name").val()
	obj["desc"] 	 = $("#create_circle #form_desc").val()
	obj["invitees"]  = $("#create_circle #form_invitees").val()
	obj["media_url"] = $("#create_circle #form_media_url").val()

	$(".alert").slideUp "fast", () ->

		$(@).empty()

	$.post "/api/circles", obj, (res,status)->

		if res.head.success

			$(".alert-success").fadeIn "fast"
			$(".alert-success").animate { height:"40px"}, 500, () ->

				$(@).append("<p>Great! Your have successfully created an account</p>")

	.fail (xhr) ->
	
		res = JSON.parse xhr.responseText
		# handle errors	
		console.log res.head.description

		$(".alert-error").fadeIn "fast"
		$(".alert-error").animate { height:"40px"}, 500, () ->

			$(@).append("<p>Ooops! You didn't fill out all the required fields.</p>")

	false

# ---------------------------
# Update Circle
# ---------------------------
update_circle = () ->

	obj = {}
	obj["name"] 		= $("#form_edit_circle #form_name").val()
	obj["desc"] 		= $("#form_edit_circle #form_desc").val()
	obj["invitees"] 	= $("#form_edit_circle #form_invitees").val()
	obj["media_url"] 	= $("#form_edit_circle #form_media_url").val()

	id = $("#form_edit_circle #form_id").val()

	$(".alert").slideUp "fast", () ->

		$(@).empty()

	$.post "/api/circles/#{id}", obj, (res,status)->

		if res.head.success

			$(".alert-success").fadeIn "fast"
			$(".alert-success").animate { height:"40px"}, 500, () ->

				$(@).append("<p>Great! Your have successfully updated your circle</p>")

	.fail (xhr) ->
	
		res = JSON.parse xhr.responseText
		# handle errors	
		console.log res.head.description

		$(".alert-error").fadeIn "fast"
		$(".alert-error").animate { height:"40px"}, 500, () ->

			$(@).append("<p>Ooops! You didn't fill out all the required fields.</p>")

	false


# ---------------------------
# Switch Circle
# ---------------------------
switch_circle = () ->

	id = $(@).attr("data-id")

	$(".feeds-container #form_circle_id").val("#{id}")

	$(".create-feed").addClass("ajax-small")



	# Fecth Feeds

	$(".feeds").fadeOut "slow", ()->
	
	$(".circle_container").slideUp "fast", ()->

		$(@).empty()

	$.get "/api/feeds/#{id}", (res,status)->

		if res.head.success	

			# ---------------------------
			# Render tmpl
			# ---------------------------

			template 	= Handlebars.compile $("#circle-tmpl").html()
			html 	 	= $.trim template {"circle":res.data }	

			console.log res.data

			$(".circle_container").append( html );	
			$(".circle_container").slideDown "slow"

			# ---------------------------
			# Display Media
			# ---------------------------

			# Vimeo

			# -- status_li
			Handlebars.registerHelper "media", 	(media) -> 

				if media

					url = media.object.video_link

					$(".post_preview_image").empty()

					if media.object.type is "image"

						return new Handlebars.SafeString $('<div class="feed-image image">').append("<img src='#{media.object.image_sizes.cropped}' />").html()
					
					else 

						switch media.object.site_name

							when "SoundCloud"

								return new Handlebars.SafeString $('<div class="feed-image image">').append($("<iframe />", {

									src 		: url + "&auto_play=false&show_comments=false&buying=false&sharing=false&show_playcount=false$download=false&liking=false",
									width 		: "100%",
									height 		: "170px",
									frameborder : "0",

								}).clone()).html()

							when "YouTube"

								return new Handlebars.SafeString $('<div class="feed-image image">').append($("<iframe />", {

									src 		: url,
									title 		: 'title here',
									width 		: "100%",
									height 		: "260px",
									frameborder : "0",
									type 		: "text/html",
									class 		: "youTubePreview",
									id 			: "youTubePreview",
									webkitAllowFullScreen 	: "true",
									mozallowfullscreen  	: "true",
									allowFullScreen  		: "true"

								}).clone()).html()


							when "Vimeo"

								return new Handlebars.SafeString $('<div class="feed-image image">').append($("<iframe />", {

									src 		: url,
									title 		: 'title here',
									width 		: "100%",
									height 		: "260px",
									frameborder : "0",
									type 		: "text/html",
									webkitAllowFullScreen 	: "true",
									mozallowfullscreen  	: "true",
									allowFullScreen  		: "true"

								}).clone()).html()

							when "local_video"

								p = []
								p.push "<video controls width=100% height=290px>"
								p.push "<source src=#{url} type=video/mp4>"
								p.push "</video>"

								return new Handlebars.SafeString p.join ""	

			# ---------------------------
			# Render tmpl
			# ---------------------------

			template 	= Handlebars.compile $("#feedTL-tmpl").html()
			html 	 	= $.trim template {"feeds":res.data.feeds.data }

			$(".feeds").empty()
			$(".create-feed").removeClass("ajax-small")
			$(".feeds").append(html)
			$(".feeds").fadeIn "fast"

			feed_events()



	.fail (xhr) ->
	
		$(".feeds").fadeOut "slow", ()->

			$(".feeds").empty().append("<div class='feed no-feed'><p>No feeds yet!</p></div>")

			$(".feeds").fadeIn "fast"

		

	false

# ---------------------------
# Create user
# ---------------------------
create_feed = () ->

	obj = {}
	obj["discussion"] 	= $(".create-feed #form_discussion").val()
	obj["media_data"] 	= JSON.parse $(".create-feed #form_media_url").attr("data-media")
	obj["circle_id"] 	= circle_id = $(".feeds-container #form_circle_id").val()

	# reset preview
	$(".media_film_strip").slideUp "slow", () ->

		$(".media_upload_preview").empty()
		$("#form_discussion").val('')


	$.post "/api/feeds", obj, (res,status)->

		if res.head.success

			$.get "/api/feeds/#{circle_id}", (res,status)->

				# use handlebars to construct feed from JSON object
				# ---------------------------
				# Render tmpl
				# ---------------------------

				template 	= Handlebars.compile $("#feedTL-tmpl").html()
				html 	 	= $.trim template {"feeds":res.data.feeds.data }

				$(".feeds").prepend(html)
				$(".feeds").fadeIn "slow"

				feed_events()

	.fail (xhr) ->
	
		# res = JSON.parse xhr.responseText
		# handle errors	
		console.log xhr

	false

feed_events = () ->

	# Create Feed Comment
	$(".create-comment #form_feed_comment").keyup (e) ->

		if e.keyCode is 13

			create_comment(e)


# ---------------------------
# Find User
# ---------------------------
find_user = () ->

	obj = {}
	obj["q"] 		= $("#create_circle #form_q").val()
	
	$.get "/api/users/search", obj, (res,status)->

		if res.head.success

			console.log "success"

	.fail (xhr) ->
	
		# res = JSON.parse xhr.responseText
		# # handle errors	
		# console.log res.head.description

	false

# ---------------------------
# Auth user
# ---------------------------
auth_user = () ->

	obj = {}
	obj["username"] = $("#login_user #form_username").val()
	obj["password"] = $("#login_user #form_password").val()

	$.post "/api/users/auth", obj, (res,status)->

		if res.head.success

			window.location.href = '/';

			
	.fail (xhr) ->
	
		res = JSON.parse xhr.responseText
		# handle errors	
		console.log res.head.description

	false

# ----------------------------------
# Media Uploader
# ----------------------------------

media_uploader = () ->

	upload_photo 	= $('#upload_btn')

	new AjaxUpload upload_photo, 
		action: '/api/images', # returns html
		name: 'myfile',
		data: {
			'image' : 'upload'
		},
		multiple: false,
		onSubmit : (file, ext) -> 

			$("#form_url").slideUp "fast"
			
			$(".media_film_strip").slideDown()
			$("#media_upload_preview").addClass("ajax")

			this.disable()
		,
		onError:(file, response) -> 

			alert "ERROR!"
		,
		onComplete: (file, response) -> 

			window.clearInterval(@interval)

			this.enable()

			if response is "Error"

				$("#media_upload_preview img, #media_upload_preview p").remove()
				$("#media_upload_preview").append("<p>The image you tried to upload is too large to be processed. Please reduce its size or choose another</p>")

			else 

				preview_media_api(response)

# ------------------------------------------------------ 
# Preview Media 
# ------------------------------------------------------ 

preview_media = (e) ->

	$(".media_film_strip").slideDown()

	$("#media_upload_preview").addClass("ajax")

	setTimeout( () ->

		url = e.target.value
		
		preview_media_api(url)

	, 200)

# ------------------------------------------------------ 
# Preview Media Api
# ------------------------------------------------------ 

preview_media_api = ( url ) ->

	# Payload
	obj 		= { }
	obj["url"] 	= url

	$.post "/api/media", obj, (res, status) ->

		$("#media_upload_preview").removeClass("ajax")

		# construct preview
		if res.data.preview.error isnt undefined

			$("#media_upload_preview").empty().append("<h3>" + res.data.preview.error + "</h3>")

		else  

			$("#form_type").val(res.data.preview.type)

			switch res.data.preview.type

				when "image"

					$("#form_media_url").val(res.data.preview.image_src)
					$("#form_media_url").attr("data-media", JSON.stringify(res.data.preview) )
					$("#media_upload_preview").empty().append("<img src='" + res.data.preview.image_src + "' />")

				else

					p = []
					p.push "<h3><a href='" + res.data.preview.url + "' target='_blank'>"
					p.push res.data.preview.title
					p.push "</a></h3>"
					p.push "<p>"
					p.push res.data.preview.description
					p.push "</p>"
					p.push "<img src='" + res.data.preview.image_src + "' />"

					$("#form_media_url").val(res.data.preview.url)
					$("#form_media_url").attr("data-media", JSON.stringify(res.data.preview) )
					$("#media_upload_preview").empty().append(p.join "")

			$("#media_upload_preview h3").animate { top:"0px"}, 300, () -> 


$ ->

	# Circle Select 
	$(".switch_circle").on "click", switch_circle

	# Circle Toolip
	$(".circle-tooltop").popover()

	# Create User
	$("#action_signup").on "click", create_user

	# Update User
	$("#action_update_settings").on "click", update_user

	# Create Circle
	$("#action_create_circle").on "click", create_circle

	# Create Circle
	$("#action_update_circle").on "click", update_circle

	# Create Feed
	$(".create-feed #form_discussion").keyup (e) ->

		if e.keyCode is 13

			create_feed()

	# Create Feed via post
	$("#action_submit_feed").on "click", create_feed
		
	# ----------------------------------
	# UI Event - From Computer
	# ----------------------------------
	if $('#upload_btn').length > 0

		media_uploader()

	# ----------------------------------
	# UI Event -preview media
	# ----------------------------------
	$("#form_discussion").on "paste", preview_media

	# Auth User
	$("#action_signin").on "click", auth_user