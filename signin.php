<?php
  $options = array('page_title' => 'Sign In');
  require 'php/page_load.php';
  MW_setup();
  MW_openPage($options);

  MW_pageHeader('Sign In');
  MW_pageDesc('Sign into your Model Worlds account');

  // Form submission
  // TODO Make fields sticky
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'php/account_signin.php';
  }
?>

<form id="form-signin" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
  <label>
    <span>Username</span>
    <?php if (isset($errors['username'])): ?><div class="input-error">That is not a valid username!</div><?php endif; ?>
    <input type="text" name="username" placeholder="Your username goes here" tabindex="1" required>
  </label>
  <label>
    <span>Password</span>
    <?php if (isset($errors['password'])): ?><div class="input-error">That is not a valid password!</div><?php endif; ?>
    <input type="password" name="password" placeholder="Your password goes here" tabindex="2" required>
  </label>
  <label>
    <span></span>
    <input type="checkbox" name="remember" tabindex="3"><!--checked-->&nbsp;Remember me
    <div>Not recommended on shared or public computers</div>
  </label>
  <label><button type="submit" name="submit" tabindex="4">Login</button></label>
</form>

<p><a href="forgot-password.php">Forgot your password?</a></p>
<p><a href="signup.php">Don't have an account? Sign up!</a></p>
<?php MW_closePage(); ?>
