<?php
  /**
   * Redirect the user to a page on the site.
   * @param string [$page='index.php'] Redirect destination.
   */
  function MW_redirectUser($page='index.php') {
    $url = '//' . $_SERVER['HTTP_HOST'] . '/worlds';
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
    return (bool) isset($_SESSION['MW_account']);
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
   * @return object UserAccount instance.
   */
  function MW_loadSignInPersist() {
    require_once 'UserAccount.php';
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

    require_once 'UserAccount.php';
    $account = serialize(new UserAccount($username));
    $_SESSION['MW_account'] = $account;

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
    require_once 'UserAccount.php';
    unserialize($_SESSION['MW_account'])->setLastSignIn();
    unset($_SESSION['MW_account']);

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

  /**
   * Populate the email template and send it.
   * @param  array.<String:email, String:action, String:body> $details
   *         Array containing necessary details to compose the email.
   * @return boolean Same return values as `mail()`.
   */
  function MW_sendEmail($details) {
    $mustache = MW__loadMustache();
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'To: ' . $details['email'] . "\r\n";
    $headers .= 'From: Model Worlds <noreply@modelworlds.net>' . "\r\n";
    $body = $mustache->loadTemplate('email')->render($details);
    return mail('', "Model Worlds - {$details['action']}", $body, $headers);
  }

  /**
   * Load the Mustache.php library for template rendering.
   * @return object
   */
  function MW__loadMustache() {
    // Only register Mustache if it has not been registered before
     if (!class_exists('Mustache_Autoloader') && !class_exists('Mustache_Engine')) {
        require "{$_SERVER['DOCUMENT_ROOT']}/worlds/lib/Mustache/Autoloader.php";
        Mustache_Autoloader::register();
    }

    // Load the template folder into Mustache
    $mustache = new Mustache_Engine(array(
       'loader' => new Mustache_Loader_FilesystemLoader(dirname(dirname(__FILE__)) . '/_includes/')
    ));
    return $mustache;
  }
