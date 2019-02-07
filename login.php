<?php 
require "library.php";
if (empty($_POST['login']) || empty($_POST['password'])) {
  header('Location:appunti.php?errore=mancainput');
} else
try {
  $dbconn = connect();
  $statement = $dbconn->prepare('select credenziali_valide(?, ?)');
  $statement->execute(array($_POST['login'],$_POST['password']));
  $rec = $statement->fetch();
  if ($rec[0]==1) {
    header('Location:home.php');
    session_start();
    $_SESSION['nome_utente'] = $_POST['login'];
  } else {
    header('Location:appunti.php?errore=invalide');
  }
} catch (PDOException $e) { echo $e->getMessage(); }
?>