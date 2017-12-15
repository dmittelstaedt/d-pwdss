<?php
$servername = "localhost";
$username = "";
$password = "david";
$dbname = "pwssdb";
$mMessage = "";

function selectUser() {
  global $mMessage, $servername, $username, $password, $dbname;
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $conn->prepare("select * from user");
    $statement->execute();
    while ($row = $statement->fetch()) {
      $mMessage = $mMessage . $row['firstname'] . " " . $row['lastname'] . "<br>";
    }
    // $mMessage = $statement->rowCount();
  }
  catch(PDOException $e)
  {
    // $mMessage = "Connection failed: " . $e->getMessage();
    $mMessage = '<div class="col-sm-12">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        </div>
      </div>';
  }
}

if (isset($_POST["connect"])) {
  selectUser();
}
?>

<!DOCTYPE html>
<html>
<head>
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
          <a class="nav-link" href="test.php">Test <span class="sr-only">(current)</span></a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container" style="margin-top: 1em; margin-left: 6.8em">
    <div class="col-sm-6">
      <form method="post">
        <button type="submit" name="connect" class="btn btn-default">User anzeigen</button>
      </form>
    </div>
  </form>
  <?php echo "<p class='text-danger'>$mMessage</p>";?>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
