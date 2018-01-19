<?php
session_start();

$dbConfig = parse_ini_file("../conf/mysql.ini");
$dbServer = $dbConfig['server'];
$dbName = $dbConfig['dbname'];
$dbUsername = $dbConfig['username'];
$dbPassword = $dbConfig['password'];
$realm = $dbConfig['realm'];

$userRole = "app_admin";

$errorMessage = "Benutzername oder Passwort ist falsch.";

$errorMessageElemenet = "";

if (isset($_POST["login"])) {
  loginUser();
  $_SESSION['isLoggedIn'] = true;
  header("Location: overview.php");
  die();
}

function loginUser() {
  global $dbServer, $dbUsername, $dbPassword, $dbName, $realm, $userRole, $errorMessage, $errorMessageElemenet;

  $username = $_POST["username"];
  $password = $_POST["password"];

  $passwordHashed = md5("$username:$realm:$password");
  logConsole($passwordHashed);
  try {
    $conn = new PDO("mysql:host=$dbServer;dbname=$dbName", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $conn->prepare("select user_id from user where username='$username' and password='$passwordHashed' and role='$userRole'");
    $statement->execute();
    $result = $statement->fetchAll();
    logConsole($result);
    if (count($result) == 1) {
      $errorMessage = "Login erfolgreich!";
    }
    // return $rc;
  } catch (Exception $e) {
    logConsole("Exception: " . $e->getMessage());
    // return -1;
  }

  $errorMessageElemenet = "<div class=\"alert alert-danger col-md-4 offset-md-4\" name=\"php-alert\" id=\"php-alert\" role=\"alert\">$errorMessage</div>";
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
    <?php echo $errorMessageElemenet;?>
    <form name="login-form" id="login-form" method="post">
      <div class="form-group col-md-4 offset-md-4">
        <input type="text" class="form-control" name="username" id="username" placeholder="Benutzername">
      </div>
      <div class="form-group col-md-4 offset-md-4">
        <input type="password" class="form-control" name="password" id="password" placeholder="Passwort">
      </div>
      <div class="col-md-4 offset-md-4">
        <button type="submit" name="login" class="btn btn-outline-primary">Anmelden</button>
      </div>
    </form>
    <p class="small" style="margin-top: 2.5em;">Version 0.0.1</p>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/tether.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
