<?php
if(isset($_POST['gc'])){
    header('Location:gestionclient.php');
}
if(isset($_POST['gp'])){
    header('Location:gestionproduit.php');
}
if(isset($_POST['gcom'])){
    header('Location:gestioncommande.php');
}
if(isset($_POST['glcom'])){
    header('Location:gestionlignedecommande.php');
}
?>