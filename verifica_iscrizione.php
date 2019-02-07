<?php 
require "library.php";
if (empty($_POST['login']) || empty($_POST['password'])) {
  header('Location:iscrizione.php?errore=mancainput');
} else
try{  
  $dbconn = connect();
  $statement = $dbconn->prepare('select count(*) from utenti where nickname = ?');
  $statement->execute(array($_POST['login']));
  $rec = $statement->fetch();
  if ($rec[0] == 1) {
    header('Location:iscrizione.php?errore=utenteesistente');
  } else {
    session_start();
    $_SESSION['nome_utente'] = $_POST['login'];
    $stat = $dbconn->prepare('select nuovo_utente(?,?)');
    $stat->execute(array($_POST['login'],$_POST['password']));
    header('Location:home.php');
  }
} catch (PDOException $e) { echo $e->getMessage(); }
?>
