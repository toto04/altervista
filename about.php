<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it" dir="ltr">
<head>
	<?php require 'head.php'; ?>
	<script type="text/javascript" id="pageName">
	var pageName = "About Me";
	</script>
	<title></title>
</head>
<body>
	<div id="header"></div>
	<div id="contentShadow" onclick="closeLeft();"></div>
	<div id="contentWrapper">
		<div id="left"></div>
		<div id="content">
			<div class='title'>
				<h1>Tommaso Morganti</h1>
			</div>
			<p>
				Ciao, sono Tommaso Morganti e la mia storia comincia il 17/11/2001 nell'ospedale di Sondrio.
				Anzi, a dire il vero la mia storia inizia circa nove mesi prima... Per quanto sia nato qui i miei genitori sono entrambi di origini Toscane (Livorno, provincia e città)
				TBC...
			</p>
			<h3>Sito in costruzione</h3>
			<?php print_r($_SESSION); ?>
		</div>
	</div>
</body>
</html>
