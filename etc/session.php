<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it" dir="ltr">
<head>
	<?php require '../head.php'; ?>
	<script type="text/javascript" id="pageName">
	var pageName = "Sessione";
	</script>
	<title></title>
</head>
<body>
	<div id="header"></div>
	<div id="contentShadow" onclick="closeLeft();"></div>
	<div id="contentWrapper">
		<div id="left"></div>
		<div id="content">
      <?php
      if (isset($_POST['sbt'])) {
        if (isset($_POST['Logged'])) {
          $_SESSION['isLogged'] = true;
          $_SESSION['username'] = $_POST['username'];
        } else {
          $_SESSION['isLogged'] = false;
          $_SESSION['username'] = undefinied;
         }
      }

      echo "Sessione corrente: ";
      print_r($_SESSION);
      ?>
      <br>
      <form method="post">
        <label for="">username: </label>
        <input type="text" name="username"><br>
        <label>logged</label>
        <input type="checkbox" name="Logged" value="Logged">
        <button type="submit" name='sbt' value="asd">Invia</button>
      </form>
		</div>
	</div>
</body>
</html>
