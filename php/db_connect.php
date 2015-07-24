<?php
  function MW_dbConnect() {
    $DB_USER     = 'root';
    $DB_PASSWORD = '';
    $DB_HOST     = '127.0.0.1';
    $DB_NAME     = 'model_worlds';

    $mysqli = new MySQLi($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    if ($mysqli->connect_error) {
      echo $mysqli->connect_error;
      unset($mysqli);
    } else {
      $mysqli->set_charset('utf8');
    }
    return $mysqli;
  }
