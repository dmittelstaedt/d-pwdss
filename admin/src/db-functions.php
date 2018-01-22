<?php
// Variables for the db connection from config file
$dbConfig = parse_ini_file("../conf/mysql.ini");
$dbServer = $dbConfig['server'];
$dbName = $dbConfig['dbname'];
$dbUsername = $dbConfig['username'];
$dbPassword = $dbConfig['password'];
$realm = $dbConfig['realm'];

// Variable for the user role
// TODO: add to statements and new role super admin
$role="app_user";

function selectUserLogin($username,$password) {
  global $dbServer, $dbUsername, $dbPassword, $dbName, $realm, $role;
  $passwordHashed = md5("$username:$realm:$password");
  try {
    $conn = new PDO("mysql:host=$dbServer;dbname=$dbName", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $conn->prepare("select username, role from user where username='$username' and password='$passwordHashed' limit 1");
    $statement->execute();
    $result = $statement->fetch();
    return $result;
  } catch (Exception $e) {
    // return -1;
    return $e->getMessage();
  }
}

function selectUsername() {
  global $dbServer, $dbUsername, $dbPassword, $dbName, $realm, $role;
  try {
    $conn = new PDO("mysql:host=$dbServer;dbname=$dbName", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $conn->prepare("select username from user where role = '$role' order by username");
    $statement->execute();
    $result = $statement->fetchAll();
    return $result;
  } catch (Exception $e) {
    return $e->getMessage();
  }
}

function selectUser($username) {
  global $dbServer, $dbUsername, $dbPassword, $dbName, $realm, $role;
  try {
    $conn = new PDO("mysql:host=$dbServer;dbname=$dbName", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $conn->prepare("select firstname, lastname, username, permission from user where username='$username' and role='$role' limit 1");
    $statement->execute();
    $result = $statement->fetch();
    return $result;
  } catch (Exception $e) {
    return $e->getMessage();
  }
}

function insertUser($firstName, $lastName, $username, $permission, $password) {
  global $dbServer, $dbUsername, $dbPassword, $dbName, $realm, $role;
  $passwordHashed = md5("$username:$realm:$password");
  try {
    $conn = new PDO("mysql:host=$dbServer;dbname=$dbName", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $conn->prepare("insert into user (firstname, lastname, username, realm, role, permission, password, last_change_password) VALUES ('$firstName', '$lastName', '$username', '$realm', '$role', '$permission', '$passwordHashed', NOW())");
    $statement->execute();
    $rc = $statement->rowCount();
    return $rc;
  } catch (Exception $e) {
    return -1;
  }
}

function updateUserWithoutPassword($firstName, $lastName, $username, $permission) {
  global $dbServer, $dbUsername, $dbPassword, $dbName, $realm;
  try {
    $conn = new PDO("mysql:host=$dbServer;dbname=$dbName", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $conn->prepare("update user set firstname='$firstName', lastname='$lastName', permission='$permission' where username='$username'");
    $statement->execute();
    $rc = $statement->rowCount();
    return $rc;
  } catch (Exception $e) {
    return $e->getMessage();
  }
}

function updateUserWithPassword($firstName, $lastName, $username, $permission, $password) {
  global $dbServer, $dbUsername, $dbPassword, $dbName, $realm;
  $passwordHashed = md5("$username:$realm:$password");
  try {
    $conn = new PDO("mysql:host=$dbServer;dbname=$dbName", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $conn->prepare("update user set firstname='$firstName', lastname='$lastName', permission='$permission', password='$passwordHashed', last_change_password=NOW() where username='$username'");
    $statement->execute();
    $rc = $statement->rowCount();
    return $rc;
  } catch (Exception $e) {
    return $e->getMessage();
  }
}

function deleteUser() {
// TODO:
}

function updatePassword($username, $currentPassword, $newPassword) {
  global $dbServer, $dbUsername, $dbPassword, $dbName, $realm;
  $currentPasswordHashed = md5("$username:$realm:$currentPassword");
  $newPasswordHashed = md5("$username:$realm:$newPassword");
  try {
    $conn = new PDO("mysql:host=$dbServer;dbname=$dbName", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $conn->prepare("update user set password='$newPasswordHashed' where username='$username' and password='$currentPasswordHashed'");
    $statement->execute();
    $rc = $statement->rowCount();
    if ($rc == 1) {
      $statementLastChange = $conn->prepare("update user set last_change_password=NOW() where username='$username'");
      $statementLastChange->execute();
    }
    return $rc;
  } catch (Exception $e) {
    return -1;
  }
}

?>
