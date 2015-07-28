<?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'db_connect.php';
    require_once 'common_utils.php';

    // password_*() polyfill for PHP < 5.5.0
    if (!function_exists('password_hash')) {
      require '../lib/password.php';
    }

    // Clean up the data and establish a database connection
    $trimmed = array_map('trim', $_POST);
    $errors = $info = array();
    $mysqli = MW_dbConnect();

    // Validate the username
    if (MW_validateUsername($trimmed['username'])) {
      $info['username'] = $mysqli->real_escape_string($trimmed['username']);
    } else {
      $errors['username'] = 'That is not a valid username!';
    }

    // Validate the password
    if (MW_validatePassword($trimmed['password'])) {
    } else {
      $errors['password'] = 'That is not a valid password!';
    }

    // Persistent sign in option
    $stayLoggedIn = (bool) isset($trimmed['remember']) ? true : false;

    // One or more validation errors occurred
    if (!empty($errors)) {
      $mysqli->close();
      unset($mysqli);
      return $errors;
      die();
    }

    // TODO Force immediate password change if account status is 'PW'

    // Execute a query to retrieve the stored password
    $q = 'SELECT `password`, `activated` FROM `users` WHERE `username`=? LIMIT 1';
    $stmt = $mysqli->prepare($q);
    $stmt->bind_param('s', $info['username']);
    $stmt->execute();
    $stmt->bind_result($dbPass, $dbAcivated);
    $stmt->fetch();

    // Page redirection values
    $page = 'index.php';
    $query = '';

    if ($stmt->errno === 0) {
      // Login sucessful
      if (password_verify($trimmed['password'], $dbPass)) {
        $query = '?signin=1';
        MW_signIn($trimmed['username'], $stayLoggedIn);

      // Wrong password
      } else {
        $page = 'signin.php?signinerr=1';
      }

      // Some database error occurred
    } else {
      $page = 'signin.php?signinerr=1';
    }

    // Shutdown the DB connection and go back to the index
    $mysqli->close();
    unset($mysqli);
    MW_redirectUser($page . $query);
  }
