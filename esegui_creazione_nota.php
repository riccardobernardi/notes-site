<?php 
  require "library.php";
  $var="Sito Appunti";
  require "header.php";
  $var=explode('%20',$_GET['lezione']);
  $var=implode(' ',$var);
?>
<?php
if (empty($_POST['titolo'])) {
  echo "la lezione non &egrave; stata creata perch&eacute; il titolo &egrave vuoto!";
} else {
try {
  $dbconn = connect();
  $statement = $dbconn->prepare('select aggiungi_nota(?,?,?,?)');
  $statement->execute(array($_POST['titolo'],$_POST['testo'],$var,$_SESSION['nome_utente']));
  echo "la nota &egrave; stata creata.";
} catch (PDOException $e) { echo $e->getMessage(); }
}
?>
</p>
<p> <a href="crea_nota.php?lezione=<?php echo $var; ?>">Crea una nuova nota</a> </p>
<?php
require "footer.php";
?>