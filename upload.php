<?php
  $options = array('page_title' => 'Upload');
  require 'php/page_load.php';
  MW_setup();
  MW_openPage($options);

  MW_pageHeader('Share Your Creation');
  MW_pageDesc('"Introducing the double decker couch!"');
?>

<p>In the meantime, please click below to refer to the excellent guide provided by Lucidis on the LEGO Worlds Steam community hub.</p>
<p>If you'd simply like to know how to download and install models, or anything else about this site, head on over to the About page.</p>
<?php
  MW_largeButton('http://steamcommunity.com/sharedfiles/filedetails/?id=455735233', 'View Guide');
  MW_closePage();
?>