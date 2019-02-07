<?php 
  require "library.php";
  $var="Sito Appunti";
  require "header.php";
?>
  <h1>Informazioni sull'utente</h1>
  <ul>
  <?php
  try {
    $dbconn = connect();

    $stat = $dbconn -> prepare('select count(*) from appunti.corsi where creatore = ?');
    $stat->execute(array($_SESSION['nome_utente']));
    $rec = $stat->fetch();
    $num_corsi_creati = $rec[0];
    echo "<li>hai creato : ";
    echo $num_corsi_creati;
    echo " corsi su ";
    $stat = $dbconn -> prepare('select count(*) from appunti.corsi');
    $stat->execute();
    $rec = $stat->fetch();
    $num_corsi_creati = $rec[0];
    echo $num_corsi_creati;

    $stat = $dbconn -> prepare('select count(*) from appunti.lezioni where appunti.lezioni.creatore = ?');
    $stat->execute(array($_SESSION['nome_utente']));
    $rec = $stat->fetch();
    $num_lezioni_create = $rec[0];
    echo "<li>hai creato : ";
    echo $num_lezioni_create;
    echo " lezioni su ";
    $stat = $dbconn -> prepare('select count(*) from appunti.lezioni');
    $stat->execute();
    $rec = $stat->fetch();
    $num_lezioni_create = $rec[0];
    echo $num_lezioni_create;

    $stat = $dbconn -> prepare('select count(*) from appunti.note where appunti.note.creatore = ?');
    $stat->execute(array($_SESSION['nome_utente']));
    $rec = $stat->fetch();
    $num_note_creati = $rec[0];
    echo "<li>hai creato : ";
    echo $num_note_creati;
    echo " note su ";
    $stat = $dbconn -> prepare('select count(*) from appunti.note');
    $stat->execute();
    $rec = $stat->fetch();
    $num_note_create = $rec[0];
    echo $num_note_create;

    $stat = $dbconn -> prepare('select count(*) from appunti.views where appunti.views.utente = ?');
    $stat->execute(array($_SESSION['nome_utente']));
    $rec = $stat->fetch();
    $num_views = $rec[0];
    echo "<li>hai totalizzato : ";
    echo $num_views;
    echo " views su ";
    $stat = $dbconn -> prepare('select count(*) from appunti.views');
    $stat->execute();
    $rec = $stat->fetch();
    $num_views_create = $rec[0];
    echo $num_views_create;

    $stat = $dbconn -> prepare('select count(distinct views.nota) from appunti.views where appunti.views.utente = ?');
    $stat->execute(array($_SESSION['nome_utente']));
    $rec = $stat->fetch();
    $num_views = $rec[0];
    echo "<li>hai visualizzato : ";
    echo $num_views;
    echo " distinte note";

    $stat = $dbconn -> prepare('select count(*) from appunti.utenti');
    $stat->execute();
    $rec = $stat->fetch();
    $num_utenti = $rec[0];
    echo "<li>su questo server ci sono : ";
    echo $num_utenti;
    echo " utenti";

/*-------------------------------------------------------------------------------*/
/*-------------creazione vista materializzata e problema di massimo--------------*/
/*-------------------------------------------------------------------------------*/
    $stat = $dbconn -> prepare('drop view if exists appunti.num_note_x_lezione');
    $stat->execute();

    $stat = $dbconn -> prepare('create view appunti.num_note_x_lezione as select appunti.lezioni.titolo as titolo,count(*) as num_note from appunti.lezioni,appunti.note where appunti.lezioni.titolo=appunti.note.lezione group by appunti.lezioni.titolo');
    $stat->execute();

    $statement = $dbconn -> prepare('select max(appunti.num_note_x_lezione.num_note) from appunti.num_note_x_lezione');
    $statement->execute();
    $record = $statement->fetch();

    echo "<li>il massimo di note per una lezione è di : ";
    echo $record[0];

    $stat = $dbconn -> prepare('select appunti.num_note_x_lezione.titolo from appunti.num_note_x_lezione where appunti.num_note_x_lezione.num_note=(select max(appunti.num_note_x_lezione.num_note) from appunti.num_note_x_lezione) limit 5');
    $stat->execute();
    $rec = $stat->fetchAll();
    echo "<ul>";
    if(!empty($rec)){
        foreach($rec as $risp){
            echo "<li>";
            echo $risp[titolo];
        }
    }else{
        echo "<li>non c'è nulla da visualizzare";
    }
    echo "</ul>";

/*-------------------------------------------------------------------------------*/
/*-------creazione vista materializzata e problema di massimo per utente---------*/
/*-------------------------------------------------------------------------------*/

    $stat = $dbconn -> prepare('drop view if exists appunti.num_note_x_lezione_x_utente');
    $stat->execute();

    $stat = $dbconn -> prepare('create view appunti.num_note_x_lezione_x_utente as select appunti.lezioni.titolo as titolo,count(*) as num_note,appunti.lezioni.creatore as creatore from appunti.lezioni,appunti.note where appunti.lezioni.titolo=appunti.note.lezione group by appunti.lezioni.titolo,appunti.lezioni.creatore');
    $stat->execute();
    
    $statement = $dbconn -> prepare('select max(appunti.num_note_x_lezione_x_utente.num_note) from appunti.num_note_x_lezione_x_utente where appunti.num_note_x_lezione_x_utente.creatore = ?');
    $statement->execute(array($_SESSION['nome_utente']));
    $record = $statement->fetch();

    echo "<li>il massimo di note per una lezione creata da te è di : ";
    echo $record[0];

    $stat = $dbconn -> prepare('select appunti.num_note_x_lezione_x_utente.titolo from appunti.num_note_x_lezione_x_utente where appunti.num_note_x_lezione_x_utente.num_note=(select max(appunti.num_note_x_lezione_x_utente.num_note) from appunti.num_note_x_lezione_x_utente where appunti.num_note_x_lezione_x_utente.creatore = ?) AND appunti.num_note_x_lezione_x_utente.creatore = ? limit 5');
    $stat->execute(array($_SESSION['nome_utente'],$_SESSION['nome_utente']));
    $rec = $stat->fetchAll();

    echo "<ul>";
    if(!empty($rec)){
        foreach($rec as $risp){
            echo "<li>";
            echo $risp[titolo];
        }
    }else{
        echo "<li>non c'è nulla da visualizzare";
    }
    echo "</ul>";

    echo "<li><a href=\"cancella_views.php\">cancella views</a>";


  } catch (PDOException $e) { echo $e->getMessage(); }
  ?>
</ul>
  <p> 
<?php
require "footer.php";
?>