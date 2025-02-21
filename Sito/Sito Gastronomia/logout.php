<?php
  session_start();
  if (isset($_POST["logout"])) {
    if (isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time() - 42000);
    }
    session_unset();
    session_destroy();
    header("location: index.php");
  }
?>
