<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>iscrizione</title>
</head>
<body>
  <center>
  <img src='unive.jpg' style='position:fixed;top:0px;left:0px;width:100%;height:100%;z-index:-1;'>
  <table><td width="33%"></td><td width="33%">
<h1>Iscrizione al sito di Appunti</h1>
  <p>Per iscriversi &egrave; necessario fornire un nome utente (login) e una password</p>
  <p>
  <?php 
    if ($_GET['errore'] == 'utenteesistente') {
      echo "<font color=red>Spiacente, il nome utente inserito &egrave; gi&agrave; in uso</font>";
    } elseif ($_GET['errore'] == 'mancainput') {
      echo "<font color=red>Devi dare sia login che password!</font>";
    } ; ?>
  </p>
  <form action="verifica_iscrizione.php" method="post">
    <table><tr><td>Login:</td><td><input type="text" name="login"></td></tr>
           <tr><td>Password:</td><td><input type="password" name="password"></td></tr>
    </table>
    <input type="submit" value="Iscrivimi">
  </form>
<?php
require "footer.php";
?>