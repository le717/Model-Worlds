<?php
  $options = array('page_title' => 'Contact');
  require 'php/page_load.php';
  MW_setup();
  MW_openPage($options);

  MW_pageHeader('Get In Touch');
  MW_pageDesc('"These mechanical birds will get our message out!"');
?>

<form id="form-contact" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <label><input type="text" name="name" placeholder="Name" tabindex="1" required></label>
  <label><input type="email" name="email" placeholder="Email" tabindex="2" required></label>
  <label><textarea name="message" placeholder="Your message here!" tabindex="3" required></textarea></label>
  <h3>Prove you are not a bot</h3>
  <label><input type="checkbox" name="bot">&nbsp;Do not check</label>
  <label><button type="submit" name="submit" tabindex="4" >Send</button></label>
</form>
<?php MW_closePage();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function spamScrubber($msg) {
      // Very bad values
      $veryBad = array('to:', 'cc:', 'bcc:', 'content-type:',
                       'mime-version:', 'multipart-mixed:',
                       'content-transfer-encoding:');

      // If any very bad strings are found, return an empty string
      // TODO Why not just strip the bad text?
      foreach ($veryBad as $v) {
        if (stripos($msg, $v)) {
          return '';
        }
      }
      return trim(strip_tags($msg));
    }

    // Clean the text
    $cleaned = array_map('spamScrubber', $_POST);

    // Bot check :)
    if (isset($cleaned['bot'])) {
      MW_redirectUser('robots.php');
      die();
    }

    $body = "<p>{$cleaned['name']} (<a href='mailto:{$cleaned['email']}'>{$cleaned['email']}</a>) has sent you a message! Here is the message.</p>";
    $body .= "<p>{$cleaned['message']}</p>";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'To: noreply@modelworlds.net' . "\r\n";
    $headers .= 'From: Model Worlds <noreply@modelworlds.net>' . "\r\n";

    //  mail('', 'Model Worlds - Contact Form', $body, $headers);
  }
