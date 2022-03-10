<?php
include 'head.php';
include 'config.php';
echo '<div class="info"></div>';
session_start();
if(isset($_SESSION["utilizator"])) {
    $utilizator = $_SESSION["utilizator"];
    $link = ($_GET['link']);
    //get the first word from link
    $tema = strtok($link, " ");
    $_SESSION["tema"]=$tema;
    $id_tema=mysqli_query($conn, "SELECT id FROM tema WHERE titlu = '$tema'");
    $row=mysqli_fetch_row($id_tema);
    $id_tema = $row[0];
    $id_user=mysqli_query($conn, "SELECT id FROM utilizatori WHERE username = '$utilizator'");
    $row1=mysqli_fetch_row($id_user);
    $id_user = $row1[0];
    $query=mysqli_query($conn,"SELECT iduser, idtema FROM voturi WHERE idtema = '$id_tema' AND iduser='$id_user'");
    if (mysqli_num_rows($query) > 0) {
        echo "Ai votat deja la aceasta tema";
    } else {
    $id_intreb=mysqli_query($conn, "SELECT id, intrebare FROM tema WHERE titlu = '$tema'");
    $row=mysqli_fetch_row($id_intreb);
    $id = $row[0];
    $intrebare = $row[1];
    $array = array();
    $variante = mysqli_query($conn, "SELECT variant FROM variante WHERE idtema = '$id'");
    while ($row = mysqli_fetch_row($variante)) {
        array_push($array, $row[0]);
    }
    echo '<div class="alert alert-info" role="alert">
    Intrebare din domeniul: ' . $tema . " este " . $intrebare . 
  '</div>' ;
  echo '
  <div class="container overflow-hidden">
  <div class="row gx-5">
    <div class="col">
      <div class="p-3 border bg-light"> 
      
';
echo '<div>
<form name="vot" action="after_vot.php" method="POST">
<div class="form-group"> 
<input type="radio" name="vot" value="1">'; echo $array[0];
echo '
</div>
<div class="form-group"> 
<input type="radio" name="vot" value="2">'; echo $array[1];
echo '
</div>
<div class="form-group"> 
<input type="radio" name="vot" value="3">'; echo $array[2];
echo '
</div>
<button type="submit" class="btn btn-primary">Votez</button>
</form>
</div>';
}
}
?>