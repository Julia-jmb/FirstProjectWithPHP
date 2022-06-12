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