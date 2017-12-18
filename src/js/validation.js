function checkInput() {

  if (checkRequiredFields()) {
    if (comparePasswords()) {
      if (checkPasswordRules()) {
        console.log("Successful!");
        return true;
      } else {
        document.getElementById("demo").innerHTML = "Passwort entspricht nicht den Regeln";
      }
    } else {
      document.getElementById("demo").innerHTML = "Passw&ouml;rter sind nicht identisch";
    }
  } else {
    document.getElementById("demo").innerHTML = "Bitte alle Felder ausf&uuml;llen";
  }
  return false;
}

function checkRequiredFields() {

  var username, passwordNew, passwordNewRe, message;

  username = document.forms["cpw-form"]["username"].value;
  passwordNew = document.forms["cpw-form"]["new_password"].value;
  passwordNewRe = document.forms["cpw-form"]["new_password_re"].value;
  if (username == "" || passwordNew == "" || passwordNewRe == "") {
    return false;
  } else {
    return true;
  }
}

function comparePasswords() {

  var passwordNew, passwordNewRe, message;

  passwordNew = document.forms["cpw-form"]["new_password"].value;
  passwordNewRe = document.forms["cpw-form"]["new_password_re"].value;

  if (passwordNew == passwordNewRe) {
    return true;
  } else {
    return false;
  }
}

function checkPasswordRules() {

  var passwordRegex, passwordNew, message;

  passwordRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[.,\-_!@#\$%\^&\*])(?=.{8,})");
  passwordNew = document.forms["cpw-form"]["new_password"].value;

  if (passwordNew.match(passwordRegex)) {
    return true;
  } else {
    return false;
  }
}
