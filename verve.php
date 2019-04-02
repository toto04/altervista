<!DOCTYPE html>
<html lang="it" dir="ltr">
<head>
  <?php require 'head.php'; ?>
  <script type="text/javascript" id="pageName">
  var pageName = "Progetto verve";
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
          <li><a href="#1">Inizializzazione</a></li>
          <li><a href="#2">Utilizzo</a></li>
          <li><a href="#3">Deployment</a></li>
        </ul>
      </div>
      <div class="mainContent">
        <link rel="stylesheet" href="/src/tomorrow.css">
        <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
        <div class="title">
          <h1>Guida per il progetto Verve</h1>
        </div>
        <h3 class="sub" id="1">Inizializzazione</h3>
        In questa sezione spiegherò come inizializzare tutto ciò che va inizializzato
        per lavorare sul progetto su un nuovo computer, va fatto solo una volta
        <br><br>

        Il primo passaggio è installare Atom (che direi che avete già, e che se
        non avete sapete come scaricare) e uno strumento per clonare la repository
        di github. <br>
        Potete usare:
        <ul>
          <li><a href="https://gitforwindows.org">Git Bash</a> (a linea di
            comando, tanto dobbiamo usarlo una volta sola, <a href="https://github.com/git-for-windows/git/releases/download/v2.21.0.windows.1/Git-2.21.0-64-bit.exe">link per il download diretto</a>)
          </li>
          <li><a href="https://github.com/git-for-windows/git/releases/download/v2.21.0.windows.1/Git-2.21.0-64-bit.exe">Github Desktop</a>, che è tanto carino ma forse è un po' inutile (che tanto
            dobbiamo usarlo una volta sola)
          </li>
        </ul>
        <br><br>

        <h4>Git Bash</h4>
        Una volta scaricato e installato Git Bash andate nella cartella dove volete
        che venga salvata il vostro sito come ad esempio <code>~/Documenti/Atom/</code>
        o una qualsiasi cartella dove vi pare insomma, aprite la cartella e poi
        tasto destro su uno spazio vuoto.
        <br>
        Nel menu del tasto destro dovrebbe risultare l'opzione <b>"Git BASH here"</b>
        o qualcosa di simile, cliccandola si dobrebbe aprire un prompt di comandi.
        In questo prompt dei comandi dovete usare il comando
<pre class="code prettyprint lang-bash">
git clone https://github.com/toto04/verve.git
</pre>
        A questo punto vi verrà chiesto probabilmente di mettere nome utente e password
        del vostro account di Github, mettetele ovviamente. Se le sbagliate ve le
        richiede ma in modo diverso quindi boh, voi fate quello che vi dice.
        <br><br>
        Una volta messi nome utente e password correttamente procederà a scaricare
        la repository in una cartella <code>"verve"</code> all'interno di quella in cui
        stavate operando. In questa cartella saranno già configurati i file nascosti
        di git con il collegamento alla repository remota su github.

        <h4>Github Desktop</h4>
        <?php // TODO: da scrivere ?>
        //Questo lo devo ancora scrivere
        <br><br>

        <h3 class="sub" id="2">Utilizzo</h3>
        Nella suddetta cartella <code>"verve"</code> potrete trovare il codice sorgente
        della progetto. Ora potete aprire Atom e aprire il progetto andando su
        "<b>File > Open...</b>" e selezionando la bellissima cartella succitata.
        <br><br>
        Vi apparirà sulla sinistra la directory del sito, con tutti i file e le
        cartelle che potrete modificare. <br>
        In basso a destra ci saranno delle icone come il selettore dei branch e
        i tab di git e github.
        <br><br>
        In ordine da sinistra quelle che ci interessano sono il selettore del branch,
        l'icona per i comandi di git e quella per aprire il tab. <br><br>
        <img src="/src/images/verve/tabs.png" alt="img not found" class="code">
        <br><br>
        <ul>
          <li>
            Il selettore del branch fa proprio quello che potete pensare, permette di
            selezionare il branch su cui si vuole lavorare, ovviamente dovrete selezionare
            il vostro (o crearne uno nuovo se vi sentite particolarmente sbrilluccicosi).
            <br><strong>QUALSIASI COSA SUCCEDA NON LAVORATE MAI SUL MASTER</strong><br>
            Non è che succeda qualcosa di irrimediabile perché comunque sia c'è sempre la
            cronologia delle versioni, però meglio non incasinare il master che non
            è mai una buona idea.
          </li>
          <br>
          <li>
            L'icona dei comandi di Git è il vostro migliore amico, lo userete un bel
            po'. Serve per, beh, eseguire i comandi di Git, è semplicissimo in realtà. <br>
            Quando iniziate a lavorare ci sarà scritto "<code>Fetch</code>" proprio come
            nell'immagine, questo comando controlla se ci sono modifiche alla repository
            remota (su Github), nel caso ci fossero apparirà la scritta "<code>Pull</code>"
            che serve appunto per scaricare tutte le modifiche dal remoto al locale.
            <br><br>
            Una volta finito il vostro lavoro ed effettuato un commit il tasto diventerà
            "<code>Push</code>" per caricare le modifiche dal locale al remoto.
          </li>
          <br>
          <li>
            Infine, a destra, il tasto per il tab di git serve solo per aprire e
            a chiudere il tab di git. <br>
          </li>
        </ul>

        Questo tab non è niente di complicato, c'è un elenco delle modifiche
        <b>Unstaged</b>, l'elenco delle modifiche <b>Staged</b>, il campo di
        testo per fare un commit e in fondo la cronologiadei commmit.
        <br><br>

        <img src="/src/images/verve/git.png" alt="img not found" class="code">

        <br><br>
        Le modifiche <b>Unstaged</b> sono le modifiche in corso <br>
        Le modifiche <b>Staged</b> sono le modifiche già ultimate <br>
        Per passare far passare una modifica da Unstaged a Staged bassa fare
        doppio click o clickare su "<code>Stage All</code>" <br>
        <br>
        Quando siete sicure di una modifica potete porla come Staged, potendola
        comunque modificare ulteriormente. <br>
        Alla fine delle vostre modifiche, quando avete creato qualcosa di funzionante
        potete scrivere un messaggio nel campo <b>Commit message</b> dove descrivete
        ciò che è stato creato, poi premere "<code>Commit to <i>nome_del_branch</i></code>"
        <br><br>
        Una volta fatto un commit il commit va caricato su github, il tasto "<code>Fetch</code>"
        diventerà "<code>Push</code>", cliccandoci git caricherà gli aggiornamenti
        su github, abbastanza intuitivo no?
        <br><br>

        <h3 class="sub" id="3">Deployment e Pull Request</h3>
        Una volta finita e ultimata una modifica, potete creare una "<b>Pull request</b>"<br>
        Andando sulla <a href="https://github.com/toto04/verve">pagina di github</a>
        potete selezionare il vostro branch per vedere il suo stato attuale, accanto
        al selettore del branch è convenientemente piazzato il tasto "<code>New pull request</code>"
        <br><br>
        Voi quindi selezionate il vostro branch, create una nuova pull request,
        date un titolo e un commento alla vostra pull request e poi la pubblicate.
        Una pull request è una richiesta di merge al Master. Significa quindi chiedermi
        gentilmente di accettare le vostre modifiche e apportarle alla versione definitiva.
        Perciò voi fate la pull request, poi ci penso io a fare il merge con il master
        in modo tale che risulti su altervista.
      </div>
    </div>
  </div>
</body>
</html>
