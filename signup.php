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
  <label><input type="email" name="email" placeholder="Email" tabindex="1" required></label>
  <label><input type="text" name="username" placeholder="Username" tabindex="2" required></label>
  <label><input type="password" name="password-1" placeholder="Password" tabindex="3" required></label>
  <label><input type="password" name="password-2" placeholder="Confirm Password" tabindex="4" required></label>
  <h3>Prove you are not a bot</h3>
  <label><input type="checkbox" name="bot">&nbsp;Do not check</label>
  <label><button type="submit" name="submit" tabindex="5">Sign me up!</button></label>
</form>

<p><a href="signin.php">Already have an account? Sign in!</a></p>
<?php MW_closePage(); ?>
