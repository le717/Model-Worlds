<?php
  function sendActivateEmail($email) {
    $code = md5(uniqid(rand(), true));
    $confirmLink = "http://{$_SERVER['HTTP_HOST']}/worlds/activate.php?x=" . urlencode($email) . "&y={$code}";
    $body = '<h1>Model Worlds Registration</h1>';
    $body .= '<p>Thank you for registering for <a href="http://modelworlds.net">Model Worlds</a>!
    To activate your account and begin uploading your creations, please click on the following link or paste it into your browser.</p>';
    $body .= "<p><a href=\"{$confirmLink}\">$confirmLink</a></p>";
    $body .= '<p>Thank you for showing your support for Model Worlds!</p><h2>~~ The Model Worlds Staff ~~</h2>';

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'To: ' . $email . "\r\n";
    $headers .= 'From: Model Worlds <noreply@modelworlds.net>' . "\r\n";

    mail('', 'Model Worlds - Confirm Registration', $body, $headers);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    require 'db_connect.php';
    require 'login_functions.php';

    // password_*() polyfill for PHP < 5.5.0
    if (!function_exists('password_hash')) {
      require '../lib/password.php';
    }

    $trimmed = array_map('trim', $_POST);
    $errors = $info = array();

    // Bot check :)
    if (isset($trimmed['bot'])) {
      unset($mysqli);
      MW_redirectUser('robots.php');
      die();
    }

    // Validate the username
    if (MW_validateUsername($trimmed['username'])) {
      $info['username'] = $mysqli->real_escape_string($trimmed['username']);
    } else {
      $errors[] = 'That is not a valid username!';
    }

    // Validate the email
    if (MW_validateEmail($trimmed['email']) {
      $info['email'] = $mysqli->real_escape_string($trimmed['email']);
    } else {
      $errors[] = 'That is not a valid email!';
    }

    // Validate the password
    if (MW_validatePassword($trimmed['password-1'])) {
      if ($trimmed['password-1'] === $trimmed['password-2']) {
        $info['password'] = password_hash($mysqli->real_escape_string($trimmed['password-1']), PASSWORD_DEFAULT);
      } else {
        $errors[] = 'The passwords do not match!';
      }

      // Invalid password
    } else {
      $errors[] = 'That is not a valid password!';
    }

    // An error occurred!
    if (!empty($errors) || !$info['password']) {
      // TODO Display these on the page
      print_r($errors);
      return false;
    }

    // Execute the query
    $q = 'INSERT INTO `users` (`email`, `username`, `password`) VALUES (?, ?, ?)';
    $stmt = $mysqli->prepare($q);
    $stmt->bind_param('sss', $info['email'], $info['username'], $info['password']);
    $stmt->execute();

    // An error occurred
    if ($stmt->affected_rows !== 1) {
      $errors[] = 'Your registraion could not be processed. Please contact the administrator about this problem';
      print_r($errors);
    }

    // Shutdown the DB connection
    $stmt->close();
    $mysqli->close();
    unset($stmt);
    unset($mysqli);

    // Send the activation email, auto-login,
    // and go back to the index
    sendActivateEmail($trimmed['email']);
    MW_signIn($info['username']);
    MW_redirectUser('index.php?actiemail=1');
  }
