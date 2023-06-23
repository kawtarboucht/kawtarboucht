<?php
 session_start();
 $bd=mysqli_connect('localhost','root','root','Magasin');
 
if(isset($_POST["connect"]) && isset($_POST["id"]) && isset($_POST["pwd"]) ){
    $_SESSION['login']=$_POST['id'];
    $_SESSION['mdp']=$_POST['pwd'];
    if($bd){
        $id=$_POST["id"];
        $pwd=$_POST["pwd"];
     $sql="SELECT * FROM Client WHERE ID='$id' AND Password='$pwd' AND type='1'";
     $rep=mysqli_query($bd,$sql);
     if(mysqli_num_rows($rep)==1){
        
     header('location:gestionadmin.php');
     }
     else echo "infos incorrectes";
    }
    else echo "echec de connexion";

}
?>