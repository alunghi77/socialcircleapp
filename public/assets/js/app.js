// Generated by CoffeeScript 1.3.3
(function() {
  var auth_user, create_user;

  create_user = function() {
    var obj;
    obj = {};
    obj["username"] = $("#create_account #form_username").val();
    obj["password"] = $("#create_account #form_password").val();
    obj["email"] = $("#create_account #form_email").val();
    $.post("/api/users", obj, function(res, status) {
      if (res.head.success) {
        return console.log("success");
      }
    }).fail(function(xhr) {
      var res;
      res = JSON.parse(xhr.responseText);
      return console.log(res.head.description);
    });
    return false;
  };

  auth_user = function() {
    var obj;
    obj = {};
    obj["username"] = $("#login_user #form_username").val();
    obj["password"] = $("#login_user #form_password").val();
    $.post("/api/users/auth", obj, function(res, status) {
      if (res.head.success) {
        return window.location.href = '/';
      }
    }).fail(function(xhr) {
      var res;
      res = JSON.parse(xhr.responseText);
      return console.log(res.head.description);
    });
    return false;
  };

  $(function() {
    $("#action_signup").on("click", create_user);
    return $("#action_signin").on("click", auth_user);
  });

}).call(this);
