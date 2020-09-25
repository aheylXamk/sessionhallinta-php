<?php
session_start();            /* Session aloitus */
?> 

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Ot6</h2>

        <form class="form-signin" method="post" action="">
        <h3>Syötä tunnus ja salasana rekisteröityäksesi</h3>            <!-- Käyttäjä syöttää haluamansa tunnuksen ja salasanan -->
        <label for="tunnus" class="sr-only">Tunnus</label>
        <input type="text" id="tunnus" name="tunnus" class="form-control" placeholder="Kirjoita tunnus..." autofocus>
        <label for="salasana" class="sr-only">Salasana</label>
        <input type="password" id="salasana" name="salasana" class="form-control" placeholder="Kirjoita salasana...">
        <input type="password" id="salasana_uudelleen" name="salasana_uudelleen" class="form-control" placeholder="Kirjoita salasana uudelleen...">                     
        <input type="submit" class="btn btn-lg btn-primary btn-block" name="reknappi" value="Rekisteröidy">
        </form>
        <hr/>

        <form class="form-signin" method="post" action="">
        <h3>Mikäli olet jo rekisteröitynyt, ole hyvä ja kirjaudu</h3>           <!--Käyttäjä syöttää rekisteröimänsä tunnuksen ja salasanan -->
        <label for="tunnus" class="sr-only">Tunnus</label>
        <input type="text" id="tunnus" name="tunnus" class="form-control" placeholder="Kirjoita tunnus..." autofocus>
        <label for="salasana" class="sr-only">Salasana</label>
        <input type="password" id="salasana" name="salasana" class="form-control" placeholder="Kirjoita salasana...">                     
        <input type="submit" class="btn btn-lg btn-primary btn-block" name="loginnappi" value="Kirjaudu">
        </form>

    

    <?php

include("tietokantayhteys.php");        /*Luodaan yhteys */
if(isset($_REQUEST['reknappi']))     /*rekisteröintinapin painallus*/
{
	
	$tunnus=$_REQUEST['tunnus'];      /*Haetaan lomakkeelta tiedot */
	$salasana=$_REQUEST['salasana'];
    $salasanau=$_REQUEST['salasana_uudelleen'];
    
    if($salasana == $salasanau) {               /* Tarkistetaan, että käyttäjä on syöttänyt salasanan kaksi kertaa oikein, sen jälkeen salasana kryptataan ja tunnus ja salasana tallennetaan kayttajat-kantaan */

        $salattu = crypt($salasana,'st');

        $kysely=$yhteys->prepare("INSERT INTO kayttajat (tunnus,salasana) VALUES (:tunnus, :salasana)");  
	
        $kysely->bindParam(":tunnus",$tunnus);
        $kysely->bindParam(":salasana",$salattu);           /*Kerrotaan mikä tieto vastaa mitäkin kannassa */
        $kysely->execute();

	    echo "Rekisteröityminen onnistui!";


    } else {

        echo "Ensimmäisessä ja toisessa salasanan syöttökerrassa eroavaisuuksia. Varmista, että kirjoitit saman salasanan kumpaankin kenttään.";
    }
	
	
};

if(isset($_REQUEST['loginnappi'])) {        /* Kirjautumisnapin painallus */

    $tunnus=$_REQUEST['tunnus'];      /*Haetaan lomakkeelta tiedot */
    $salasana=$_REQUEST['salasana'];
    
    $kysely = $yhteys->prepare("SELECT salasana FROM kayttajat WHERE tunnus= :tunnus");             /* Etsitään salasana tunnuksen perusteella kannasta */

    $kysely->bindParam(":tunnus",$tunnus);
    $kysely->execute();
    $rivi=$kysely->fetch();

    $salasanak = $rivi['salasana'];
    $salasanac = crypt($salasana,'st');         /* Kryptataan käyttäjän lomakkeelle antama salasana ja verrataan kannan salasanaan */

    if($salasanak == $salasanac) {
        
        $_SESSION['tunnus'] = $_REQUEST['tunnus'];  /* Asetetaan nimi session-muuttujalle, tässä nimenä on 'tunnus' */
		 header("location:sivu.php");           /* Ohjataan seuraavalle sivulle */

    } else {

        echo "Virhe kirjautumisessa, ole hyvä ja tarkista tunnus ja salasana.";

    }


}

?>

</div>
</body>
</html>