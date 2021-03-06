<?php
  $options = array('page_title' => 'Contact');
  require 'php/page_load.php';
  MW_setup();
  MW_openPage($options);

  MW_pageHeader('Get In Touch');
  MW_pageDesc('"These mechanical birds will get our message out!"');

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function spamScrubber($msg) {
      // Very bad values
      $veryBad = array('to:', 'cc:', 'bcc:', 'content-type:',
                       'mime-version:', 'multipart-mixed:',
                       'content-transfer-encoding:');

      // Remove any very bad strings
      $msg = str_replace($veryBad, '', $msg);
      return trim(strip_tags($msg));
    }

    // Clean the text
    $cleaned = array_map('spamScrubber', $_POST);

    // Bot check :)
    if (isset($cleaned['bot'])) {
      MW_redirectUser('robots.php');
      die();
    }

    // The email address is not valid
    if (!MW_validateEmail($cleaned['email'])) {
      $errMsg = true;
    }

    $body = "<p>{$cleaned['name']} (<a href='mailto:{$cleaned['email']}'>{$cleaned['email']}</a>) has sent you a message! Here is the message.</p>";
    $body .= "<p>{$cleaned['message']}</p>";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'To: noreply@modelworlds.net' . "\r\n";
    $headers .= 'From: Model Worlds <noreply@modelworlds.net>' . "\r\n";

    //  mail('', 'Model Worlds - Contact Form', $body, $headers);
  }
?>

<form id="form-contact" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
  <label>
    <span>Username</span>
    <input type="text" name="name" placeholder="Your username goes here" tabindex="1" required>
  </label>
  <label>
    <span>Email</span>
    <?php if (isset($errMsg)): ?><div class="input-error">That is not a valid email address!</div><?php endif; ?>
    <input type="email" name="email" placeholder="Your email address goes here" tabindex="2" required>
  </label>
  <label>
    <span>Message</span>
    <textarea name="message" placeholder="Your message goes here!" tabindex="3" required></textarea>
  </label>

  <h3>Prove you are not a bot</h3>
  <label><input type="checkbox" name="bot">&nbsp;Do not check</label>
  <label><button type="submit" name="submit" tabindex="4">Send</button></label>
</form>
<?php MW_closePage();
