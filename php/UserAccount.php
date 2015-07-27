<?php
  require_once 'db_connect.php';

  /**
   * @constructor
   * This creates a user account object containing the
   * necessary information to interact with the site.
   */
  class UserAccount {
    public $username;

    public function __construct($username) {
      $this->username = $username;
      $this->setLastSignIn();
    }

    /**
     * Update the database with time of user's last login.
     * @return boolean Always returns true.
     */
    private function setLastSignIn() {
      $mysqli = MW_dbConnect();
      $q = "UPDATE `users` SET `last_active`=NOW() WHERE `username`='{$this->username}' LIMIT 1";
      $mysqli->query($q);
      $mysqli->close();
      unset($mysqli);
      return true;
    }
  }
