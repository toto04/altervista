<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it" dir="ltr">
<head>
	<?php require 'head.php'; ?>
	<script type="text/javascript" id="pageName">
	var pageName = "Account";
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
			require 'database.php';
			if ($_POST['sub'] == 'login') {
				// TODO: Rendere tutto più bello
				$usr = $_POST['username'];
				$pwd = hash('sha256', $_POST['password']);

				$logQuery = "SELECT password FROM users WHERE username='$usr'";
				$cont = mysql_query($logQuery);
				$pass = mysql_fetch_array($cont)['password'];
				if ($pwd == $pass) {
					$_SESSION['isLogged'] = true;
					$_SESSION['username'] = $usr;
				} else {
					echo "Password sbagliata!";
				}
				//echo "Log";

			} else if ($_POST['sub'] == 'register') {
				$usr = $_POST['username'];
				$email = $_POST['email'];
				$pwd = hash('sha256', $_POST['password']);

				$newUsr = "INSERT INTO users (username, email, password) VALUES ('$usr','$email','$pwd')";
				mysql_query($newUsr);

				$_SESSION['isLogged'] = true;
				$_SESSION['username'] = $usr;
			} else if ($_POST['sub'] == 'logout') {
				echo "logout";
				session_unset();
			} else {
				//echo "post??";
				//print_r($_POST);
			}

			if ($_SESSION['isLogged']) {
				//echo "Logged";
				echo "<div class='title'><h1>"
				. "Benvenuto, " . $_SESSION['username']
				. "! </h1></div>";
				echo '
				<form method="post" class="loginWrapper">
    			<button class="submitButton" type="submit" name="sub" value="logout">Logout</button>
				</form>';
				// TODO: Creare interfaccia utente
			} else {
				//echo "not logged";
				require './elements/logForms.html';
			}
			?>
		</div>
	</div>
</body>
</html>
