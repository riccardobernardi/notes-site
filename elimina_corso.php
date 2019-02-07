<?php
	require "library.php";
	controllo_accesso();
	$dbconn = connect();
	$stat = $dbconn->prepare('delete from appunti.corsi where appunti.corsi.titolo=? AND appunti.corsi.creatore=?');
    $stat = $stat->execute(array($_GET['corso'],$_SESSION['nome_utente']));
    header('Location:home.php');
?>