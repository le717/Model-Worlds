<?php
  session_start();
  require 'php/login_functions.php';

  // Log outthe user
  if (MW_isSignedIn()) {
    MW_signOut();
    MW_redirectUser('index.php?signout=1');
  }
?>
