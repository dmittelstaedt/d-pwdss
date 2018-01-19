<?php
session_start();

include 'validation.php';

if (!isset($_SESSION['isLoggedIn'])) {
  header("Location: login-warn.html");
  die();
}

if (isset($_SESSION['isLoggedIn']) && isset($_POST["logout"])) {
  session_destroy();
  header("Location: logout.html");
  die();
}

// Variables for the db connection from config file
$dbConfig = parse_ini_file("../conf/mysql.ini");
$dbServer = $dbConfig['server'];
$dbName = $dbConfig['dbname'];
$dbUsername = $dbConfig['username'];
$dbPassword = $dbConfig['password'];
$realm = $dbConfig['realm'];

$errorMessage = "";
$errorMessageFields = "Es sind nicht alle Felder ausgef&uuml;llt.";
$errorMessagePasswords = "Passw&ouml;rter sind nicht identisch.";
$errorMessagePasswordRule = "Passwortrichtlinien sind nicht erf&uuml;llt.";
$errorMessageUserExists = "Der Benutzer existiert bereits.";
$errorMessageOther = "Es ist ein unerwarteter Fehler aufgetreten. Wenden Sie sich bitte an Ihren Administrator.";

if (isset($_POST["add-user"])) {
  // logConsole("Button was pressed");
  addUser();
}

function addUser() {
  global $errorMessage, $errorMessageFields, $errorMessagePasswords, $errorMessagePasswordRule, $errorMessageUserExists, $errorMessageOther, $errorMessageElemenet;

  $firstName = $_POST["first-name"];
  $lastName = $_POST["last-name"];
  $username = $_POST["username"];
  $newPassword = $_POST["new-password"];
  $newPasswordRe = $_POST["new-password-re"];

  if (isset($_POST['permission']) && checkRequiredFields([$firstName, $lastName, $username, $newPassword, $newPasswordRe])) {
    if (comparePasswords($newPassword,$newPasswordRe)) {
      if (checkPasswordRulesSimple($newPassword)) {
        # code...
      } else {
        $errorMessage = $errorMessagePasswordRule;
      }
    } else {
      $errorMessage = $errorMessagePasswords;
    }
  } else {
    $errorMessage = $errorMessageFields;
  }
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
<?php
if (isset($_SESSION['isLoggedIn'])) {
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
    <a class="navbar-brand" href="overview.php">
      <img src="res/dataport-neg.png" width="100" height="auto" alt="Dataport A&ouml;R">
    </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" style="border: 0px solid transparent;" type="button" id="dropdown-user-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Benutzer</button>
            <div class="dropdown-menu" aria-labelledby="dropdown-user-button">
              <a class="dropdown-item" href="add-user.php">Benutzer hinzuf&uuml;gen</a>
              <a class="dropdown-item" href="edit-user.php">Benutzer bearbeiten</a>
          </div>
        </li>
        <li class="nav-item">
          <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" style="border: 0px solid transparent;" type="button" id="dropdown-profile-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Profil</button>
            <div class="dropdown-menu" aria-labelledby="dropdown-profile-button">
              <a class="dropdown-item" href="change-password.php">Passwort &auml;ndern</a>
          </div>
        </li>
      </ul>
      <ul class="navbar-nav navbar-right">
      <form class="form-inline" name="login-form" id="logout-form" method="post">
        <button type="submit" name="logout" class="btn btn-outline-secondary" style="border: 0px solid transparent;">Abmelden</button>
      </form>
    </ul>
    </div>
  </nav>

  <!-- <div class="container col-md-8" style="margin-top: 1em; border: 1px solid black;"> -->
  <div class="container col-md-8 text-center" style="margin-top: 1em;">
    <h3 style="color:#AD1E14; margin-bottom: 0.7em;">Benutzer hinzuf&uuml;gen</h3>
    <?php
    if (!empty($errorMessage)) {
    ?>
    <div class="alert alert-danger col-md-6 offset-md-3" role="alert" name="js-alert" id="js-alert"><?php echo $errorMessage; ?></div>
    <?php
    }
    ?>
    <div class="alert alert-danger col-md-8" role="alert" name="js-alert" id="js-alert" style="display: none;"></div>
    <form name="change-password-form" id="change-password-form" method="post">
      <div class="form-group col-md-6 offset-md-3">
        <input type="text" class="form-control" name="first-name" id="first-name" placeholder="Vorname">
      </div>
      <div class="form-group col-md-6 offset-md-3">
        <input type="text" class="form-control" name="last-name" id="last-name" placeholder="Nachname">
      </div>
      <div class="form-group col-md-6 offset-md-3">
        <input type="text" class="form-control" name="username" id="username" placeholder="Benutzername">
      </div>
      <div class="form-group col-md-6 offset-md-3">
        <select class="custom-select form-control" name="permission" id="permission">
          <option value="permission-option" selected disabled hidden>Berechtigung</option>
          <option value="permission-read">Lesen</option>
          <option value="permission-read-write">Lesen/Schreiben</option>
        </select>
      </div>
      <div class="form-group col-md-6 offset-md-3">
        <input type="password" class="form-control" name="new-password" id="new-password" placeholder="neues Passwort">
      </div>
      <div class="form-group col-md-6 offset-md-3">
        <input type="password" class="form-control" name="new-password-re" id="new-password-re" placeholder="neues Passwort wiederholen">
      </div>
      <div class="col-md-6 offset-md-3">
        <button type="submit" name="add-user" class="btn btn-outline-primary">Absenden</button>
        <button type="reset" name="reset-input" class="btn btn-outline-primary" onclick="document.getElementById('username').focus(); return true;">L&ouml;schen</button>
      </div>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/tether.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
}
?>
