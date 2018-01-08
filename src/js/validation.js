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
        console.log("Successful!");
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
function checkRequiredFields(username, currentPassword, passwordNew, passwordNewRe) {

  if (username == "" || currentPassword == "" || passwordNew == "" || passwordNewRe == "") {
    return false;
  } else {
    return true;
  }
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
