<?php
session_start();

if (!isset($_SESSION['isLoggedIn'])) {
  header("Location: login-warn.html");
  die();
}

if (isset($_SESSION['isLoggedIn']) && isset($_POST["logout"])) {
  session_destroy();
  header("Location: logout.html");
  die();
}

?>
<?php
if (isset($_SESSION['isLoggedIn'])) {
  // $_SESSION['lastActivity'] = time();
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
    <h3 style="color:#AD1E14; margin-bottom: 0.7em;">&Uuml;bersicht</h3>
    <div class="col-md-6 offset-md-3">
    <?php if (isset($_SESSION['userRole']) && strcmp($_SESSION['userRole'],"app_admin") == 0) {
    ?>
    <div class="card" style="margin-bottom: 0.7em;">
        <div class="card-header">
          Benutzer
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item text-center d-inline-block"><a href="add-user.php">Benutzer hinzuf&uuml;gen</a></li>
          <li class="list-group-item text-center d-inline-block"><a href="show-user.php">Benutzer anzeigen</a></li>
        </ul>
      </div>
      <?php
      }
      ?>
      <div class="card" style="margin-bottom: 0.7em;">
          <div class="card-header">
            Profil
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item text-center d-inline-block"><a href="change-password.php">Passwort &auml;ndern</a></li>
          </ul>
        </div>
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
