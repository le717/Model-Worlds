<?php
  function MW_getMessageBox() {
    // Load the messages JSON
    $messages = json_decode(file_get_contents('_includes/messages.json'), true);
    $displayMessage = null;

    // Get the message for the query string
    foreach($_GET as $k => $v) {
      if (isset($messages[$k])) {
        $displayMessage = $messages[$k];
        break;
      }
    }
    return $displayMessage;
  }
