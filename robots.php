<?php
  $options = array('page_title' => 'No Robots Allowed!');
  require 'php/loader.php';
  MW_setup();
  MW_openPage($options);

  MW_pageHeader('No Robots Allowed!');
?>

<p>Robots are not allowed to join Model Worlds! Go back to producing LEGO bricks like you are supposed to be doing!</p>
<img alt="" title="Epic robot created by Alcom Isst" class="img-responsive"
     style="display: block; margin-left: auto; margin-right: auto;" width="500" height="385" src="img/alcom-bot.png">
<?php MW_closePage(); ?>
