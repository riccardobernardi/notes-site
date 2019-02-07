<?php 
  require "library.php";
  $var="Sito Appunti";
  require "header.php";
  $var=explode('%20',$_GET['lezione']);
  $var=implode(' ',$var);
?>
  <h1>Creazione di una nota</h1>
  <p>Qui <?php echo $_SESSION['nome_utente']?> puoi creare una nuova nota.</p>
  <form action="esegui_creazione_nota.php?lezione=<?php echo $var; ?> " method="post">
    <p>titolo</p>
   <textarea name="titolo" cols=80 rows=4></textarea>
   <br>
   <p>testo</p>
   <textarea name="testo" cols=80 rows=4></textarea>
   <br>
   <input type="submit" value="Crea">
  </form>
<?php
require "footer.php";
?>