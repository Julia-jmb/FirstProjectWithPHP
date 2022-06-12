<?php 
/**
 * Auslagerung der Logik in einen eigenen Namespace
 * 
 */
namespace abfragen; 

class AbfragenDB{
               
#Funktion für die Suche nach Filmstudios
    function getFilmstudios($studioname){
        global $connection;
        if(!empty($connection)){
           $gesuchtesFilmstudio = $connection->prepare("SELECT ti.Filmtitel, ti.Erscheinungsdatum, st.studioname
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
      global $connection;
      if(!empty($connection)){
        $gesuchterSchauspieler = $connection->prepare("SELECT sch.vorname, sch.nachname , ti.Filmtitel, st.studioname
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