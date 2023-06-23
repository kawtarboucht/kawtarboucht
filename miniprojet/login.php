<?php 
	include 'components/connection.php';
	session_start();

	if (isset($_SESSION['user_id'])) {
		$user_id = $_SESSION['user_id'];
	}else{
		$user_id = '';
	}
  
	//register user
	if (isset($_POST['submit'])) {

		$login = $_POST['login'];
		$login = filter_var($login, FILTER_SANITIZE_STRING);
		$pass = $_POST['pass'];
		$pass = filter_var($pass, FILTER_SANITIZE_STRING);

		$select_user = $conn->prepare("SELECT * FROM `Client` WHERE  ID= ? AND Password = ?");
		$select_user->execute([$login, $pass]);
		$row = $select_user->fetch(PDO::FETCH_ASSOC);
		$type=$row['type'];
		
		if ($select_user->rowCount()> 0 && $type == 0) {
			$_SESSION['user_id'] = $row['ID'];
			$_SESSION['user_name'] = $row['Nom'];
			header('location: home.php');

		}
			
		if ($select_user->rowCount()> 0 && $type == 1) {
			$_SESSION['user_id'] = $row['ID'];
			$_SESSION['user_name'] = $row['Nom'];
			header('location: gestionadmin.php');

		}
		
		
	}

?>
<style type="text/css">
	<?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>green tea - login now</title>
</head>
<body>
	<div class="main-container">
		<section class="form-container">
			<div class="title">
				<img src="img/download.png">
				<h1>login now</h1>
			</div>
			<form action="" method="post">
				<div class="input-field">
					<p>your login <sup>*</sup></p>
					<input type="text" name="login" required placeholder="enter your login" maxlength="50" >
				</div>
				<div class="input-field">
					<p>your password <sup>*</sup></p>
					<input type="password" name="pass" required placeholder="enter your passwod" maxlength="50" >
				</div>
				
				<input type="submit" name="submit" value="login now" class="btn">
				<p>do not have an account? <a href="register.php">register now</a></p>
			</form>
		</section>
	</div>
	
	<?php include 'components/alert.php'; ?>
</body>
</html>