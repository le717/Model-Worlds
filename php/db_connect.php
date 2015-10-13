<?php
  /**
   * Connect to the MySQL database.
   *
   * @return {MySQLi} Active database connection.
   */
  function MW_dbConnect() {
    $DB_USER     = '<YOUR USERNAME HERE>';
    $DB_PASSWORD = '<YOUR PASSWORD HERE>';
    $DB_HOST     = '<DATABASE ADDRESS HERE>';
    $DB_NAME     = 'ModelWorlds';

    $mysqli = new MySQLi($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    if ($mysqli->connect_error) {
      echo $mysqli->connect_error;
      unset($mysqli);
    } else {
      $mysqli->set_charset('utf8');
    }
    return $mysqli;
  }
