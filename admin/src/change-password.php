<?php
session_start();

include 'validation.php';
include 'db-functions.php';

if (!isset($_SESSION['isLoggedIn'])) {
  header("Location: login-warn.html");
  die();
}

if (isset($_SESSION['isLoggedIn']) && isset($_POST["logout"])) {
  session_destroy();
  header("Location: logout.html");
  die();
}

if (isset($_POST['change-password'])) {
  $username = $_SESSION['loggedUser'];
  $currentPassword = $_POST["current-password"];
  $newPassword = $_POST["new-password"];
  $newPasswordRe = $_POST["new-password-re"];
  if (checkRequiredFields([$currentPassword, $newPassword, $newPasswordRe])) {
    if (comparePasswords($newPassword, $newPasswordRe)) {
      if (checkPasswordRules($currentPassword, $newPassword)) {
        $rcUpdatePassword = updatePassword($username, $currentPassword, $newPassword);
        switch ($rcUpdatePassword) {
          case '0':
            $errorMessage = "Passwort ist falsch.";
            $isChanged = false;
            break;
          case '1':
            $errorMessage = "Passwort wurde erfolgreich ge&auml;ndert";
            $isChanged = true;
            break;
          default:
            $errorMessage = "Es ist ein unerwarteter Fehler aufgetreten. Wenden Sie sich bitte an Ihren Administrator.";
            $isChanged = false;
            break;
        }
      } else {
        $errorMessage = "Passwortrichtlinien sind nicht erf&uuml;llt.";
        $isChanged = false;
      }

    } else {
      $errorMessage = "Passw&ouml;rter sind nicht identisch.";
      $isChanged = false;
    }
  } else {
    $errorMessage = "Es sind nicht alle Felder ausgef&uuml;llt.";
    $isChanged = false;
  }
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
        <?php if (isset($_SESSION['userRole']) && strcmp($_SESSION['userRole'],"app_admin") == 0) {
          ?>
          <li class="nav-item">
            <div class="dropdown">
              <button class="btn btn-outline-secondary dropdown-toggle" style="border: 0px solid transparent;" type="button" id="dropdown-user-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Benutzer</button>
              <div class="dropdown-menu" aria-labelledby="dropdown-user-button">
                <a class="dropdown-item" href="add-user.php">Benutzer hinzuf&uuml;gen</a>
                <a class="dropdown-item" href="show-user.php">Benutzer anzeigen</a>
              </div>
            </li>
            <?php
          }
          ?>
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
    <h3 style="color:#AD1E14; margin-bottom: 0.7em;">Passwort &auml;ndern</h3>
    <div class="alert alert-danger col-md-6 offset-md-3 alert-dismissible fade show" role="alert" name="js-alert" id="js-alert" style="display: none;">
      <button type="button" class="close" data-hide="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <a name="js-alert-message" id="js-alert-message"></a>
    </div>
    <?php if (isset($isChanged) && !$isChanged) {
    ?>
    <div class="alert alert-danger col-md-6 offset-md-3 alert-dismissible fade show" role="alert" name="php-alert" id="php-alert" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <?php echo $errorMessage ?>
    </div>
    <?php
    }
    ?>
    <?php if (isset($isChanged) && $isChanged) {
    ?>
    <div class="alert alert-success col-md-6 offset-md-3 alert-dismissible fade show" role="alert" name="php-alert" id="php-alert" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <?php echo $errorMessage ?>
    </div>
    <?php
    }
    ?>
    <form name="change-password-form" id="change-password-form" method="post">
      <div class="form-group col-md-6 offset-md-3">
        <input type="password" class="form-control" name="current-password" id="current-password" placeholder="aktuelles Passwort">
      </div>
      <div class="form-group col-md-6 offset-md-3">
        <input type="password" class="form-control" name="new-password" id="new-password" placeholder="neues Passwort">
      </div>
      <div class="form-group col-md-6 offset-md-3">
        <input type="password" class="form-control" name="new-password-re" id="new-password-re" placeholder="neues Passwort wiederholen">
      </div>
      <div class="col-md-6 offset-md-3">
        <button type="submit" name="change-password" class="btn btn-outline-primary" onclick="return checkInputChangePassword()">Absenden</button>
        <button type="reset" name="reset-input" class="btn btn-outline-primary" onclick="document.getElementById('username').focus(); return true;">L&ouml;schen</button>
      </div>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/tether.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/custom-jquery.js"></script>
  <script src="js/validation.js"></script>
</body>
</html>
<?php
}
?>
