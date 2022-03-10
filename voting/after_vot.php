<?php
include 'head.php';
include 'config.php';
session_start();
if(isset($_SESSION["utilizator"]) && isset($_SESSION["tema"])) {
    $utilizator = $_SESSION["utilizator"];
    $tema = $_SESSION["tema"];
    if (isset($_POST["vot"])) {
        $vot = $_POST["vot"];
        if($tema=="politica") {
            if($vot=="1") {
                $raspuns = "UDMR";
            }
            if($vot=="2") {
                $raspuns = "USR";
            }
            if($vot=="3") {
                $raspuns = "PNL";
            }
        } else if($tema=="dermatologie") {
            if($vot=="1") {
                $raspuns = "Sensibila";
            }
            if($vot=="2") {
                $raspuns = "Uscata";
            }
            if($vot=="3") {
                $raspuns = "Mixta";
            }
        } else if($tema="gastronomie") {
            if($vot=="1") {
                $raspuns = "Pizza";
            }
            if($vot=="2") {
                $raspuns = "Paste";
            }
            if($vot=="3") {
                $raspuns = "Inghetata";
            }
        }
        $update_vot = mysqli_query($conn, "UPDATE variante SET voturi = voturi + 1 WHERE variant = '$raspuns'");
        if(mysqli_affected_rows($conn) > 0 ) {
            echo '
            <div class="alert alert-info" role="alert">
             Ati votat cu succes!
            </div>';
            $id_i=mysqli_query($conn, "SELECT id FROM tema WHERE titlu = '$tema'");
            $row1=mysqli_fetch_row($id_i);
            $id_tema = $row1[0];
            $id_u=mysqli_query($conn, "SELECT id FROM utilizatori WHERE username = '$utilizator'");
            $row2=mysqli_fetch_row($id_u);
            $id_user = $row2[0];
            $id_variant=mysqli_query($conn, "SELECT id FROM variante WHERE variant = '$raspuns'");
            $row3=mysqli_fetch_row($id_variant);
            $id_var = $row3[0];
            $prep = $conn->prepare("INSERT INTO voturi (idtema,iduser,idvariante) VALUES (?, ?, ?)");
            $prep->bind_param("iii",$id_tema, $id_user, $id_var);
            $prep->execute();
            $prep->close();
            $message = "Ati votat cu succes\r\nVa multumim\r\nO zi placuta!";
            $message = wordwrap($message, 70, "\r\n");
            //mail('$utilizator', 'My Vot', $message);
        } else {
            echo '<div class="alert alert-danger" role="alert">
            Votul nu a putut fi inregistrat!
           </div>';
        }
    $array = array();
    $variante = mysqli_query($conn, "SELECT voturi,variant FROM variante WHERE idtema = '$id_tema'");
    while ($row = mysqli_fetch_row($variante)) {
        $voturi = $row[0];
        $array[$voturi] = array();
        $array[$voturi]["variant"]=$row[1];
    } 
    krsort($array);
    echo '<ul class="list-group">';
    foreach($array as $k => $v){
	echo '<li class="list-group-item">';
	if(isset($_SESSION["utilizator"])){
		echo '<div class="d-flex justify-content-center align-items-center">';
		echo '<div class="d-flex flex-column align-items-center">';
		echo "<div>".$v["variant"]."</div>";
		echo '</div>';
	}
	echo '</li>';
}
echo "</ul>";
    }
}
?>