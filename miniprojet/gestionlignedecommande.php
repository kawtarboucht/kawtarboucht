<!DOCTYPE html>
<head></head>
<body>
<?php
include 'components/connection.php';
session_start();
echo "Bonjour  ".$_SESSION['user_name'];


        $select_com = $conn->prepare("SELECT * FROM Lignedecommande");
		$select_com->execute();
        $row = $select_com->fetch(PDO::FETCH_ASSOC);
    echo "<table border='1px solid'>
        <tr>
        <th> Refprod</th>
        <th> Numcmd</th>
        <th> Quantité</th>
        </tr>";

        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>".$value."</td>";
        }
        echo "</tr>"; 

        while ($row = $select_com->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            
            foreach ($row as $val) {
                echo "<td>".$val."</td>";
            }
            echo "</tr>";
        }
    echo "</table><br><br>"; 
    
     

 echo "<form method='post' action=''>

Refprod:<input type='text' name='refprod' ><br><br>
Numcmd:<input type='text' name='numcmd' ><br><br>
Quantité:<input type='text' name='quantité' ><br><br><br>
<input type='submit' name='add' value='ajouter'>
<input type='submit' name='recherche' value='rechercher'>
<input type='submit' name='delete' value='supprimer'>
<input type='submit' name='modify' value='modifier'>"
;


$refprod=$_POST['refprod'];
$numcmd=$_POST['numcmd'];
$quantit=$_POST['quantité'];
if(isset($_POST['add'])){
    

   
    $insert_com = $conn->prepare("INSERT INTO Lignedecommande (Refprod,Numcmd,Quantité)
    VALUES (?,?,?)");
		$insert_com->execute([$refprod,$numcmd,$quantit]);
        header('location: gestionlignedecommande.php');


}
if(isset($_POST['recherche'])){
    $research_com = $conn->prepare("SELECT * FROM Lignedecommande WHERE Refprod = ?" );
		$research_com->execute([$refprod]);
        $row1 = $research_com->fetch(PDO::FETCH_ASSOC);
        echo "<table border='1px solid'>
        <tr>
        <th> Refprod</th>
        <th> Numcmd</th>
        <th> Quantité</th>
        </tr>";

        echo "<tr>";
        foreach ($row1 as $v) {
            echo "<td>".$v."</td>";
        }
        echo "</tr></table>"; 


}
if(isset($_POST['delete'])){
        $delete_com = $conn->prepare("DELETE FROM Lignedecommande WHERE Refprod = ?");
        $delete_com->execute([$refprod]);
        header('location: gestionlignedecommande.php');
        
}
if(isset($_POST['modify'])){
   
        $update_com = $conn->prepare("UPDATE Lignedecommande SET Numcmd=?, Quantité=? WHERE Refprod=?");
        $update_com->execute([$numcmd, $quantit, $refprod]);
        header('location: gestionlignedecommande.php');
    }
?>
<?php include 'components/alert.php'; ?>
</form>
</body>
</html>