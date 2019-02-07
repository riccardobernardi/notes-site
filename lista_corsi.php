<?php 
  require "library.php";
  $var="Sito Appunti";
  require "header.php";
?>
  <h1>Elenco dei corsi</h1>
  <p> In questa pagina puoi vedere tutti i corsi inseriti e puoi creare lezioni.</p>
  <?php 
  try {
    $dbconn = connect();
    $stat = $dbconn->prepare('select * from appunti.corsi');
    $stat->execute();
    $risp = $stat->fetchAll();
    stampa_corsi($dbconn,$risp);
  } catch (PDOException $e) { echo $e->getMessage(); }
  ?>
<?php
require "footer.php";
?>