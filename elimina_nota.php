<?php
	require "library.php";
	controllo_accesso();
	$dbconn = connect();
	$stat = $dbconn->prepare('delete from appunti.note where appunti.note.id=? AND appunti.note.creatore=?');
    $stat = $stat->execute(array($_GET['nota'],$_SESSION['nome_utente']));
    header('Location:home.php');
?>