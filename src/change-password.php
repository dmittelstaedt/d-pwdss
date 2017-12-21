<?php

$dbConfig = parse_ini_file("../conf/mysql.ini");
$dbServer = $dbConfig['server'];
$dbName = $dbConfig['dbname'];
$dbUsername = $dbConfig['username'];
$dbPassword = $dbConfig['password'];

$realm = "test";

$errorMessageFields = "Es sind nicht alle Felder ausgef&uuml;llt.";
$errorMessagePasswords = "Passw&ouml;rter sind nicht identisch.";
$errorMessagePasswordRule = "Passwortrichtlinien sind nicht erf&uuml;llt.";
$errorMessageUsername = "Benutzername oder Passwort ist falsch.";
$errorMessageOther = "Es ist ein unerwarteter Fehler aufgetreten. Wenden Sie sich an Ihren Administrator.";

$errorMessageElemenet = "";

if (isset($_POST["change-password"])) {
  changePassword();
}

/**
* Main function of this site. Handles the logic for changing the password.
*/
function changePassword() {
  global $errorMessageFields, $errorMessageElemenet;

  $errorMessage = "";

  logConsole("Button change-password was pressed");
  $username = $_POST["username"];
  $currentPassword = $_POST["current-password"];
  $newPassword = $_POST["new-password"];
  $newPasswordRe = $_POST["new-password-re"];
  logConsole("Benutzername: $username");
  if (checkRequiredFields($username,$currentPassword,$newPassword,$newPasswordRe)) {
    if (comparePasswords($newPassword,$newPasswordRe)) {
      if (checkPasswordRules($newPassword)) {
        if (updatePassword($username,$currentPassword,$newPassword)) {
            // redirectToSuccess();
        }
      } else {
        # code...
      }

    } else {
      # code...
    }

  } else {
    $errorMessage = $errorMessageFields;
  }
  $errorMessageElemenet = "<div class=\"alert alert-danger col-sm-6\" role=\"alert\">$errorMessage</div>";
  return false;
}

/**
* Checks if given variables are empty.
* @param string $username unique name of the user
* @param string $currentPassword current password of the user
* @param string $newPassword new password of the user
* @param string $newPasswordRe confirmed new password of the user
*
* @return boolean true if all variables are not empty, otherwise false
*/
function checkRequiredFields($username, $currentPassword, $newPassword, $newPasswordRe) {
  if (!empty($username) && !empty($currentPassword) && !empty($newPassword) && !empty($newPasswordRe)) {
    logConsole("checkRequiredFields: true");
    return true;
  } else {
    logConsole("checkRequiredFields: false");
    return false;
  }
}

/**
*
*/
function checkPasswordRules($newPassword) {
  $uppercase = preg_match('@[A-Z]@', $newPassword);
  $lowercase = preg_match('@[a-z]@', $newPassword);
  $number = preg_match('@[0-9]@', $newPassword);
  $regexSpecialCharacter = preg_quote('.:,;-_!"$%&/()=?[]{}');
  $specialCharacters = preg_match('@[' . $regexSpecialCharacter . ']@', $newPassword);
  if ($uppercase && $lowercase && $number && $specialCharacters && strlen($newPassword) >= 8) {
    logConsole("checkPasswordRules: true");
    return true;
  } else {
    logConsole("checkPasswordRules: false");
    return false;
  }
}

/**
*
*/
function comparePasswords($newPassword,$newPasswordRe) {
  if (strcmp($newPassword,$newPasswordRe) == 0) {
    logConsole("comparePasswords: true");
    return true;
  } else {
    logConsole("comparePasswords: false");
    return false;
  }
}

/**
*
*/
function updatePassword($username, $currentPassword, $newPassword) {
    global $dbServer, $dbUsername, $dbPassword, $dbName, $realm;
    $currentPasswordHashed = md5("$username:$realm:$currentPassword");
    $newPasswordHashed = md5("$username:$realm:$newPassword");
    try {
      $conn = new PDO("mysql:host=$dbServer;dbname=$dbName", $dbUsername, $dbPassword);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // $statement = $conn->prepare("select * from user where username='$username' and password='$currentPasswordHashed'");
      $statement = $conn->prepare("update user set password='$newPasswordHashed' where username='$username' and password='$currentPasswordHashed'");
      $statement->execute();
      // $result = $statement->fetchAll();
      logConsole("updatePassword: " . $statement->rowCount());
      // logConsole($result);
      return $statement->rowCount();
    } catch (Exception $e) {
      logConsole($e->getMessage());
      return -1;
    }
}

/**
*
*/
function redirectToSuccess() {
  header("Location: success.html");
  die();
}

/**
* Writes output to console of the browser. Can be used for logging or debugging
* purpose. Turn it off in production mode.
*
* @param string data to write to console
*/
function logConsole( $data ) {
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/custom.css">
</head>
<body>

  <nav class="navbar navbar-toggleable-md navbar-inverse bg-faded" style="background-color: #74818b;">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
      <img src="res/dataport-neg.png" width="100" height="auto" alt="Dataport A&ouml;R">
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="change-password.php">Passwort ändern <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.html">Kontakt</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="test-mysql.php">MySQL</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="test-js.html">JS</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container" style="margin-top: 1em;">
    <h3 style="color:#AD1E14; margin-bottom: 0.7em;">Passwort ändern</h3>
    <?php echo $errorMessageElemenet;?>
    <form method="post">
      <div class="form-group col-sm-6">
        <input type="text" class="form-control" name="username" id="username" placeholder="Benutzername">
      </div>
      <div class="form-group col-sm-6">
        <input type="password" class="form-control" name="current-password" id="current-password" placeholder="aktuelles Passwort">
      </div>
      <div class="form-group col-sm-6">
        <input type="password" class="form-control" name="new-password" id="new-password" placeholder="neues Passwort">
      </div>
      <div class="form-group col-sm-6">
        <input type="password" class="form-control" name="new-password-re" id="new-password-re" placeholder="neues Passwort wiederholen">
      </div>
      <div class="col-sm-6">
        <button type="submit" name="change-password" class="btn btn-outline-primary">&Auml;ndern</button>
        <button type="reset" name="reset-input" class="btn btn-outline-primary">L&ouml;schen</button>
      </div>
    </form>
  </div>
  <script src="js/validation.js"></script>
  <script src="js/jquery.min.js"></script>
  <script src="js/tether.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
