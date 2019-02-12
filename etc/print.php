<!DOCTYPE html>
<html lang="it" dir="ltr">
<head>
	<?php require '../head.php'; ?>
	<script type="text/javascript" id="pageName">
	var pageName = "Codice Sorgente";
	</script>
	<title></title>
</head>
<body>
	<div id="header"></div>
	<div id="contentShadow" onclick="closeLeft();"></div>
	<div id="contentWrapper">
		<div id="left"></div>
		<div id="content">
      <link rel="stylesheet" href="/src/tomorrow.css">
      <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
			<p>Questo script funziona con qualsiasi pagina del sito, prova anche con Javascript e CSS!</p>
			<p>Basta andare a tommasomorganti.altervista.org/etc/print.php?url=<i>INDIRIZZO_DELLA_PAGINA</i></p>
<pre class="prettyprint code linenums" style="width: 90%;">
<?php
$url = $_GET['url'];
if ($url == 'credentials.php') {
	$code = "Error code 403 (scherzo, però non puoi guardare la mia password)";
} else {
	$code = file_get_contents("../" . $url);
	$code = str_replace("&","&amp;",$code);
	$code = str_replace("<","&lt;",$code);
	$code = str_replace(">","&gt;",$code);
}
echo $code;
?>
</pre>
		</div>
	</div>
</body>
</html>
