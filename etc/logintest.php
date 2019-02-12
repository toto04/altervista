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
    <?php
    //Gestisce le informazioni
    if (isset($_POST["save"])) {
      $_SESSION['mark'] = $_POST['mark'];
      $_SESSION['name'] = $_POST['name'];
      $_SESSION['comment'] = $_POST['comment'];
    }
    ?>

    <div id="header"></div>
    <div id="contentShadow" onclick="closeLeft();"></div>
    <div id="contentWrapper">
      <div id="left"></div>
      <div id="content">
        <div id="newReview" style="opacity: 1; display: block;">
          <div id="close" onclick="closeReview();"><div></div></div>
          <form method="post">
            <label>Nome:</label><br/>
            <input type="text" name="name" required><br/>
            <label>Voto:</label><br/>
            <input type="number" name="mark" min="1" max="10" required><br/>
            <label>Commento:</label><br/>
            <textarea id="comment" type="text" name="comment" required></textarea><br/>
            <button type="submit" name="save">save</button>
            <p style="font-size: 10px">Per favore non fate SQL injections, è vulnerabilissimo</p>
          </form>
        </div>
        <?php
        if (isset($_SESSION['mark'])) {
          echo $_SESSION['mark'] . $_SESSION['name'] . $_SESSION['comment'];
        }
        ?>
      </div>
  </body>
</html>
