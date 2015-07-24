<?php
  $options = array('page_title' => 'Forgot Password');
  require 'php/page_load.php';
  MW_setup();
  MW_openPage($options);

  MW_pageHeader('Forgot Your Password?');
  MW_pageDesc('Enter the email address to your Model Worlds account');
?>

<p>Once you submit your email address, you will recieve an email containing directions to reset your password.
<br>You will be back to uploading your latest creations in no time!</p>
<form id="form-forgot-password" method="post" action="#">
  <label><input type="email" name="email" placeholder="Email" tabindex="1" required></label>
  <label><button type="submit" name="submit" tabindex="2">Reset</button></label>
</form>
<?php MW_closePage(); ?>
