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
  
<header>
   <div class="container-fluid p-5 text-white text-center">
    <h1>Filmverwaltung</h1>
    <p>Herzlich Willkommen, ihr Cineasten</p> 
  </div>
</header>

<article>
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
              <input type="search" name="studioname" class="form-control" id="inlineforminput">
            </div> 
              <div class="form-group">
              <button  name="search" type="submit" class="btn mt-3 btn-info">Suche</button>
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
          <button name="search" type="submit" class="btn mt-3 btn-info">Suche</button>
         </div>
       </form>
          </div>
        </div>
        </article>  

<!-- Verbindungsaufbau zur DB, über eingebundenes db-php-file -->
<?php
require_once 'inc/db.php';
require_once 'abfragen/abfragenDB.php';

$abfrageDB = new \abfragen\AbfragenDB(); 

if(!empty($_POST["studioname"])){
  $sucheStudio = $abfrageDB->getFilmstudios($studioname = $_POST["studioname"]);?>
  <div class="container mt-5">
      <div class="container-studio">
       <div class="container md-6">
           <h2>Suchergebnis Filmtitel</h2>
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
<?php  
    foreach($sucheStudio as $row){
?>
        <tr>
            <td><?php  echo $row["Filmtitel"]; ?></td>
            <td><?php echo date('d.m.Y', strtotime($row['Erscheinungsdatum'])); ?></td>
            <td><?php echo $row['studioname'];?></td></tr>
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
} elseif (!empty($sucheStudio)) {
    echo "Keine Einträge zu diesem Studio gefunden!";

} elseif  (!empty($_POST["nachname"])){
  $sucheSchauspieler = $abfrageDB->getSchauspieler($nachname = $_POST["nachname"]);
?>
  <div class="container mt-5">
  <div class="container-schauspieler">
    <div class="container md-6">
    <h2>Suchergebnis Künstler:Innen</h2>
    <div class="table-responsive-sm">          
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Vorname</th>
            <th>Nachname</th>
            <th>Filmtitel</th>
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
      <td><?php echo $row['vorname'] ?></td>
      <td><?php echo htmlspecialchars($row['nachname']) ?></td>
      <td><?php echo htmlspecialchars($row['Filmtitel'])?></td>
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

} elseif (!empty($sucheSchauspieler)){
  echo "Keine Einträge zu diesem Künstler gefunden!";

#beenden der elseif-Anweisung
} else {
?> 
  <div class="container-md mt-5 text-center">
    <div class="row">
      <div class="container md-12">
        <h3><?php echo "Bitte einen Suchbegriff eingeben"; ?></h3>
      </div>
    </div>
  </div>
 
<?php
#beenden der else-Anweisung 
}
?>


<!-- Footer-Bereich -->

<footer id="footer">
	<div class="container-md">
		<div class="row">
      <div id="footer" class="container-fluid mt-5 pb-4 text-white text-center">
       <nav id="footer-nav">
				<a href="aboutus.html">About Us</a>
			 </nav>	
       <span>Funsite für Cineasten by Julia Beck (2022)</span>
			</div>
		</div>
	</div>
</footer>
 

  </body>
</html>