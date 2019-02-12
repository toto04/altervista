<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it" dir="ltr">
  <head>
    <?php require '../head.php'; ?>
    <script type="text/javascript" id="pageName">
    var pageName = "Login";
    </script>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div id="header"></div>
    <div id="contentShadow" onclick="closeLeft();"></div>
    <div id="contentWrapper">
      <div id="left"></div>
      <div id="content">
        <?php
        if (isset($_SESSION['mark'])) {
          echo $_SESSION['mark'];
          echo $_SESSION['name'];
          echo $_SESSION['comment'];
        }
        ?>
      </div>
  </body>
</html>
