<?php
  $options = array('page_title' => 'About');
  require 'php/page_load.php';
  MW_setup();
  MW_openPage($options);

  MW_pageHeader('About');
  MW_pageDesc('"Blah, blah, blah. Proper name. Place name. Back-story stuff."');
?>

<p>Model Worlds was founded in 2015 as a place for <a target="_blank" href="http://www.lego.com/worlds/">LEGO&reg; Worlds</a> players to download and share custom models.</p>

<p>With plans to add more content and features, I hope that it may contribute to the growth and development of the LEGO Worlds community. As such I welcome your comments, suggestions and feedback.</p>
 
<p>You could consider this website to be in "Early Access", as it is in continuous development and has launched in an unfinished state. Please accept my apologies for any missing content, disruptions or other oddities that may arise.</p>

<?php MW_closePage(); ?>
