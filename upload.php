<?php
  $options = array('page_title' => 'Upload');
  require 'php/loader.php';
  MW_setup();
  MW_openPage($options);

  MW_pageHeader('Share Your Creation');
  MW_pageDesc('"Introducing the double decker couch!"');
?>

<?php MW_closePage(); ?>