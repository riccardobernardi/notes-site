<?php 
  require "library.php";
  $var="Sito Appunti";
  require "header.php";
  $var=explode('%20',$_GET['corso']);
  $var=implode(' ',$var);
?>
  <h1>Corso</h1>
  <p>
  <?php
  try {
    $dbconn = connect();
    echo "<p>Il corso: ";
    echo $var;
    echo "</p>";

    $stat = $dbconn -> prepare('select * from appunti.lezioni where corso=?');
    $stat->execute(array($var));
    $risp = $stat->fetchAll();

    stampa_lezioni($dbconn,$risp);

    $stat = $dbconn -> prepare('select creatore from appunti.corsi where titolo = ? ');
    $stat->execute(array($var));
    $risp = $stat->fetch();

    echo "<p>Questo corso &egrave; stato proposto da : ";
    echo $risp[creatore];
    echo "</p>";
    
  } catch (PDOException $e) { echo $e->getMessage(); }
  ?>
  <p> <a href="crea_lezione.php?corso=<?php echo $var; ?>">Crea una nuova lezione per questo corso</a> </p>
<?php
require "footer.php";
?>