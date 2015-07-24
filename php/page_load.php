<?php
  function MW_setup() {
    session_start();
    require 'signin_utils.php';
    require "lib/Mustache/Autoloader.php";
    Mustache_Autoloader::register();

    $mustache = new Mustache_Engine(array(
       'loader' => new Mustache_Loader_FilesystemLoader(dirname(dirname(__FILE__)) . '/_includes/')
    ));
    $_SESSION['mustache'] = $mustache;
  }

  function MW_openPage($options=array()) {
    // The user wants persistent sign in
    if (MW_isSignInPersist()) {
      MW_signIn(MW_loadSignInPersist()->username, true);
    }

    // The user is logged in
    if (MW_isSignedIn()) {
      $options['signed_in'] = true;
    }

    // A query string was passed,
    // populate the message box
    if (count($_GET) > 0) {
      require 'messages.php';
      $options['messagebox'] = MW_getMessageBox();
    }

    $tpl = $_SESSION['mustache']->loadTemplate('start');
    echo $tpl->render($options);
  }

  function MW_closePage($options=array()) {
    $tpl = $_SESSION['mustache']->loadTemplate('end');
    echo $tpl->render($options);
  }

  function MW_pageHeader($text) {
    echo "\n<h2 id=\"page-header\">{$text}</h2>";
  }

  function MW_pageDesc($text) {
    echo "\n<div id=\"page-desc\">{$text}</div>";
  }

  function MW_largeButton($url, $text) {
    echo "\n<a href=\"{$url}\"><div class=\"btn-action\">{$text}</div></a>";
  }
