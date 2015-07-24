<?php
  /**
   * @constructor
   * This creates a user account object TODO write me!
   */
  class UserAccount {
    public $username;

    public function __construct($username) {
      $this->username = $username;
    }
  }

  function MW_redirectUser($page='index.php') {
    $url = '//' . $_SERVER['HTTP_HOST'] . '/worlds'; // . dirname($_SERVER['PHP_SELF']);
    $url = rtrim($url, '/\\');
    $url .= '/' . $page;
    header("Location: {$url}");
    exit();
  }

  /**
   * Determine if the user is signed in.
   * @return boolean true if signed in, false otherwise.
   */
  function MW_isSignedIn() {
    return (bool) isset($_SESSION['user']);
  }

  /**
   * Determine if the user requested persistent sign in.
   * @return boolean true if persistent, false otherwise.
   */
  function MW_isSignInPersist() {
    return (bool) isset($_COOKIE['MW_account']);
  }

  /**
   * Load persistent sign in details.
   * @return object UserAccount instance
   */
  function MW_loadSignInPersist() {
    return unserialize($_COOKIE['MW_account']);
  }

  /**
   * Sign in a user.
   *
   * A user is signed in by creating an instance of UserAccount
   * then storing it for the browser session and in a cookie
   * if the user requested persistent sign in.
   * If the user is already signed in, the existing instance is reused.
   *
   * @param string $username The user to sign in.
   * @param boolean $stayLoggedIn Should sign in be persistent?
   * @return boolean Always returns true.
   */
  function MW_signIn($username, $stayLoggedIn=false) {
    // Prevent creating a new instance on every page load
    if (MW_isSignedIn()) {
      return true;
    }

    $account = serialize(new UserAccount($username));
    $_SESSION['user'] = $account;

    // The user requested to remain signed in
    // The cookie will expire after 30 days
    if ($stayLoggedIn) {
      setcookie('MW_account', $account, (time() + 60 * 60 * 24 * 30),
                '/', '', false, true);
     }
    return true;
  }

  /**
   * Sign out a user.
   *
   * A user is signed out by unsetting the UserAccount
   * instance in the browser session and removing the
   * persistent sign cookie if present.
   */
  function MW_signOut() {
    unset($_SESSION['user']);

    // Persistent sign in
    if (MW_isSignInPersist()) {
      setcookie('MW_account', '', time() - 3600, '/', '', false, true);
    }
  }

  /**
   * Validate the entered username.
   * @param  string $username
   * @return boolean true if valid, false otherwise.
   */
  function MW_validateUsername($username) {
    return (bool) preg_match('/^[a-z0-9 \'.-]{2,25}$/i', $username);
  }

  /**
   * Validate the entered password.
   * @param  string $password
   * @return boolean true if valid, false otherwise.
   */
  function MW_validatePassword($password) {
    return (bool) preg_match('/^\w{4,25}$/', $password);
  }

  /**
   * Validate the entered email.
   * @param  string $email
   * @return boolean true if valid, false otherwise.
   */
  function MW_validateEmail($email) {
    return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
  }
