<?php
	require "library.php";
	controllo_accesso();
	$dbconn = connect();
	$stat = $dbconn->prepare('delete from appunti.views where appunti.views.utente=?;');
    $stat = $stat->execute(array($_SESSION['nome_utente']));
    header('Location:home.php');
?>