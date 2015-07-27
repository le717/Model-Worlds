<?php
  $options = array('page_title' => 'Forgot Password');
  require 'php/page_load.php';
  MW_setup();
  MW_openPage($options);

  MW_pageHeader('Forgot Your Password?');
  MW_pageDesc('Enter the email address to your Model Worlds account');

  // Form submission
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'php/account_pw_reset.php';
  }
?>

<p>Once you submit your email address, you will recieve an email containing directions to reset your password.
<br>You will be back to uploading your latest creations in no time!</p>
<form id="form-forgot-password" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
  <label>
    <span>Email</span>
    <?php if (isset($errors['email'])): ?><div class="input-error">That is not a valid email address!</div><?php endif; ?>
    <input type="email" name="email" placeholder="Your email address goes here" tabindex="1" required>
  </label>
  <label><button type="submit" name="submit" tabindex="2">Reset</button></label>
</form>
<?php MW_closePage(); ?>
