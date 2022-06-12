<?php 
/**
 * Datenverbindung über PDO
 */
    $server = "mysql:host=127.0.0.1;dbname=filmverwaltung;charset=utf8";
    $dbname = "filmverwaltung";
    $user = "root";
    $passwort = "";
    try {
       $connection = new PDO($server, $user, $passwort);
       $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
       catch(PDOException $e){
       print $e->getMessage();
        }
?>



/**
* --------------------------------------
----- Erstellen der Datenbank --------
--------------------------------------
CREATE DATABASE filmverwaltung; 

--------------------------------------
---- Verwendung der DB festlegen -----
--------------------------------------
USE filmverwaltung;

--------------------------------------
---- Erstellen der ersten Tablelle ---
--------------------------------------
CREATE TABLE `filmstudio` (
  `idFilmstudio` INT NOT NULL AUTO_INCREMENT,
  `studioname` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idFilmstudio`)
) ENGINE = InnoDB;

--------------------------------------
------- Datensätze erfassen ----------
--------------------------------------
INSERT INTO filmstudio (studioname) 
VALUES 	('Bavaria Filmstudios'),
		('Great American Films'),
		('Touchstondes Pictures'),
        ('Warner Brothers Pictures');
        
--------------------------------------
---- Erstellen der zweiten Tablelle ---
--------------------------------------
CREATE TABLE `filmtitel` (
  `idFilmtitel` INT AUTO_INCREMENT,
  `Filmtitel` VARCHAR(45) NOT NULL,
  `Erscheinungsdatum` DATE NOT NULL,
  `fk_idFilmstudio` INT NOT NULL,
  PRIMARY KEY (`idFilmtitel`),
  CONSTRAINT `fk_idFilmstudio`
	FOREIGN KEY(`fk_idFilmstudio`) REFERENCES `filmstudio`(`idFilmstudio`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT
) ENGINE = InnoDB;

---------------------------------------
--- Erfassen der Datensätze ----------
---------------------------------------
INSERT INTO filmtitel (idFilmtitel, Filmtitel, Erscheinungsdatum, fk_idFilmstudio) 
VALUES 	(3000,'Dirty Dancing', '1992-05-29', 3),
		(3001,'Sicter Act', '1992-05-29', 3),
        (3002, 'Harry Potter u. der Stein der Weisen', '2001-11-23', 4),
        (3003, 'Casanova', '2006-02-09', 3),
        (3004, 'Die unendliche Geschichte', '1984-05-20', 1),
        (3005,'Die Welle', '2008-03-13', 1),
        (3006, 'Krieg in Chinatown', '1987-09-25', 2),
        (3007, 'I Am Legend', '2008-01-10', 4),
        (3008, 'Transcendence', '2014-04-18', 4)	
;

-- -----------------------------------------------------
---- Erweiterung, um die Tabelle Schauspieler ----------
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `filmverwaltung`.`schauspieler` (
  `idschauspieler` INT NOT NULL AUTO_INCREMENT,
  `vorname` VARCHAR(45) NOT NULL,
  `nachname` VARCHAR(45) NOT NULL,
  `herkunftsland` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idschauspieler`))
ENGINE = InnoDB;

---------------------------------------
--- Erfassen der Datensätze ----------
---------------------------------------
INSERT INTO schauspieler (vorname, nachname, herkunftsland) 
VALUES ('Whoopie', 'Goldberg', 'USA'),
	('Jennifer','Grey','USA'),
    ('Patrick','Swayze','USA'),
    ('Jürgen','Vogel','Deutschland'),
    ('Will','Smith','USA'),
    ('Emma','Thompson','USA'),
    ('Heath','Ledger','USA'),
    ('Sienna','Miller','USA'),
     ('Frederic','Lau','Deutschland');

---------------------------------------------------------------
--- Auslösung der m:n Beziehung durch eine Zwischentabelle ---
---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `filmverwaltung`.`besetzung` (
  `schauspieler_idschauspieler` INT NOT NULL,
  `Filmtitel_idFilmtitel` INT NOT NULL,
  `idbesetzung` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idbesetzung`),
  INDEX `fk_schauspieler_has_Filmtitel_Filmtitel1_idx` (`Filmtitel_idFilmtitel` ASC) VISIBLE,
  INDEX `fk_schauspieler_has_Filmtitel_schauspieler1_idx` (`schauspieler_idschauspieler` ASC) VISIBLE,
  CONSTRAINT `fk_schauspieler_has_Filmtitel_schauspieler1`
    FOREIGN KEY (`schauspieler_idschauspieler`)
    REFERENCES `filmverwaltung`.`schauspieler` (`idschauspieler`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_schauspieler_has_Filmtitel_Filmtitel1`
    FOREIGN KEY (`Filmtitel_idFilmtitel`)
    REFERENCES `filmverwaltung`.`Filmtitel` (`idFilmtitel`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

---------------------------------------
--- Abfrage-Statement Schauspieler -----
---------------------------------------
SELECT s.vorname AS Vorname, s.nachname AS Nachname, f.Filmtitel, fs.studioname AS Produktionsfirma
FROM schauspieler AS s 
INNER JOIN besetzung AS b ON `idSchauspieler`=`schauspieler_idschauspieler`
INNER JOIN filmtitel AS f ON `idFilmtitel`=`Filmtitel_idFilmtitel`
INNER JOIN filmstudio AS fs ON `idFilmstudio`=`fk_idFilmstudio`
WHERE s.nachname LIKE 'x%';

---------------------------------------
---- Abfrage-Statement Filmstudio -----
---------------------------------------
SELECT f.Filmtitel, DATE_Format(f.Erscheinungsdatum, '%d. %m. %Y') AS Erscheinungsdatum, s.studioname AS Produktionsfirma 
FROM filmstudio AS s
INNER JOIN filmtitel AS f ON idFilmstudio=fk_idFilmstudio
WHERE s.studioname LIKE "%avaria%"
ORDER BY f.erscheinungsdatum ASC;
*
*/
