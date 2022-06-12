<!DOCTYPE html>
<!-- HTML-Grundgerüst
Aufgabenstellung: Suchmaske für 2 verschiedene Zugriffe auf die DB: Filmverwaltung
Autor: Julia Beck
Version: 1.0
Datum: 13.06.2022
-->

<html lang="de">
<head>
  <title>Filmverwaltung</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
<!-- Einbinden von Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  
<!-- Einbinden des Autorenstylesheets: -->
  <link rel="stylesheet" type="text/css" href="css/styles.css">

</head>

<body>
  


<nav class="navbar navbar-expand-md p-2 navbar-light bg-light">
  <a class="navbar-brand" href="#"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.html">Home</a>
      </li>
     
    </ul>
  </div>
</nav>

<header>
   <div class="container-fluid p-5 text-white text-center">
    <h1>Filmverwaltung</h1>
    <p>Herzlich Willkommen, ihr Cineasten</p> 
  </div>
</header>

  <div class="container-md">
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-6 mb-3">
          <h2>Filmproduktionen</h2>
             <p>Hier hast du die Möglichkeit nach den Filmen eines bestimmten Filmstudios zu suchen<br> 
                Du erhältst eine Übersicht der produzierten Filme</p>
          <form action="suchseite.php" method="POST" class="form-inline">
          <label class="sr-only" for="inlineforminput">Produktionsfirma</label>
            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
              <input type="search" name="studioname"  class="form-control" id="inlineforminput">
            </div> 
              <div class="form-group">
              <button  name="studio" type="submit" value="studio" class="btn mt-3 btn-info">Suche</button>
            </div>
          </form>
  </div>
 
      <div class="col-md-6 mb-3">
        <h2>Künstler:Innen</h2>
        <p>Du möchtest gerne wissen, in welchen Filmen ein bestimmter Künstler mitgespielt hat? <br> 
        Gib in der Suchmaske den Nachnamen<br></p>
      <form action="suchseite.php" method="POST" class="form-inline">
        <label class="sr-only" for="inlineforminput">Nachname Künstler:In</label>
        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
          <input type="search" name="nachname" class="form-control" id="inlineforminput">
        </div> 
        <div class="form-group">
          <button name="schauspieler" type="submit" value="schauspieler" class="btn mt-3 btn-info">Suche</button>
         </div>
       </form>
          </div>
        </div>
        </div>    
        </div>

 <!-- Verbindungsaufbau zur DB, über eingebundenes db-php-file bzw über die Instanz der abfrageDB-Klasse-->

<?php
require_once 'inc/db.php';
require_once 'abfragen/abfragenDB.php';

$abfrageDB = new \abfragen\AbfragenDB($connection); 

#SUCHE PRODUKTIONSFIRMA

if(!empty($_POST['studioname'])) {
  $sucheStudio = $abfrageDB->getFilmstudios($studioname = $_POST["studioname"]);
    if ($sucheStudio == NULL) { 
    ?>    
    <div class="container-md mt-5 text-center">
      <div class="row">    
        <div class="container md-6">
          <h3><?php echo "Keine Einträge zu '{$studioname}' gefunden"; ?></h3>
        </div>
      </div>
    </div>
       
<?php    
}else {
  ?>
  <div class="container mt-5">
  <div class="container-studio">
    <div class="container md-6">
    <h2>Suchergebnis Produktionsfirma</h2>
    <div class="table-responsive-sm">          
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Filmtitel</th>
            <th>Erscheinungsdatum</th>
            <th>Produktionsfirma</th>
          </tr>
        </thead>
      <tbody>
        <tr>
<?php
#Ausgabe der Suchergebnisse in der aufgerufenen Tabelle
 foreach($sucheStudio AS $row){ 
?>    
    <tr>
      <td><?php echo htmlspecialchars($row['Filmtitel'])?></td>
      <td><?php echo date('d.m.Y', strtotime($row['Erscheinungsdatum']))?></td>
      <td><?php echo htmlspecialchars($row['studioname'])?></td></tr>
    </tr>
  <?php 
  }
  ?>
      </tbody>
      </table>
    </div>
  </div>
  </div>
  </div>

<?php 
  }
} 

if((empty($_POST['studioname']) AND !empty($_POST['studio'])) OR (empty($_POST['nachname']) AND !empty($_POST['schauspieler']))) {
  ?>
  
      <div class="container-md mt-5 text-center">
        <div class="row">
          <div class="container md-12">
            <h3><?php echo "Bitte einen Suchbegriff eingeben"; ?></h3>
          </div>
        </div>
      </div>
      <?php
    }
 ?>




<?php    
# ==== SUCHE KUENSTLER:INNEN ======
if(!empty($_POST['nachname'])) {
  $sucheSchauspieler = $abfrageDB->getSchauspieler($nachname = $_POST["nachname"]);
    if ($sucheSchauspieler == NULL) { 
    ?>        
    <div class="container-md mt-5 text-center">
      <div class="row">
        <div class="container md-6">
          <h3><?php echo "Keine Einträge zu '{$nachname}' gefunden"; ?></h3>
        </div>
      </div>
    </div>
       
    <?php    
    } else {
    ?>
      <div class="container mt-5">
      <div class="container-studio">
        <div class="container md-6">
        <h2>Suchergebnis Künstler:Innen</h2>
        <div class="table-responsive-sm">          
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Filmtitel</th>
                <th>Vorname</th>
                <th>Nachname</th>
                <th>Produktionsfirma</th>
              </tr>
            </thead>
          <tbody>
            <tr>
<?php
#Ausgabe der Suchergebnisse in der aufgerufenen Tabelle
 foreach($sucheSchauspieler AS $row){ 
?>    
    <tr>
      <td><?php echo htmlspecialchars($row['Filmtitel'])?></td>
      <td><?php echo htmlspecialchars($row['vorname'])?></td>
      <td><?php echo htmlspecialchars($row['nachname'])?></td>
      <td><?php echo htmlspecialchars($row['studioname'])?></td>
    </tr>
  <?php 
  }
  ?>
      </tbody>
      </table>
    </div>
  </div>
  </div>
  </div>

<?php 
  }
} 
?>





<footer>
  <div class="container-md">
      <div class="row">
        <div id="footer" class="container-fluid p-4 text-white text-center">
        <nav id="footer-nav">
         
            <a href="aboutus.html">About Us</a>
          </nav>	
        <span>Funsite für Cineasten by Julia Beck (2022)</span>
        </div>
      </div>
    </div>
      </div>  
    </footer>



      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  </body>
</html>
