<?php 
/**
 * Auslagerung der Logik in einen eigenen Namespace
 * 
 */
namespace abfragen; 
use PDO; 

class AbfragenDB{
  
#über eine magische Funktion wird die pdo-connection als Konstruktor übergeben
private $connection;
public function __construct(PDO $connection)
{
    $this->pdo = $connection; 
    
}
               
#Funktion für die Suche nach Filmstudios
    function getFilmstudios($studioname){
        if(!empty($this->pdo)){
           $gesuchtesFilmstudio = $this->pdo->prepare("SELECT ti.Filmtitel, ti.Erscheinungsdatum, st.studioname
           FROM filmstudio AS st
           INNER JOIN filmtitel AS ti ON st.idFilmstudio = ti.fk_idFilmstudio
           WHERE st.studioname LIKE :studioname
           ORDER BY ti.Erscheinungsdatum ASC;");  
           $gesuchtesFilmstudio->execute([
               ':studioname' => "%".$studioname."%"
            ]);
        }
        return $gesuchtesFilmstudio->fetchAll();
    }

#Funktion für die Suche nach Schauspielern
    function getSchauspieler($nachname){
      if(!empty($this->pdo)){
        $gesuchterSchauspieler = $this->pdo->prepare("SELECT sch.vorname, sch.nachname , ti.Filmtitel, st.studioname
            FROM schauspieler AS sch 
            INNER JOIN besetzung AS bes ON `idSchauspieler`=`schauspieler_idschauspieler`
            INNER JOIN filmtitel AS ti ON `idFilmtitel`=`Filmtitel_idFilmtitel`
            INNER JOIN filmstudio AS st ON `idFilmstudio`=`fk_idFilmstudio`
            WHERE sch.nachname LIKE :nachname;");
            $gesuchterSchauspieler->execute([
                ':nachname' => "%".$nachname."%"
            ]);
        }
        return $gesuchterSchauspieler->fetchAll(); 
    }
}

?>
