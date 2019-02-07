<?php

	error_reporting(E_ALL & ~E_NOTICE);

	function controllo_accesso() {
	    session_start();
	    if (empty($_SESSION['nome_utente'])) {
	      header('Location:index.php');
	    }
	  }

	function connect(){
		$dbconn = new PDO('pgsql:host=localhost;port=5432;dbname=unive','postgres','1234');
	 	$dbconn -> exec("SET search_path TO appunti");
	 	$dbconn -> setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 	return $dbconn;
	}

	function ultimi_corsi($dbconn) {
	    $stat = $dbconn->prepare('select * from appunti.corsi order by stamp desc limit 5');
    	$stat->execute();
	    return $stat->fetchAll();
	}

	function tutti_corsi($dbconn) {
	    $stat = $dbconn->prepare('select * from appunti.corsi');
	    $stat->execute();
	    return $stat;
	  }

	 function stampa_note($dbconn,$risp){
	 	if(!empty($risp)){
	        echo "<table border=\"1\" ><tr><td>Titolo</td><td>testo</td><td>views</td><td>creatore</td></tr>";
	        foreach ($risp as $rec) {
	        	$stat = $dbconn -> prepare('select incrementa_views(?,?)');
	            $stat = $stat->execute(array($_SESSION['nome_utente'],$rec['id']));
	           	echo "<tr><td>$rec[titolo]</td><td>$rec[testo]</td><td>$rec[views]</td><td>$rec[creatore]</td><td><a href=\"elimina_nota.php?nota=$rec[id]\">elimina nota</a></td></tr>";
	        }
	        echo "</table>";
	    }else{
	        echo "<br><ul><li>non c'è nulla da visualizzare</ul>";
	    }
	 }

	 function stampa_lezioni($dbconn,$risp){
	 	if(!empty($risp)){
	        echo "<table border=\"1\" ><tr><td>Titolo</td><td>Ora</td><td>giorno</td><td>mese</td><td>anno</td></tr>";
	        foreach ($risp as $rec) {
	           echo "<tr><td><a href=\"pagina_lezione.php?lezione=$rec[titolo]\">$rec[titolo]</a></td><td>$rec[ora]</td><td>$rec[giorno]</td><td>$rec[mese]</td><td>$rec[anno]</td><td><a href=\"crea_nota.php?lezione=$rec[titolo]\">crea nota</a></td><td><a href=\"elimina_lezione.php?lezione=$rec[titolo]\">elimina lezione</a></td></tr>";
	        }
	        echo "</table>";
	    }else{
	        echo "<br><ul><li>non c'è nulla da visualizzare</ul>";
	    }
	 }

	 function stampa_corsi($dbconn,$risp){
	 	if(!empty($risp)){
	        echo "<table border=\"1\" ><tr><td>Titolo</td><td>Professore</td></tr>";
	        foreach ($risp as $rec) {
	           echo "<tr><td><a href=\"pagina_corso.php?corso=$rec[titolo]\">$rec[titolo]</a></td><td>$rec[professore]</td><td><a href=\"crea_lezione.php?corso=$rec[titolo]\">Crea lezione</a></td><td><a href=\"elimina_corso.php?corso=$rec[titolo]\">elimina corso</a></td></tr>";
	        }
	        echo "</table>";
	    }else{
	        echo "<br><ul><li>non c'è nulla da visualizzare</ul>";
	    }
	 }

?>