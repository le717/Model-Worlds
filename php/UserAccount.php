<?php
  /**
   * @constructor
   * This creates a user account object TODO write me!
   */
  class UserAccount {
    public $username;

    public function __construct($username) {
      $this->username = $username;
      $this->setLastSignIn();
    }

    private function setLastSignIn() {
      $mysqli = MW_dbConnect();
      $q = "UPDATE `users` SET `last_active`=NOW() WHERE `username`='{$this->username}' LIMIT 1";
      $mysqli->query($q);
      $mysqli->close();
      unset($mysqli);
    }
  }
