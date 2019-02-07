<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title>Log-in</title>

    <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />

</head>

<body>
  <img src='unive.jpg' style='position:fixed;top:0px;left:0px;width:100%;height:100%;z-index:-1;'>

  <title>Login</title>

  <?php  
      require "library.php";
      if ($_GET['errore'] == 'invalide') {
      echo "<p><font color=red>Le credenziali che hai fornito non sono valide!</font></p>";
    } elseif ($_GET['errore'] == 'mancainput') {
      echo "<p><font color=red>Devi dare sia login che password!</font></p>";
    }
    ?>

  <div class="login-card">
    <h1>Log-in</h1><br>
  <form action="login.php" method="post">
    <input type="text" name="login" placeholder="login">
    <input type="password" name="password" placeholder="password">
    <input type="submit" name="pulsante" class="login login-submit" value="Login">
  </form>

  <div class="login-help">
    <a href="iscrizione.php?">Register</a>
  </div>
</div>
</body>

</html>