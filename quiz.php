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
					<li><a href="#4">Il Server</a></li>
					<li><a href="#5">Gestione delle richieste</a></li>
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
					<p>
						Creiamo anche un paio di array che conterranno le 4 squadre e la classifica.
						Definiamo anche una funzione che per inizializzare l'array di squadre.
					</p>
<pre class="prettyprint code">
var teams;  //array dei team
var classification; //array globale di classifica per bubblesort
function teamsInit() {
  //L'array viene inizializzato per contenere 4 istanze della classe
  teams = [];
  for (var i = 0; i < 4; i++) {
    teams.push(new Team());
  }
}
</pre>
					<p>
						Infine, l'ultima cosa giuro, implementiamo rapidissimi un bubblesort per ordinare le squadre
					</p>
<pre class="prettyprint code">
function orderTeams() {
  //Ordina la variabile classification per tenere conto della classifica in ordine
  //di punteggio, la variabile tiene i 4 indici delle squadre in ordine di punteggio
  classification = [0, 1, 2, 3]
  var arr = [0, 0, 0, 0];
  for (var i = 0; i < 4; i++) {
    arr[i] = teams[i].punteggio;
  }
  //bubblesort
  for (var i = 0; i < 4; i++) {
    for (var j = 0; j < (3 - i); j++) {
      if(arr[j] > arr[j+1]) {
        var tmp = arr[j];
        arr[j] = arr[j+1];
        arr[j+1] = tmp;

        tmp = classification[j];
        classification[j] = classification[j+1];
        classification[j+1] = tmp;
      }
    }
  }
  //Whooops il bubblesort va dal più piccolo al più grande, a me serve il contrario
  arr = classification.slice(0);  //clona l'array
  for (var i = 0; i < classification.length; i++) {
    //Lo rigira
    classification[i] = arr[3 - i];
  }
}
</pre>
				<h3 class="sub" id="4">Il Server</h3>
				<p>
					Ora possiamo arrivare al succo della questione, come già detto
					utilizziamo express per hostare il server. Orbene questo è il momento
					giusto per creare un'istanza del server e fare un paio di cose di base.
				</p>
<pre class="prettyprint code">
var app = express();  //Crea un'istanza del server

app.use(bodyParser.urlencoded({ extended: false }));  //Non ricordo cosa fanno queste 2 righe
app.use(bodyParser.json()); //Probabilmente qualcosa per gestire i POST http ma non li uso in realtà quindi boh

//Per tutte le altre richieste viene usata la directory /static
//In questo modo file inalterati quali .css e .js verranno pescati direttamente da lì
app.use(express.static(__dirname + '/static'));
</pre>
				<p>
					Dato che il quiz deve essere gestito nel corso di varie richieste dovremmo
					imaggazzinare molte informazioni in variabili globali.
				</p>
<pre class="prettyprint code">
//variabili globali
var timer; //il timer viene usato in più istanze
var currentIndex; //l'indice dell'esperimento corrente per l'array JSON
var startDate = Date.now(); //Il tempo all'inizio dello script
var state = "0";  //indica la sessione di gioco, si avrei potuto usare una variabile booleana
                  //ma una stringa era più facile da interpretare

</pre>
				<p>
					Adesso incomincia la parte divertente (sempre che vi divertiate a soffrire...)
					ovvero la parte dove gestiamo tutte le varie richieste
				</p>
				<h3 class="sub" id="5">Gestione delle richieste</h3>
				<script type="text/javascript">
					var oof = new Audio('https://tommasomorganti.altervista.org/src/oof.mp3');
					function oofSoundPlay() {
						oof.play();
					}
				</script>
				<p>
					<a href="#asdfg" onclick="oofSoundPlay();">Oof</a> sarà una cosa lunga.<br>
					Ok dai, incominciamo con le cose basilari, la schermata iniziale,
					quella della partita, quella dei telefoni e la gestione delle immagini:
				</p>
<pre class="prettyprint code">
app.get('/init', (req, res) => {
  //Il gioco viene inizializzato, gli oggetti vengono resettatti a punteggio 0
  teamsInit();
  res.sendFile(__dirname + "/static/init.html") //File init.html intoccato
})

//La pagina effettiva dove giocare
app.get("/play/:page", (req, res) => {
  //Vengono sostituiti nell'HTML i parametri caricati dal JSON
  //Guardare static/index.html per vedere cosa viene sostituito
  currentIndex = parseInt(req.params.page, 10) - 1;
  if (currentIndex > 5 ) {
    //reinizializza il gioco
    res.redirect("/init")
  }
  var doc = html.replace("TITOLO", experiments[currentIndex].title);
  if (experiments[currentIndex].ques.length > 1) {
    //Se ci sono due domande lo script lo saprà con una variabile booleana
    doc = doc.replace("false", "true");
  }
  //viene caricata la prima domanda
  doc = doc.replace("20000", experiments[currentIndex].ques[0].millis)
  doc = doc.replace("DOMANDA", experiments[currentIndex].ques[0].question)
  for (var i = 0; i < 4; i++) {
    doc = doc.replace("RISPOSTA" + (i + 1), experiments[currentIndex].ques[0].answers[i])
  }
  res.send(doc);  //Viene mandato l'HTML con i parametri sostituiti
})

app.get('/Immagini/esp.jpg', (req, res) => {
  //Il CSS indirizza l'immagine dell'esperimento all'url di cui sopra
  //Viene restituita l'immagine definita dal file JSON
  res.sendFile(__dirname + "/static" + experiments[currentIndex].imgURL);
})

app.get('/phone/:team', (req, res) => {
  //Richiesta dei telefoni
  //Viene modificato il titolo con il numero della squadra
  var team = req.params.team;
  var doc = phoneHtml.replace("NUM", team);
  res.send(doc);
})
</pre>
				<p>
					Perfetto, ora che abbiamo le nostre pagine possiamo finalmente incominciare
					a giocare, cioè più o meno, possiamo gestire le richieste per incominciare
					a giocare dai... È già qualcosa...
				</p>
<pre class="prettyprint code">
//Richieste ai telecomandi
app.get('/sendPlayCall', (req, res) => {
  //Viene mandata una richiesta a quest'URL per far iniziare una sessione di gioco
  res.end();  //La richiesta cessa senza risposta, tanto sti cazzi, non deve rispondere niente di utile
  state = "1"; //La variabile di stato della sessione di gioco viene portata a 1
  //console.log("Play Call!");
  for (var i = 0; i < teams.length; i++) {
    //Gli oggetti vengono inizializzati per la sessione di gioco, i punteggi rimangono
    teams[i].initForPlaySession();
  }

  var cd; //countdown
  var snd;  //se ci sono due domande (solo primo esperimento)
  if (req.query.n != "2") { //viene letto un parametro nell'url (/sendPlayCall?n=2)
    snd = false;
    cd = parseInt(experiments[currentIndex].ques[0].millis);
  } else {
    //Se c'è il parametro allora viene preso il countdown della seconda volta
    //console.log("Oh that's the second time!");
    snd = true;
    cd = parseInt(experiments[currentIndex].ques[1].millis);
  }
  timer = setTimeout(() => {
    //Alla fine del countdown viene inviata la richiesta di terminare la sessione
    //passando come parametro se è la seconda domanda
    sendStop(snd);
  }, cd);
})

function sendStop(second) {
  state = "0";  //lo stato viene riportato a 0
  //console.log("Time's up!");
  var correctAnsw;
  if (second) { //se è la seconda domanda allora guarda la giusta riposta corretta
    correctAnsw = experiments[currentIndex].ques[1].correct;
  } else {
    correctAnsw = experiments[currentIndex].ques[0].correct;
  }
  for (var i = 0; i < teams.length; i++) {
    //Viene confrontata la risposta data con quella corretta
    if (teams[i].risposta == correctAnsw) {
      //Guadagno di 100 punti, prima doveva dipendere dal tempo (rip albertina)
      teams[i].guadagno = 100;
    } else {
    }
    teams[i].punteggio += teams[i].guadagno;
  }
  orderTeams(); //Chiama la funzione per generare l'array di classifica
}
</pre>
				<p>
					Ma a cosa serve giocare se non si può mandare una risposta? Ecco la
					gestione delle risposte:
				</p>
<pre class="prettyprint code">
app.get('/send', (req, res) => {
  //URL a cui mandare la risposta data (/send?team=1&answer=A)
  //Lo so lo so, avrei dovuto mandare un POST HTTP al posto di un normale GET HTTP
  //Non sono perfetto, non mi riusciva, di nuovo, erano le 2 di notte, ho deciso di mandare
  //un GET con due parametri invece di un post fatto per bene, oh beh funziona
  res.end();  //niente da resistuire
  var tm = parseInt(req.query.team, 10) - 1;
  var answ = req.query.answer;
  //Viene impostato il parametro risposta dell oggetto giusto in base alla risposta data
  teams[tm].risposta = answ;
})

//URL per il pulling della sessione di gioco, così il telefono sa quando chiedere la risposta
app.get('/gameState', (req, res) => { res.send(state) })
</pre>
				<p>
					Voi lo sapevate che c'erano due domande per un esperimento????? Io sì,
					l'ho fatto io sto coso, quindi ecco la mia soluzione:
				</p>
<pre class="prettyprint code">
//Funzioni per la seconda domanda richieste via AJAX in caso di due domande
app.get('/secondTimer', (req, res) => {
  //pagina che restituisce il countdown per la seconda domanda, per aggiornare il javascript
  res.send(experiments[currentIndex].ques[0].millis);
  //in realtà guarda quello della prima domanda, quindi questa roba è completamente inutile
  //inizialmente funzionava con la seconda (indice [1]) però ho notato che era lo stesso timer nella prima domanda
  //e mi serviva un URL per prendere il countdown dal telefono, ho solo riciclato questo pigramente
  //scusate erano le 2 di notte
})
app.get('/secondQuestion', (req, res) => {
  //pagina che restituisce la seconda domanda, per sostituirla senza ricaricare
  res.send("&lt;h2&gt;" + experiments[currentIndex].ques[1].question + "&lt;/h2&gt;");
})
app.get('/secondAnswer/:ind', (req, res) => {
  //pagina che restituisce una risposta
  var ind = parseInt(req.params.ind, 10);
  var lettera;
  //In base all'indice prende il suffisso
  switch (ind) {
    case 0:
    lettera = "A) "
    break;
    case 1:
    lettera = "B) "
    break;
    case 2:
    lettera = "C) "
    break;
    case 3:
    lettera = "D) "
    break;
    default:
    lettera = "";
  }
  //Restituisce un paragrafo con il suffisso e la relativa risposta
  res.send("&lt;p&gt;" + lettera + experiments[currentIndex].ques[1].answers[ind] + "&lt;/p&gt;");
})
</pre>
				<p>
					Ok ho quasi finito, ora abbiamo finito la nostra partita e serve solo
					che la pagina dei risultati rilevi tutti i risultati, così come i telefoni
				</p>
<pre class="prettyprint code">
//Pagine per i risultati richiesti via AJAX dalla pagina
app.get('/squadra/:ind', (req, res) => {
  //In ordine di classifica le squadre
  var ind = parseInt(req.params.ind, 10);
  res.send("Squadra " + (classification[ind] + 1));
});
app.get('/answ/:ind', (req, res) => {
  //Usa la classifica come indice per l'array di oggetti e restituisce la risposta
  var ind = parseInt(req.params.ind, 10);
  res.send(String(teams[classification[ind]].risposta))
});
app.get('/punteggio/:ind', (req, res) => {
  //Usa la classifica come indice per l'array di oggetti e restituisce il punteggio
  var ind = parseInt(req.params.ind, 10);
  res.send(String(teams[classification[ind]].punteggio))
});
app.get('/guadagno/:ind', (req, res) => {
  //Usa la classifica come indice per l'array di oggetti e restituisce il guadagno del turno
  var ind = parseInt(req.params.ind, 10);
  res.send(String(teams[classification[ind]].guadagno))
});

//stesse funzioni, ma con l'indice di squadra invece che con la posizione in classifica
//Ogni telefono chiede il suo specifico parametro
app.get('/answPhone/:ind', (req, res) => {
  var ind = parseInt(req.params.ind, 10);
  res.send(String(teams[ind].risposta))
});
app.get('/punteggioPhone/:ind', (req, res) => {
  var ind = parseInt(req.params.ind, 10);
  res.send(String(teams[ind].punteggio))
});
app.get('/guadagnoPhone/:ind', (req, res) => {
  var ind = parseInt(req.params.ind, 10);
  res.send(String(teams[ind].guadagno))
});
</pre>
				<p>
					BIG OOF. Finito. Ultimissima cosa, la cosa più bella, far partire il server
				</p>
<pre class="prettyprint code">
// Infine, il server va on sulla porta 80. OOF.
app.listen(80, () => {
  console.log("Server's UP on port 80!");
})
</pre>
				<h3>FINITO</h3>
				<p>
					A parte il fatto che manca tutta la parte staticaAAAAAARGH,
				</p>
				<h3>HTML, CSS e JS client-side arriveranno</h3>
			</div>
		</div>
	</div>
</body>
</html>
