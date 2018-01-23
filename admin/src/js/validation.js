$(function(){
  $("[data-hide]").on("click", function(){
    $("." + $(this).attr("data-hide")).hide();
  });
});

/**
* Checks input of the fields of the form
* @return {bool} true, if all tests were successful, otherwise false
*/
function checkInputLogin() {

  var element = document.getElementById("php-alert");
  if (element != null) {
    element.style.display = "none";
  }

  var username = document.forms["login-form"]["username"].value;
  var currentPassword = document.forms["login-form"]["password"].value;

  if (checkRequiredFields([username, currentPassword])) {
    return true;
  } else {
    document.getElementById("js-alert").style.display = "block";
    document.getElementById("js-alert-message").innerHTML = "Es sind nicht alle Felder ausgef&uuml;llt.";
    document.getElementById("username").focus();
  }
  return false;
}

/**
* Checks input of the fields of the form
* @return {bool} true, if all tests were successful, otherwise false
*/
function checkInputChangePassword() {

  var element = document.getElementById("php-alert");
  if (element != null) {
    element.style.display = "none";
  }

  var currentPassword = document.forms["change-password-form"]["current-password"].value;
  var newPassword = document.forms["change-password-form"]["new-password"].value;
  var newPasswordRe = document.forms["change-password-form"]["new-password-re"].value;

  if (checkRequiredFields([currentPassword, newPassword, newPasswordRe])) {
    if (comparePasswords(newPassword, newPasswordRe)) {
      if (checkPasswordRules(currentPassword, newPassword)) {
        return true;
      } else {
        document.getElementById("js-alert-message").innerHTML = "Passwortrichtlinien sind nicht erf&uuml;llt.";
      }
    } else {
      document.getElementById("js-alert-message").innerHTML = "Passw&ouml;rter sind nicht identisch.";
    }
  } else {
    document.getElementById("js-alert-message").innerHTML = "Es sind nicht alle Felder ausgef&uuml;llt.";
  }
  document.getElementById("js-alert").style.display = "block";
  document.getElementById("current-password").focus();
  return false;
}

/**
* Checks input of the fields of the form
* @return {bool} true, if all tests were successful, otherwise false
*/
function checkInput() {

  var element = document.getElementById("php-alert");
  if (element != null) {
    element.style.display = "none";
  }

  var username, currentPassword, passwordNew, passwordNewRe;
  username = document.forms["change-password-form"]["username"].value;
  currentPassword = document.forms["change-password-form"]["current-password"].value;
  passwordNew = document.forms["change-password-form"]["new-password"].value;
  passwordNewRe = document.forms["change-password-form"]["new-password-re"].value;

  if (checkRequiredFields(username, currentPassword, passwordNew, passwordNewRe)) {
    if (comparePasswords(passwordNew, passwordNewRe)) {
      if (checkPasswordRules(currentPassword, passwordNew)) {
        return true;
      } else {
        document.getElementById("js-alert").innerHTML = "Passwortrichtlinien sind nicht erf&uuml;llt.";
      }
    } else {
      document.getElementById("js-alert").innerHTML = "Passw&ouml;rter sind nicht identisch.";
    }
  } else {
    document.getElementById("js-alert").innerHTML = "Es sind nicht alle Felder ausgef&uuml;llt.";
  }
  document.getElementById("js-alert").style.display = "block";
  document.getElementById("username").focus();
  return false;
}

/**
* Checks if all fields are set.
* @return {bool} true, if all fields are set, otherwise false
*/
function checkRequiredFields(fields) {
  for (var i = 0; i < fields.length; i++) {
    if(!fields[i]) {
      return false;
    }
  }
  return true;
}

function comparePasswords(passwordNew, passwordNewRe) {

  if (passwordNew == passwordNewRe) {
    return true;
  } else {
    return false;
  }
}

function checkPasswordRules(currentPassword, passwordNew) {

  var passwordRegex;

  passwordRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[.,\-_!@#\$%\^&\*])(?=.{8,})");

  if (passwordNew.match(passwordRegex) && currentPassword != passwordNew) {
    return true;
  } else {
    return false;
  }
}
