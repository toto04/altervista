<?php session_start(); ?>
<div class="buttonContainer headerCell unselectable">
  <div id="button" onclick="toggleMenu();">
    <div id="rect" data-content="10deg"></div>
  </div>
</div>
<div id="pageTitle" class="headerCell">
  Err, no pageName
</div>
<div id='user' class='headerCell' onclick="loadPage('/account.php')">
  <div id="usrIcon"></div>
  <div id="usrName">
    <?php if ($_SESSION['isLogged']) {
      echo $_SESSION['username'];
    } else {
      echo "Login";
    } ?>
  </div>
</div>
