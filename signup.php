<?php
  $options = array('page_title' => 'Register');
  require 'php/page_load.php';
  MW_setup();
  MW_openPage($options);

  MW_pageHeader('Registration');
  MW_pageDesc('Create a free account to upload to Model Worlds!');
?>

<p>All fields are required to register! We promise to never use your email for anything.</p>
<form id="form-register" method="post" action="php/account_create.php">
  <label>
    <span>Email</span>
    <input type="email" name="email" placeholder="Your email address goes here" tabindex="1" required>
  </label>
  <label>
    <span>Username</span>
    <input type="text" name="username" placeholder="Your username goes here" tabindex="2" required>
  </label>
  <label>
    <span>Password</span>
    <input type="password" name="password-1" placeholder="Your password goes here" tabindex="3" required>
  </label>
  <label>
    <span>Confirm Password</span>
    <input type="password" name="password-2" placeholder="Your password goes here also  " tabindex="4" required>
  </label>
  <h3>Prove you are not a bot</h3>
  <label><input type="checkbox" name="bot">&nbsp;Do not check</label>
  <label><button type="submit" name="submit" tabindex="5">Sign me up!</button></label>
</form>

<p><a href="signin.php">Already have an account? Sign in!</a></p>
<?php MW_closePage(); ?>
