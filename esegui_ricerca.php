<?php 
  require "library.php";
  $var="Sito Appunti";
  require "header.php";
?>
  <h1>Elenco dei corsi/lezioni/note trovate</h1>
  <p>La ricerca della parola <?php echo $_POST['parola']?> nei titolo ha prodotto i seguenti risultati:</p>
<?php
if (empty($_POST['titolo'])) {
  echo "inserisci un titolo<br>";
} else {
  try {
    $dbconn = connect();
    $var=$_POST['titolo'];

    echo "corsi";
    $stat = $dbconn->prepare('select * from appunti.corsi where appunti.corsi.titolo ilike \'%\' || ? || \'%\';');
    $stat->execute(array($var));
    $risp = $stat->fetchAll();
    stampa_corsi($dbconn,$risp);


    echo "<br> lezioni";
    $stat = $dbconn->prepare('select * from appunti.lezioni where appunti.lezioni.titolo ilike \'%\' || ? || \'%\';');
    $stat->execute(array($var));
    $risp = $stat->fetchAll();
    stampa_lezioni($dbconn,$risp);
    

    echo "<br> note";
    $stat = $dbconn->prepare('select * from appunti.note where appunti.note.titolo ilike \'%\' || ? || \'%\' OR appunti.note.testo ilike \'%\' || ? || \'%\';');
    $stat->execute(array($var,$var));
    $risp = $stat->fetchAll();
    stampa_note($dbconn,$risp);

  } catch (PDOException $e) { echo $e->getMessage(); }
}
?>
<?php
require "footer.php";
?>