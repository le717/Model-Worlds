<?php
  session_start();
  require 'php/common_utils.php';

  // Sign the user out
  if (MW_isSignedIn()) {
    MW_signOut();
    MW_redirectUser('index.php?signout=1');
  }
