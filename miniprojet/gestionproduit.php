<?php
include 'components/connection.php';
session_start();
echo "Bonjour  ".$_SESSION['user_name'];

$select_user = $conn->prepare("SELECT * FROM `Produit` ");
		$select_user->execute();
$row = $select_user->fetch(PDO::FETCH_ASSOC);
    echo "<table border='1px solid'>
        <tr>
        <th> Référence</th>
        <th> Prix</th>
        <th> Désignation</th>
        <th> Catégorie</th>
        <th> Prixacquisition</th>
        </tr>";
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>".$value."</td>";
        }
        echo "</tr>"; 

        while ($row = $select_user->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            
            foreach ($row as $val) {
                echo "<td>".$val."</td>";
            }
            echo "</tr>";
        }
    echo "</table><br><br>"; 
    echo "<form method='post' action=''>

    Référence:<input type='text' name='ref' ><br><br>
    Prix:<input type='text' name='prix' ><br><br>
    Désignation:<input type='text' name='design' ><br><br>
    Catégorie:<input type='text' name='cat' ><br><br>
    Prixacquisition:<input type='text' name='prixacq' ><br><br>
 <input type='submit' name='add' value='ajouter'>
 <input type='submit' name='recherche' value='rechercher'>
 <input type='submit' name='delete' value='supprimer'>
 <input type='submit' name='modify' value='modifier'><br><br>"
;
    $ref=$_POST['ref'];
    $prix=$_POST['prix'];
    $design=$_POST['design'];
    $cat=$_POST['cat'];
    $prixacq=$_POST['prixacq'];
    if(isset($_POST['add'])){
        $insert_user = $conn->prepare("INSERT INTO Produit (Référence,Prix,Désignation,Catégorie,Prixacquisition )
        VALUES (?,?,?,?,?)");
            $insert_user->execute([$ref,$prix,$design,$cat,$prixacq]);
            header('location: gestionproduit.php');
    
    }
    if(isset($_POST['recherche'])){
        $research_user = $conn->prepare("SELECT * FROM Produit WHERE Référence = ?" );
            $research_user->execute([$ref]);
            $row1 = $research_user->fetch(PDO::FETCH_ASSOC);
            echo "<table border='1px solid'>
            <tr>
            <th> Référence</th>
            <th> Prix</th>
            <th> Désignation</th>
            <th> Catégorie</th>
            <th> Prixacquisition</th>
            </tr>";
            echo "<tr>";
            foreach ($row1 as $v) {
                echo "<td>".$v."</td>";
            }
            echo "</tr></table>"; 
    
    
    }
    if(isset($_POST['delete'])){
        $delete_user = $conn->prepare("DELETE FROM Produit WHERE Référence = ?");
        $delete_user->execute([$ref]);
        header('location: gestionproduit.php');
        
}
if(isset($_POST['modify'])){
   
        $update_user = $conn->prepare("UPDATE Produit SET  Prix=?, Désignation=?, Catégorie=?, Prixacquisition=? WHERE Référence=?");
        $update_user->execute([$prix,$design,$cat,$prixacq, $ref]);
        header('location: gestionproduit.php');
    }
    
?>