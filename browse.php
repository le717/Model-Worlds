<?php
  $options = array('page_title' => 'Browse');
  require 'php/loader.php';
  MW_setup();
  MW_openPage($options);

  MW_largeButton('#', 'Buildings');
  MW_largeButton('#', 'Objects');
  MW_largeButton('#', 'Sets');
  MW_largeButton('#', 'Landmarks');
  MW_largeButton('#', 'Misc');
  MW_pageDesc('"Everything is awesome!"');
?>

<?php MW_closePage(); ?>
