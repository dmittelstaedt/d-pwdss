<?php
$dbServer = "localhost";
$dbUsername = "root";
$dbPassword = "david";
$dbName = "pwssdb";
$mMessage = "";

function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

function selectUserAndPasswort($username, $password) {
  global $mMessage, $dbServer, $dbUsername, $dbPassword, $dbName;
  try {
    $conn = new PDO("mysql:host=$dbServer;dbname=$dbName", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $conn->prepare("select * from user where username='$username' and password='$password'");
    // $statement = $conn->prepare("select * from user where username='$username'");
    $statement->execute();
    // while ($row = $statement->fetch()) {
    //   $mMessage = $mMessage . $row['firstname'] . " " . $row['lastname'] . "<br>";
    // }
    $result = $statement->fetchAll();
    console_log($result);
    // $mMessage = count($result);
    return $statement->rowCount();
  }
  catch(PDOException $e)
  {
    return -99;
    // $mMessage = "Connection failed: " . $e->getMessage();
    // $mMessage = '<div class="col-sm-12">
    // <div class="alert alert-warning alert-dismissible fade show" role="alert">
    // <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    // <span aria-hidden="true">&times;</span>
    // </button>
    // <strong>Holy guacamole!</strong> You should check in on some of those fields below.
    // </div>
    // </div>';
  }
}

function readValues() {
  global $mMessage;
  $mMessage = $_POST["username"] . " " . $_POST["current_password"];
}

function checkCredentials() {
  global $mMessage;
  $username = $_POST["username"];
  $password = $_POST["current_password"];
  $clearPassword = "046c56f38f0930c852d273bb5e5963f6";
  $mystring = $username . ":test:" . $password;
  console_log($mystring);
  $hashedPassword = md5($username . ":test:" . $password);
  console_log($hashedPassword);
  console_log($clearPassword);
  // $clearPassword = str_replace(' ', '', $clearPassword);
  // console_log($hashedPassword);
  // var_dump($hashedPassword);
  // var_dump($clearPassword);
  // if ($hashedPassword == $clearPassword) {
  //   console_log("true");
  // } else {
  //   console_log("false");
  // }
  // console_log($username . " " . $hashedPassword);
  $mMessage = selectUserAndPasswort($username, $hashedPassword);
  // $mMessage = $hashedPassword;

}

if (isset($_POST["connect"])) {
  // selectUser();
  // readValues();
  checkCredentials();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
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
        <li class="nav-item">
          <a class="nav-link" href="change-password.php">Passwort Selfservice </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.html">Kontakt</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="#">MySQL <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="test-js.html">JS</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container" style="margin-top: 1em; margin-left: 6.8em">
    <?php echo "<p class='text-danger'>$mMessage</p>";?>
    <form method="post">
      <div class="form-group col-sm-6">
        <input type="text" class="form-control" name="username" id="username" placeholder="Benutzername">
      </div>
      <div class="form-group col-sm-6">
        <input type="password" class="form-control" name="current_password" id="current_password" placeholder="aktuelles Passwort">
      </div>
      <div class="col-sm-6">
        <button type="submit" name="connect" class="btn btn-default">User anzeigen</button>
      </div>
    </form>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/tether.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
