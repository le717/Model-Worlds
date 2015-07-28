<?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'db_connect.php';
    require_once 'common_utils.php';

    // password_*() polyfill for PHP < 5.5.0
    if (!function_exists('password_hash')) {
      require_once '../lib/password.php';
    }

    // Clean up the data and establish a database connection
    $trimmed = array_map('trim', $_POST);
    $errors = $info = array();
    $mysqli = MW_dbConnect();

    // Bot check :)
    if (isset($trimmed['bot'])) {
      $mysqli->close();
      unset($mysqli);
      MW_redirectUser('robots.php');
      die();
    }

    // Validate the email
    if (MW_validateEmail($trimmed['email'])) {
      $info['email'] = $mysqli->real_escape_string($trimmed['email']);
    } else {
      $errors['email'] = true;
    }

    // Validate the username
    if (MW_validateUsername($trimmed['username'])) {
      $info['username'] = $mysqli->real_escape_string($trimmed['username']);
    } else {
      $errors['username'] = true;
    }

    // Validate the password
    if (MW_validatePassword($trimmed['password-1'])) {
      if ($trimmed['password-1'] === $trimmed['password-2']) {
        $info['password'] = password_hash($mysqli->real_escape_string($trimmed['password-1']), PASSWORD_DEFAULT);
      } else {
        $errors['pwMatch'] = true;
      }

      // Invalid password
    } else {
      $errors['pwValid'] = true;
    }

    // One or more validation errors occurred
    if (!empty($errors)) {
      $mysqli->close();
      unset($mysqli);
      return $errors;
      die();
    }

    // Execute the query
    $q = 'INSERT INTO `users` (`email`, `username`, `password`) VALUES (?, ?, ?)';
    $stmt = $mysqli->prepare($q);
    $stmt->bind_param('sss', $info['email'], $info['username'], $info['password']);
    $stmt->execute();

    // An error occurred in attempting to record the account
    if ($mysqli->error || $stmt->affected_rows !== 1) {
      $stmt->close();
      $mysqli->close();
      unset($stmt);
      unset($mysqli);
      MW_redirectUser('forgot-password.php?signuperr=1');
      die();
    }

    // Shutdown the database connection
    $stmt->close();
    $mysqli->close();
    unset($stmt);
    unset($mysqli);

    // Send the activation email
    $actiLink = "http://{$_SERVER['HTTP_HOST']}/worlds/activate.php?x=" .
                 urlencode($trimmed['email']) . "&y=" . md5(uniqid(mt_rand(), true));
    $emailDetails = array(
      'email' => $trimmed['email'],
      'action' => 'Registration',
      'body' => "<p>Thank you for registering for <a href='http://modelworlds.net'>Model Worlds</a>!\n
      To activate your account and begin uploading your creations, please click on the following link or paste it into your browser.</p>\n
      <p><a href='{$actiLink}'>$actiLink</a></p>\n
      "
    );
    MW_sendEmail($emailDetails);

    // Auto-login the user and go back to the index
    MW_signIn($info['username']);
    MW_redirectUser('index.php?actiemail=1');
    die();
  }
