/**
* Checks input of the fields of the form
* @return {bool} true, if all tests were successful, otherwise false
*/
function checkInput() {

  var element = document.getElementById("php-alert");
  if (element != null) {
    element.style.display = "none";
  }

  if (checkRequiredFields()) {
    if (comparePasswords()) {
      if (checkPasswordRules()) {
        console.log("Successful!");
        return true;
      } else {
        document.getElementById("js-alert").innerHTML = "JS: Passwortrichtlinien sind nicht erf&uuml;llt.";
      }
    } else {
      document.getElementById("js-alert").innerHTML = "JS: Passw&ouml;rter sind nicht identisch.";
    }
  } else {
    document.getElementById("js-alert").innerHTML = "JS: Es sind nicht alle Felder ausgef&uuml;llt.";
  }
  document.getElementById("js-alert").style.display = "block";
  document.getElementById("username").focus();
  return false;
}

/**
* Checks if all fields are set.
* @return {bool} true, if all fields are set, otherwise false
*/
function checkRequiredFields() {

  var username, currentPassword, passwordNew, passwordNewRe, message;

  username = document.forms["change-password-form"]["username"].value;
  currentPassword = document.forms["change-password-form"]["current-password"].value;
  passwordNew = document.forms["change-password-form"]["new-password"].value;
  passwordNewRe = document.forms["change-password-form"]["new-password-re"].value;
  if (username == "" || currentPassword == "" || passwordNew == "" || passwordNewRe == "") {
    return false;
  } else {
    return true;
  }
}

function comparePasswords() {

  var passwordNew, passwordNewRe, message;

  passwordNew = document.forms["change-password-form"]["new-password"].value;
  passwordNewRe = document.forms["change-password-form"]["new-password-re"].value;

  if (passwordNew == passwordNewRe) {
    return true;
  } else {
    return false;
  }
}

function checkPasswordRules() {

  var passwordRegex, passwordNew, message;

  passwordRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[.,\-_!@#\$%\^&\*])(?=.{8,})");
  passwordNew = document.forms["change-password-form"]["new-password"].value;

  if (passwordNew.match(passwordRegex)) {
    return true;
  } else {
    return false;
  }
}
