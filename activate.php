<?php
  require 'php/login_functions.php';

  // Validate the info
  if (isset($_GET['x'], $_GET['y']) && MW_validateEmail($_GET['x']) && strlen($_GET['y']) == 32) {
    require 'php/db_connect.php';

    // Execute the query
    $e = $mysqli->real_escape_string($_GET['x']);
    $q = "UPDATE `users` SET `activated`='Y' WHERE `email`='{$e}' LIMIT 1";
    $mysqli->query($q);

    // Success!
    if ($mysqli->affected_rows == 1) {
      $page = 'index.php?actifinish=1';

      // Could not update the database
    } else {
      $page = 'contact.php?actierror=1';
    }
    $mysqli->close();
    unset($mysqli);

   // The URL is not valid
  } else {
    $page = 'contact.php?actierror=1';
  }

  // Redirect to the proper page
   MW_redirectUser($page);
