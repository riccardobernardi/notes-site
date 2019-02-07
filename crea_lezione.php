<?php 
  require "library.php";
  $var="Sito Appunti";
  require "header.php";
  $var=explode('%20',$_GET['corso']);
  $var=implode(' ',$var);
?>
  <h1>Creazione di una nuova lezione</h1>
  <p>Qui <?php echo $_SESSION['nome_utente']?> puoi creare una nuova lezione.</p>


  <form action="esegui_creazione_lezione.php?corso=<?php echo $var; ?> " method="post">
    <p>titolo</p>
   <textarea name="titolo" cols=80 rows=4></textarea>
   <br>
   <p>ora</p>
   <textarea name="ora" cols=80 rows=4></textarea>
   <br>
   <p>giorno</p>
   <textarea name="giorno" cols=80 rows=4></textarea>
   <br>
   <p>mese</p>
   <textarea name="mese" cols=80 rows=4></textarea>
   <br>
   <p>anno</p>
   <textarea name="anno" cols=80 rows=4></textarea>
   <br>
   <input type="submit" value="Crea">
  </form>
<?php
require "footer.php";
?>