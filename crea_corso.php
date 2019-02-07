<?php 
  require "library.php";
  $var="Sito Appunti";
  require "header.php";
?>
  <h1>Creazione di un corso</h1>
  <p>Qui <?php echo $_SESSION['nome_utente']?> puoi creare un nuovo corso.</p>
  <form action="esegui_creazione_corso.php? " method="post">
    <p>titolo</p>
   <textarea name="titolo" cols=80 rows=4></textarea>
   <br>
   <p>professore</p>
   <textarea name="professore" cols=80 rows=4></textarea>
   <br>
   <input type="submit" value="Crea">
  </form>
<?php
require "footer.php";
?>