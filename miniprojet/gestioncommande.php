<!DOCTYPE html>
<head></head>
<body>
<?php
include 'components/connection.php';
session_start();
echo "Bonjour  ".$_SESSION['user_name'];


        $select_com = $conn->prepare("SELECT * FROM Commande");
		$select_com->execute();
        $row = $select_com->fetch(PDO::FETCH_ASSOC);
    echo "<table border='1px solid'>
        <tr>
        <th> Num</th>
        <th> Date</th>
        <th> Numclt</th>
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

Num:<input type='text' name='num' ><br><br>
Date:<input type='text' name='date' ><br><br>
Numclt:<input type='text' name='numclt' ><br><br><br>
<input type='submit' name='add' value='ajouter'>
<input type='submit' name='recherche' value='rechercher'>
<input type='submit' name='delete' value='supprimer'>
<input type='submit' name='modify' value='modifier'>"
;

  
$num=$_POST['num'];
$date=$_POST['date'];
$numclt=$_POST['numclt'];

if(isset($_POST['add'])){


    $insert_com = $conn->prepare("INSERT INTO Commande (Num,Date,Numclt)
    VALUES (?,?,?)");
		$insert_com->execute([$num,$date,$numclt]);
        header('location: gestioncommande.php');


}

if(isset($_POST['recherche'])){
    $research_com = $conn->prepare("SELECT * FROM Commande WHERE Num = ?" );
		$research_com->execute([$num]);
        $row1 = $research_com->fetch(PDO::FETCH_ASSOC);
        echo "<table border='1px solid'>
        <tr>
        <th> Num</th>
        <th> Date</th>
        <th> Numclt</th>
        </tr>";

        echo "<tr>";
        foreach ($row1 as $v) {
            echo "<td>".$v."</td>";
        }
        echo "</tr></table>"; 


}
if(isset($_POST['delete'])){
        $delete_com = $conn->prepare("DELETE FROM Commande WHERE Num = ?");
        $delete_com->execute([$num]);
        header('location: gestioncommande.php');
        
}
if(isset($_POST['modify'])){
   
        $update_com = $conn->prepare("UPDATE Commande SET Date=?, Numclt=? WHERE Num=?");
        $update_com->execute([$date, $numclt, $num]);
        header('location: gestioncommande.php');
    }
?>
<?php include 'components/alert.php'; ?>
</form>
</body>
</html>