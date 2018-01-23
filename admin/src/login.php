<?php
session_start();

include 'validation.php';
include 'db-functions.php';

if (isset($_SESSION['isLoggedIn'])) {
  header("Location: overview.php");
  die();
}

if (isset($_POST["login"])) {
  if (checkRequiredFields([$_POST["username"],$_POST["password"]])) {
    $users = selectUserLogin($_POST["username"],$_POST["password"]);

    switch (count($users)) {
      case 0:
        $errorMessage = "Benutzername oder Passwort ist falsch.";
        $isFalseLogin = true;
        break;
      case 1:
        $_SESSION['isLoggedIn'] = true;
        foreach ($users as $user) {
          $_SESSION['loggedUser'] = $user['username'];
          $_SESSION['userRole'] = $user['role'];
        }
        header("Location: overview.php");
        die();
        break;
      default:
        $errorMessage = "Es ist ein unerwarteter Fehler aufgetreten. Wenden Sie sich bitte an Ihren Administrator.";
        $isFalseLogin = true;
        break;
    }
  } else {
    $isFalseLogin = true;
    $errorMessage = "Es sind nicht alle Felder ausgef&uuml;llt.";
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
    <a class="navbar-brand" href="index.html">
      <img src="res/dataport-neg.png" width="100" height="auto" alt="Dataport A&ouml;R">
    </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
      </ul>
    </div>
  </nav>

  <!-- <div class="container col-md-8" style="margin-top: 1em; border: 1px solid black;"> -->
  <div class="container col-md-8 text-center" style="margin-top: 1em;">
    <h3 style="color:#AD1E14; margin-bottom: 0.7em;">Passwort Self-Service Admin</h3>
    <div class="alert alert-danger col-md-4 offset-md-4 alert-dismissible fade show" role="alert" name="js-alert" id="js-alert" style="display: none;">
      <button type="button" class="close" data-hide="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <a name="js-alert-message" id="js-alert-message"></a>
    </div>
    <?php if (isset($isFalseLogin)) {
    ?>
    <div class="alert alert-danger col-md-4 offset-md-4 alert-dismissible fade show" role="alert" name="php-alert" id="php-alert" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <?php echo $errorMessage ?>
    </div>
    <?php
    }
    ?>
    <form name="login-form" id="login-form" method="post">
      <div class="form-group col-md-4 offset-md-4">
        <input type="text" class="form-control" name="username" id="username" placeholder="Benutzername">
      </div>
      <div class="form-group col-md-4 offset-md-4">
        <input type="password" class="form-control" name="password" id="password" placeholder="Passwort">
      </div>
      <div class="col-md-4 offset-md-4">
        <button type="submit" name="login" class="btn btn-outline-primary" onclick="return checkInputLogin()">Anmelden</button>
      </div>
    </form>
    <p class="small" style="margin-top: 2.5em;">Version 0.0.1</p>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/tether.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/validation.js"></script>
</body>
</html>
