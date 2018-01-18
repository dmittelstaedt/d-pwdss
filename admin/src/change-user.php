<?php
session_start();

if (!isset($_SESSION['isLoggedIn'])) {
  header("Location: login-warn.html");
  die();
}

if (isset($_SESSION['isLoggedIn']) && isset($_SESSION['lastActivity']) && (time() - $_SESSION['lastActivity'] > 5)) {
  $myTime = time();
  logConsole($_SESSION['lastActivity']);
  logConsole($myTime);
  session_destroy();
  header("Location: logout.html");
  die();
}

if (isset($_POST["logout"])) {
  logConsole("Button was pressed");
  if (isset($_SESSION['isLoggedIn'])) {
    session_destroy();
    header("Location: logout.html");
    die();
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
  $_SESSION['lastActivity'] = time();
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
        <li class="nav-item">
          <a class="nav-link" href="#">Benutzer</a>
        </li>
      </ul>
      <ul class="navbar-nav navbar-right">
      <form class="form-inline" name="login-form" id="logout-form" method="post">
        <button type="submit" name="logout" class="btn btn-outline-secondary">Abmelden</button>
      </form>
    </ul>
    </div>
  </nav>

  <!-- <div class="container col-md-8" style="margin-top: 1em; border: 1px solid black;"> -->
  <div class="container col-md-8 text-center" style="margin-top: 1em;">
    <h3 style="color:#AD1E14; margin-bottom: 0.7em;">Passwort Self-Service Admin</h3>
    <div class="col-md-6 offset-md-3">
    <div class="card" style="margin-bottom: 0.7em;">
        <div class="card-header">
          Benutzer
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item text-center d-inline-block"><a href="#">Benutzer hinzuf&uuml;gen</a></li>
          <li class="list-group-item text-center d-inline-block"><a href="#">Benutzer bearbeiten</a></li>
        </ul>
      </div>
    </div>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/tether.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>"
<?php
}
?>
