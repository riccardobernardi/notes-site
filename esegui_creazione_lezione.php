<?php 
  require "library.php";
  $var="Sito Appunti";
  require "header.php";
  $var=explode('%20',$_GET['corso']);
  $var=implode(' ',$var);
?>
<?php
if (empty($_POST['titolo'])) {
  echo "la lezione non &egrave; stata creata perch&eacute; il titolo &egrave vuoto!";
} else {
try {
  $dbconn = connect();
  $statement = $dbconn->prepare('select aggiungi_lezione(?,?,?,?,?,?,?)');
  $statement->execute(array($_POST['titolo'],$_POST['ora'],$_POST['giorno'],$_POST['mese'],$_POST['anno'],$var,$_SESSION['nome_utente']));
  echo "la lezione &egrave; stata creata.";
} catch (PDOException $e) { echo $e->getMessage(); }
}
?>
</p>
<p> <a href="crea_lezione.php?corso=<?php echo $var; ?>">Crea una nuova lezione</a> </p>
<?php
require "footer.php";
?>