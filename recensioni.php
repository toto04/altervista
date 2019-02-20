<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it" dir="ltr">
<head>
  <?php require 'head.php'; ?>
  <script type="text/javascript" id="pageName">
  var pageName = "Recensioni";
  </script>
  <title></title>
</head>
<body>
  <div id="header"></div>
  <div id="contentShadow" onclick="closeLeft();"></div>
  <div id="contentWrapper">
    <div id="left"></div>
    <div id="content">
      <script src="/src/javascript/review.js" charset="utf-8"></script>
      <?php
      // TODO: Permettere di eliminare le recensioni
      //Gestisce le informazioni
      if (isset($_POST["save"]) && $_SESSION['isLogged']) {
        $mk = $_POST['mark'];
        $cm = $_POST['comment'];
        $nm = $_SESSION['username'];
        $insert = "INSERT INTO my_tommasomorganti.comments (id, Mark, Name, Comment, data) VALUES (NULL, $mk, '$nm', '$cm', CURRENT_TIMESTAMP());";
        mysql_query($insert);
      }
      ?>
      <?php
      require 'database.php';

      $query = "SELECT * FROM comments";
      $content = mysql_query($query);
      $nRows = mysql_num_rows($content);

      $arr = array();
      for ($i=0; $i < $nRows; $i++) {
        $row = mysql_fetch_row($content);
        $arr[$i] = $row;
      }
      $avr = 0;
      for ($i=0; $i < $nRows; $i++) {
        $avr += $arr[$i][1];
      }
      $avr /= $nRows;
      $avr = floor($avr * 100) / 100;
      echo "<h1> Media dei voti: " . $avr . "/10</h1>";
      ?>
      <p>Dammi consigli, opinioni o suggerimenti per migliorare questo sito, dai dettagli ai contenuti, <a href="#" onclick="openReview();">recensisci il sito</a></p>
      <div id='newReviewWrapper'>
        <div id="newReview">
          <div id="close" onclick="closeReview();"><div></div></div>
          <?php
          if ($_SESSION['isLogged']) {
            echo '
            <form method="post">
            <!-- <label>Nome:</label><br/>
            <input type="text" name="name" required><br/> -->
            <label>Voto:</label><br/>
            <input type="number" name="mark" min="1" max="10" required><br/>
            <label>Commento:</label><br/>
            <textarea id="comment" type="text" name="comment" required></textarea><br/>
            <button class="submitButton" type="submit" name="save">save</button>
            <p style="font-size: 10px">Per favore non fate SQL injections, è vulnerabilissimo</p>
            </form>';
          } else {
            echo "<label>Accedi per postare un commento</label>"
            . '<button class="submitButton" onclick="loadPage('
            . "'/account.php'"
            . ');">Login</button>';
          }
          ?>
        </div>
      </div>

      <?php
      for ($i = $nRows - 1; $i >= 0; $i--) {
        $row = $arr[$i];
        echo
        '<div class="review">
        <div class="reviewHead">
        <span>' . $row[2] . ' - ' . $row[1] . '/10</span>
        <span style="float: right; margin-right: 8px;">' . $row[4] . "</span>
        </div>
        <p>" . $row[3] . '</p>
        </div>';
      }
      ?>

    </div>
  </div>
</body>
</html>
