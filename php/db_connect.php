<?php
  if ($_SERVER['HTTP_HOST'] === '') {
  DEFINE('DB_USER', '');
  DEFINE('DB_PASSWORD', '');
  DEFINE('DB_HOST', 'localhost');
  DEFINE('DB_NAME', '');
  } else {
    DEFINE('DB_USER', 'root');
    DEFINE('DB_PASSWORD', '');
    DEFINE('DB_HOST', '127.0.0.1');
    DEFINE('DB_NAME', 'model_worlds');
  }

  $mysqli = new MySQLi(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    unset($mysqli);
  } else {
    $mysqli->set_charset('utf8');
  }
