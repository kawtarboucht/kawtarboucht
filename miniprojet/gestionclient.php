<!DOCTYPE html>
<head></head>
<body>
<?php
include 'components/connection.php';
session_start();
echo "Bonjour  ".$_SESSION['user_name'];


$select_user = $conn->prepare("SELECT * FROM `Client` ");
		$select_user->execute();
$row = $select_user->fetch(PDO::FETCH_ASSOC);
    echo "<table border='1px solid'>
        <tr>
        <th> ID</th>
        <th> Nom</th>
        <th> Tel</th>
        <th> Ville</th>
        <th> Adresse</th>
        <th> type</th>
        <th> password</th>
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

ID:<input type='text' name='id' ><br><br>
NOM:<input type='text' name='nom' ><br><br>
TEL:<input type='text' name='tel' ><br><br>
VILLE:<input type='text' name='ville' ><br><br>
ADRESSE:<input type='text' name='adresse' ><br><br>
TYPE:<input type='text' name='type' ><br><br>
PASSWORD:<input type='text' name='pwd' ><br><br><br>
<input type='submit' name='add' value='ajouter'>
<input type='submit' name='recherche' value='rechercher'>
<input type='submit' name='delete' value='supprimer'>
<input type='submit' name='modify' value='modifier'><br><br>"
;

$id=$_POST['id'];
    $name=$_POST['nom'];
    $tel=$_POST['tel'];
    $ville=$_POST['ville'];
    $adresse=$_POST['adresse'];
    $type=$_POST['type'];
    $pwd=$_POST['pwd'];
    if(isset($_POST['add'])){
    $insert_user = $conn->prepare("INSERT INTO Client (ID,Nom,Tel,Ville,Adresse,type,Password )
    VALUES (?,?,?,?,?,?,?)");
		$insert_user->execute([$id,$name,$tel,$ville,$adresse,$type,$pwd]);
        header('location: gestionclient.php');

}
if(isset($_POST['recherche'])){
    $research_user = $conn->prepare("SELECT * FROM Client WHERE ID = ?" );
		$research_user->execute([$id]);
        $row1 = $research_user->fetch(PDO::FETCH_ASSOC);
        echo "<table border='1px solid'>
        <tr>
        <th> ID</th>
        <th> Nom</th>
        <th> Tel</th>
        <th> Ville</th>
        <th> Adresse</th>
        <th> type</th>
        <th> password</th>
        </tr>";
        echo "<tr>";
        foreach ($row1 as $v) {
            echo "<td>".$v."</td>";
        }
        echo "</tr></table>"; 


}
if(isset($_POST['delete'])){
        $delete_user = $conn->prepare("DELETE FROM Client WHERE ID = ?");
        $delete_user->execute([$id]);
        header('location: gestionclient.php');
        
}
if(isset($_POST['modify'])){
   
        $update_user = $conn->prepare("UPDATE Client SET Nom=?, Tel=?, Ville=?, Adresse=?, type=?, Password=? WHERE ID=?");
        $update_user->execute([$name, $tel, $ville, $adresse, $type, $pwd, $id]);
        header('location: gestionclient.php');
    }
    
        









?>
<?php include 'components/alert.php'; ?>
</form>
</body>
</html>
