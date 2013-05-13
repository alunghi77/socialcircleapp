# Main app script

# ---------------------------
# Create user
# ---------------------------
create_user = () ->

	obj = {}
	obj["username"] = $("#create_account #form_username").val()
	obj["password"] = $("#create_account #form_password").val()
	obj["email"] 	= $("#create_account #form_email").val()

	$.post "/api/users", obj, (res,status)->

		if res.head.success

			console.log "success"

	.fail (xhr) ->
	
		res = JSON.parse xhr.responseText
		# handle errors	
		console.log res.head.description

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


$ ->

	# Create User
	$("#action_signup").on "click", create_user

	# Auth User
	$("#action_signin").on "click", auth_user