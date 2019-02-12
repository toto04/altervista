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
			<script type="text/javascript">
				var login = true;
				var lgnTimer;
			</script>

      <div class="loginWrapper">
        <div class="loginHeader" style="background-color: var(--mainColor);">
          <h3>Login</h3>
        </div>
        <form class="login" method="post">
          <label>Nome utente: </label><br>
          <input type="text" name="username" required><br>
          <label>Password: </label><br>
          <input type="password" name="psw" required><br>
          <button class="submitButton" type="submit" name="sub" value="login">Login</button>
        </form>
				<p class="loginChanger unselectable" onclick="toggleLogin()">Non hai un account? Clicca qui!</p>
      </div>

			<div class="loginWrapper" style="display: none;">
        <div class="loginHeader" style="background-color: var(--mainColor);">
          <h3>Registrati</h3>
        </div>
        <form class="login" method="post">
          <label>Nome utente: </label><br>
          <input type="text" name="username" required><br>
					<label>Email: </label><br>
					<input type="email" name="username" required><br>
					<label>Password: </label><br>
          <input type="password" name="psw" required><br>
					<label>Conferma Password: </label><br>
          <input type="password" name="psw" required><br>
          <button class="submitButton" type="submit" name="sub" value="register">Registrati</button>
        </form>
				<p class="loginChanger unselectable" onclick="toggleLogin()">Hai già un account? Clicca qui!</p>
      </div>

		</div>
	</div>
</body>
</html>
