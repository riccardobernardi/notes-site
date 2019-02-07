<?php 
  require "library.php";
  $var="Sito Appunti";
  require "header.php";
?>
  <h1>Ricerca per parola all'interno delle domande</h1>
    <form action="esegui_ricerca.php" method="post">
      <p>Scrivi la parola che deve essere ricercata nelle domande:</p> 
      <input type="text" name="titolo">
      <p>
      <input type="submit" value="Cerca">
      </p>
    </form>
<?php
require "footer.php";
?>