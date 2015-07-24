<?php
  session_start();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'db_connect.php';
    require 'login_functions.php';

    // password_*() polyfill for PHP < 5.5.0
    if (!function_exists('password_hash')) {
      require '../lib/password.php';
    }

    $trimmed = array_map('trim', $_POST);
    $errors = $info = array();
    $mysqli = MW_dbConnect();

    // Validate the username
    if (MW_validateUsername($trimmed['username'])) {
      $info['username'] = $mysqli->real_escape_string($trimmed['username']);
    } else {
      $errors[] = 'That is not a valid username!';
    }

    // Validate the password
    if (MW_validatePassword($trimmed['password'])) {
    } else {
      $errors[] = 'That is not a valid password!';
    }

    // Persistent sign in option
    $stayLoggedIn = (bool) isset($trimmed['remember']) ? true : false;

    // An error occurred!
    if (!empty($errors)) {
      // TODO Display these on the page
      print_r($errors);
      return false;
    }

    // Execute the query
    $q = "SELECT `password` FROM `users` WHERE `username`='{$trimmed['username']}' LIMIT 1";
    $r = $mysqli->query($q);

    // Page redirection values
    $page = 'index.php';
    $query = '';

    if ($r->num_rows === 1) {
      // Login sucessful
      if (password_verify($trimmed['password'], $r->fetch_object()->password)) {
        $query = '?signin=1';
        MW_signIn($trimmed['username'], $stayLoggedIn);

      // Wrong password
      } else {
        // TODO Message
        $page = 'signin.php';
      }

      // Database error
    } else {
      // TODO Message
      $page = 'signin.php';
    }

    // Shutdown the DB connection and go back to the index
    $mysqli->close();
    unset($mysqli);
    MW_redirectUser($page . $query);
  }
