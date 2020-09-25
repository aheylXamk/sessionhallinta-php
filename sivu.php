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

<?php
if(isset($_SESSION['tunnus'])) {                                        /* Tarkistetaan, että käyttäjä tulee ensimmäisen sivun kautta. Tarkistetaan siis sessionmuuttujan nimi */
		 echo "<h2> Tervetuloa " . $_SESSION['tunnus'] . "</h2>";           
}
else {
		echo "<h2>Ole hyvä ja kirjaudu sisään</h2><a href='rekisteroityminen.php'>Kirjaudu";
}

?>

</body>
</html>