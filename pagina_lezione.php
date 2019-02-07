<?php 
  require "library.php";
  $var="Sito Appunti";
  require "header.php";
  $var=explode('%20',$_GET['lezione']);
  $var=implode(' ',$var);
?>
  <h1>Lezione</h1>
  <p>
  <?php
  try {
    $dbconn = connect();

    echo "<p>la lezione: ";
    echo $var;
    echo "</p>";

    $stat = $dbconn -> prepare('select * from appunti.note where lezione=? order by appunti.note.stamp desc');
    $stat->execute(array($var));
    $risp = $stat->fetchAll();

    stampa_note($dbconn,$risp);

    $stat = $dbconn -> prepare('select creatore from appunti.lezioni where titolo = ? ');
    $stat->execute(array($var));
    $risp = $stat->fetch();
    
    echo "<p>Questa lezione &egrave; stato proposta da : ";
    echo $risp[creatore];
    echo "</p>";

  } catch (PDOException $e) { echo $e->getMessage(); }
  ?>
  <p> <a href="crea_nota.php?lezione=<?php echo $var; ?>">Crea una nuova nota per questa lezione</a> </p>
  <?php
require "footer.php";
?>