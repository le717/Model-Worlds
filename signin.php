<?php
  $options = array('page_title' => 'Sign In');
  require 'php/loader.php';
  MW_setup();
  MW_openPage($options);

  MW_pageHeader('Sign In');
  MW_pageDesc('Sign into your Model Worlds account');
?>

<form id="form-signin" method="post" action="php/account_signin.php">
  <label><input type="text" name="username" placeholder="Username" tabindex="1" required></label>
  <label><input type="password" name="password" placeholder="Password" tabindex="2" required></label>
  <label><input type="checkbox" name="remember" tabindex="3"><!--checked-->&nbsp;Remember me
    <div>Not recommended on shared or public computers</div></label>
  <label><button type="submit" name="submit" tabindex="4">Login</button></label>
</form>

<p><a href="forgot-password.php">Forgot your password?</a></p>
<p><a href="signup.php">Don't have an account? Sign up!</a></p>
<?php MW_closePage(); ?>
