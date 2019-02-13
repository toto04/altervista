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
				// TODO: gestire il login
				echo "Log";
				//$_SESSION['isLogged'] = true;
				//$_SESSION['username'] = $_POST['username'];
				//$_SESSION['password'] = $_POST['password'];
			} else if ($_POST['sub'] == 'register') {
				$usr = $_POST['username'];
				$email = $_POST['email'];
				$pwd = hash('sha256', $_POST['password']);

				$newUsr = "INSERT INTO users (username, email, password) VALUES ('$usr','$email','$pwd')";
				mysql_query($newUsr);

				$_SESSION['isLogged'] = true;
				$_SESSION['username'] = $usr;
			} else {
				echo "post??";
				print_r($_POST);
			}

			if ($_SESSION['isLogged']) {
				echo "Logged";
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
