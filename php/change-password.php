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
        <li class="nav-item active">
          <a class="nav-link" href="#">Passwort Selfservice <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Kontakt</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container" style="margin-top: 1em; margin-left: 6.8em">
    <div class="container" style="margin-bottom: 1em;">
      <h2 style="color:#AD1E14;">Passwort Selfservice</h2>
    </div>
    <form>
      <div class="form-group col-sm-6">
        <label for="username">Benutzername:</label>
        <input type="text" class="form-control" id="username" placeholder="Benutzername">
      </div>
      <div class="form-group col-sm-6">
        <label for="current_password">aktuelles Passwort:</label>
        <input type="password" class="form-control" id="current_password" placeholder="aktuelles Passwort">
      </div>
      <div class="form-group col-sm-6">
        <label for="new_password">neues Passwort:</label>
        <input type="password" class="form-control" id="new_password" placeholder="neues Passwort">
      </div>
      <div class="form-group col-sm-6">
        <label for="new_password_re">neues Passwort wiederholen:</label>
        <input type="password" class="form-control" id="new_password_re" placeholder="neues Passwort wiederholen">
      </div>
      <!-- <div class="checkbox">
      <label><input type="checkbox"> Remember me</label>
    </div> -->
    <div class="col-sm-6">
      <button type="submit" class="btn btn-default">&Auml;ndern</button>
      <button type="reset" class="btn btn-default">L&ouml;schen</button>
    </div>
  </form>
</div>

</body>
</html>
