<?php
  $options = array('page_title' => 'Home');
  require 'php/page_load.php';
  MW_setup();
  MW_openPage($options);

  MW_pageHeader('Welcome!');
  MW_pageDesc('What is Model Worlds?');
?>

<p>Model Worlds is a site that hosts community created content for the video game <a target="_blank" href="http://www.lego.com/worlds/">LEGO&reg; Worlds</a>. Here you can download models which were designed by other players and drop them straight into your game - or if you're feeling like a master builder, make and share your very own!
</p>
<p>If you'd like a quick guide, press the start button below. Have fun!</p>

<?php
  MW_largeButton('tutorial.php', 'Start');
  MW_closePage();
?>
