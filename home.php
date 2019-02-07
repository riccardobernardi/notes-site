<?php 
  require "library.php";
  $var="Sito Appunti";
  require "header.php";
?>
  <h1>Sito di appunti: pagina principale</h1>
  Benvenuto <b><?php echo $_SESSION['nome_utente']?></b>!
  Queste sono le operazioni che puoi fare:</h1>
  <ul>
    <li> <a href="lista_corsi.php">Elencare tutti i corsi</a> </li>
    <li> <a href="ricerca.php">Ricercare corsi/lezioni/appunti</a> </li>
    <li> <a href="crea_corso.php">Creare un nuovo corso</a> </li>
    <li> <a href="personale.php">Vedere i tuoi dati personali</a> </li>
    <li> <a href="uscita.php">Uscire dall'applicazione</a></li>
  </ul>
  <p>Lista degli ultimi corsi inseriti:</p>
  <?php 
  try {
    $dbconn = connect();

    $last = ultimi_corsi($dbconn);
    stampa_corsi($dbconn,$last);
    
  } catch (PDOException $e) { echo $e->getMessage(); }
  ?>
<?php
require "footer.php";
?>