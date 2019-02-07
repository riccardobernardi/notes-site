<?php 
  require "library.php";
  $var="Sito Appunti";
  require "header.php";
?>
<?php
if (empty($_POST['titolo']) || empty($_POST['professore'])) {
  echo "Il corso non &egrave; stato creato perch&eacute; la domanda &egrave vuota!";
} else {
try {
  $dbconn = connect();
  $statement = $dbconn->prepare('select appunti.aggiungi_corso(?,?,?)');
  $statement->execute(array($_POST['titolo'],$_POST['professore'],$_SESSION['nome_utente']));
  echo "Il corso &egrave; stato creato.";
} catch (PDOException $e) { echo $e->getMessage(); }
}
?>
</p>
<p> <a href="crea_corso.php?">Crea un nuovo corso</a> </p>
<?php
require "footer.php";
?>