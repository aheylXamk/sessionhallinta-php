<?php

$yhteys = "mysql:host=localhost;dbname=rekisteroityneet"; 			/*Ohjelma hakee tietokannan taulusta tiedot */
$tunnus = "root";
$salasana = "";

try {
	$yhteys = new PDO($yhteys, $tunnus, $salasana); 
	$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			/* Muodostaa yhteyden */
	$yhteys->exec("SET CHARACTER SET utf8;");
}

	
catch (PDOException $e) {
	die("Tietokantaan ei saada yhteyttä. Virhe: ".$e);
}
?>