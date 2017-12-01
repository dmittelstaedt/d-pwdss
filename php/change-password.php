<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container">
  <h2>Passwort Selfservice für Fileshare Brandenburg</h2>
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
      <button type="submit" class="btn btn-default">Ändern</button>
      <button type="reset" class="btn btn-default">Löschen</button>
    </div>
  </form>
</div>

</body>
</html>
