<!DOCTYPE html>
<html lang="it" dir="ltr">
<head>
	<?php require 'head.php'; ?>
	<script type="text/javascript" id="pageName">
	var pageName = "Quiz";
	</script>
	<title></title>
</head>
<body>
	<div id="header"></div>
	<div id="contentShadow" onclick="closeLeft();"></div>
	<div id="contentWrapper">
		<div id="left"></div>
		<div id="content">

			<div class="sidebar">
				<ul>
					<li><a href="#1">Express.js</a></li>
					<li><a href="#2">Importazioni</a></li>
					<li><a href="#3">Squadre</a></li>
				</ul>
			</div>
			<div class="mainContent">
				<link rel="stylesheet" href="/src/tomorrow.css">
				<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
				<div class='title'>
					<h1>Quiz orientamento</h1>
					<h2>La storia di un server in Node.js programmato male</h2>
				</div>

				<!-- ACTUAL CONTENT -->
				<p>
					Potevo mica farmi scappare l'occasione di dimostrare alla Cavallo quanto sono bravo?
					Assolutamente no! Anche perché non sono veramente bravo, ma hey, più o meno ha funzionato no?
				</p>
				<p>
					Insomma, questo qui è il codice per un server HTTP che gira in <a href="https://nodejs.org/en/">Node.js</a>
					basato sulla libreria <a href="https://expressjs.com">Express.js</a>
				</p>

				<h3 class="sub" id="1">Express.js</h3>
				<p>
					Una volta scaricato e installato Node.js dal sito ufficiale possiamo incominciare con il
					progetto creando una cartella, navigandoci con una finestra di terminale e installando expressjs
					con il comando
				</p>
<pre class="prettyprint lang-sh code">
npm install express
</pre>
				<p>
					Adesso non ci resta che creare il nostro file Javascript che conterrà il server e imporare i moduli di cui
					abbiamo bisogno, ovvero <b>Express</b> (che abbiamo appena installato) e <b>fs</b>, la libreria di default per la lettura di file
				</p>
<pre class="prettyprint lang-js code">
const fs = require('fs'); //modulo file system per leggere i file html
const bodyParser = require('body-parser'); //serve per i POST con express
const express = require('express'); //Modulo che gestisce il traffico HTTP
</pre>
				<br>

				<h3 class="sub" id="2">Importazioni</h3>
				<p>
					Il programma funzionerà così:
					<ul>
						<li>Importa il file JSON contenente gli esperimenti</li>
						<li>Importa i file HTML che verranno modificati nel momento della richiesta</li>
						<li>Aggiorna i punteggi contenuti delle squadre, un array di oggetti</li>
						<li>Gestisci le informazioni che dovranno apparire sulla pagina mediante AJAX</li>
						<li>Esponi il server sulla porta 80</li>
					</ul>
					<br>
					Incominciamo con il leggere il file JSON e i file HTML
				</p>
<pre class="prettyprint code">
var html; //L'effettiva pagina HTML tenuta come una stringa gigante
var phoneHtml;  //La pagina HTML per telefoni, nella stessa stringa gigante

//Il file JSON contiene tutti gli esperimenti, vengono caricati in un array di oggetti
var experiments = JSON.parse(fs.readFileSync('./experiments.json', 'utf8'));

fs.readFile('./static/index.html', 'utf8', (err, page) => {
  //Carica l'HTML come stringa gigante
  html = page;
  //Cambia i riferimenti da relativi a assoluti, perché era più facile debuggare
  //css e javascript senza il server ON così
  html = html.replace("style.css", "/style.css");
  html = html.replace("script.js", "/script.js")
  html = html.replace("Immagini/Logonervi.png", "/Immagini/Logonervi.png")
});

fs.readFile('./static/phone.html', 'utf8', (err, page) => {
  //Carica l'HTML del telefono come stringa gigante
  phoneHtml = page;
  //Cambia i riferimenti da relativi a assoluti, perché era più facile debuggare
  //css e javascript senza il server ON così
  phoneHtml = phoneHtml.replace("phonestyle.css", "/phonestyle.css");
  phoneHtml = phoneHtml.replace("phonescript.js", "/phonescript.js")
  phoneHtml = phoneHtml.replace("Immagini/Logonervi.png", "/Immagini/Logonervi.png")
});
</pre>

				<h3 class="sub" id="3">Squadre</h3>
				<p>
					Come già detto le squadre sono un array di 4 oggetti contenenti le informazioni utili <br>
					Iniziamo con il dichiarare la classe <b>Team</b>
				</p>
<pre class="prettyprint lang-js code">
class Team {
  //classe che rappresenta una squadra
  constructor() {
    //Costruttore, resetta tutti i parametri
    this.punteggio = 0;
    this.guadagno = 0;
    this.risposta = "Nessuna risposta :(";
    this.tempo = 0; //Volevo dare punteggi in base al tempo ma la cavallo ha detto no :(
  }
  initForPlaySession() {
    //Resetta tutti i parametri menché il punteggio, così da poter dare una risposta
    this.guadagno = 0;
    this.risposta = "Nessuna risposta :(";
    this.tempo = 0;
  }
}
</pre>
				<h3>Sito in costruzione</h3>
			</div>
		</div>
	</div>
</body>
</html>
