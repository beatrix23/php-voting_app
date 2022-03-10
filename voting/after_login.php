<?php
include 'head.php';
include 'config.php';
function sanitizare($string) {
    $string=trim($string);
    $string=stripslashes($string);
    $string=htmlspecialchars($string);
    return $string;
}
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $utilizator = htmlentities($_POST["username"]);
    $parola = md5(htmlentities($_POST["passw"]));
    $exista_utilizator = mysqli_query($conn, "SELECT username FROM utilizatori where username = '$utilizator' AND parola = '$parola'");
    if (mysqli_num_rows($exista_utilizator) > 0) {
        echo ' Log In realizat cu succes!';
        session_start();
        $_SESSION["utilizator"] = $utilizator;
        $array = array();
        $teme = mysqli_query($conn, "SELECT * FROM tema");
    while ($row = mysqli_fetch_row($teme)) {
        $tema = $row[0];
        $array[$tema] = array();
        $array[$tema]["titlu"]=$row[1];
        $array[$tema]["intrebare"]=$row[2];
    } 
    echo '<ul class="list-group">';
    foreach($array as $k => $v){
	echo '<li class="list-group-item">';
	if(isset($_SESSION["utilizator"])){
		echo '<div class="d-flex justify-content-center align-items-center">';
		echo '<div class="d-flex flex-column align-items-center">';
		echo "<div>".$v["titlu"]."</div>";
        echo '<a href="tema_intrebare.php?link=' . $v["titlu"].' class="link-info">Votati aceasta tema</a>';
		echo '</div>';
	}
	echo '</li>';
    echo "</ul>";
    }
    if (mysqli_num_rows($exista_utilizator) == 0) {
        echo " Ati gresit numele de utilizator sau parola! ";
        echo '<a href="login.php">Log in</a>';
    }
} else {
    echo 'Trebuia sa ve logati pentru a putea intra in pagina!';
    echo '<a href="login.php">Log in</a>';
}
}
?>