<?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'db_connect.php';
    require_once 'signin_utils.php';

    // password_*() polyfill for PHP < 5.5.0
    if (!function_exists('password_hash')) {
      require '../lib/password.php';
    }

    // Clean up the data and establish a database connection
    $trimmed = array_map('trim', $_POST);
    $errors = array();
    $mysqli = MW_dbConnect();

    // Validate the email
    if (MW_validateEmail($trimmed['email'])) {
      $e = $mysqli->real_escape_string($trimmed['email']);

    } else {
      // The email is invalid
      $errors['email'] = true;
      $mysqli->close();
      unset($mysqli);
      return $errors;
      die();
    }

    // Check if the password has already been reset
    $q = "SELECT `activated` FROM users WHERE `email`='{$e}' LIMIT 1";
    $r = $mysqli->query($q);

    // Get the current action status
    if ($r->num_rows === 1) {
      // If the password has already been reset, do not reset it again
      if ($r->fetch_object()->activated === 'PW') {
        $mysqli->close();
        unset($mysqli);
        MW_redirectUser('index.php?pwreas=1');
        die();
      }
    }

    // Generate a new, temporary password 16 characters long
    $pwdLength = 16;
    $alphabet = '!@#$%&0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $newPwd = substr(str_shuffle(str_repeat($alphabet, $pwdLength)), 0, $pwdLength);
    $newPwdHash = password_hash($newPwd, PASSWORD_DEFAULT);

    // Mark the account as requiring a new password and set the temporary password
     $q = "UPDATE `users` SET `activated`='PW', `password`='{$newPwdHash}' WHERE `email`='{$e}' LIMIT 1";
     $mysqli->query($q);

    // An error occurred
    if ($mysqli->error || $mysqli->affected_rows !== 1) {
      $mysqli->close();
      unset($mysqli);
      MW_redirectUser('forgot-password.php?pwrerr=1');
      die();
    }

    // Shutdown the database connection
    $mysqli->close();
    unset($mysqli);

    // Send the reset email
    $emailDetails = array(
      'email' => $e,
      'action' => 'Password Reset',
      'body' => "<p>You have requested that your Model Worlds account password be reset.
      Therefore, we have reset your password to the following:</p>
      <p><strong>{$newPwd}</strong></p>
      <br><p>Upon login, you will be immediately required to change your password to continue using Model Worlds.</p>"
    );
    MW_sendEmail($emailDetails);
    MW_redirectUser('index.php?pwres=1');
  }
