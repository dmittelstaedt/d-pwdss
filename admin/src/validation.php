<?php
/**
* Checks if given variables are empty.
* @param array $inputFields all values which are checked
*
* @return boolean true if all variables are not empty, otherwise false
*/
function checkRequiredFields($inputFields) {
  return !in_array("",$inputFields);
}

/**
*
* @param string $password new password of the user
*
* @return boolean true if password rules are fullfilled, otherwise false
*/
function checkPasswordRulesSimple($password) {
  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $number = preg_match('@[0-9]@', $password);
  $regexSpecialCharacter = preg_quote('.:,;-_!"$%&/()=?[]{}');
  $specialCharacters = preg_match('@[' . $regexSpecialCharacter . ']@', $password);
  if ($password && $uppercase && $lowercase && $number && $specialCharacters && strlen($password) >= 8) {
    return true;
  } else {
    return false;
  }
}

/**
*
* @param string $newPassword new password of the user
* @param string $newPasswordRe confirmed new password of the user
*
* @return boolean true if password rules are fullfilled, otherwise false
*/
function checkPasswordRules($currentPassword, $newPassword) {
  $uppercase = preg_match('@[A-Z]@', $newPassword);
  $lowercase = preg_match('@[a-z]@', $newPassword);
  $number = preg_match('@[0-9]@', $newPassword);
  $regexSpecialCharacter = preg_quote('.:,;-_!"$%&/()=?[]{}');
  $specialCharacters = preg_match('@[' . $regexSpecialCharacter . ']@', $newPassword);
  if ($currentPassword != $newPassword && $uppercase && $lowercase && $number && $specialCharacters && strlen($newPassword) >= 8) {
    return true;
  } else {
    return false;
  }
}

/**
*
* @param string $newPassword new password of the user
* @param string $newPasswordRe confirmed new password of the user
*
* @return boolean true if passwords are equal, otherwise false
*/
function comparePasswords($newPassword,$newPasswordRe) {
  if (strcmp($newPassword,$newPasswordRe) == 0) {
    return true;
  } else {
    return false;
  }
}
?>
