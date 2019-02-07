<?php
	require "library.php";
	controllo_accesso();
	$dbconn = connect();
	$stat = $dbconn->prepare('delete from appunti.lezioni where appunti.lezioni.titolo=? AND appunti.lezioni.creatore=?');
    $stat = $stat->execute(array($_GET['lezione'],$_SESSION['nome_utente']));
    header('Location:home.php');
?>