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
		$name = $_POST['name'];
		$name = filter_var($name, FILTER_SANITIZE_STRING);
		$login = $_POST['login'];
		$login = filter_var($login, FILTER_SANITIZE_STRING);
		$tel = $_POST['tel'];
		$tel = filter_var($tel, FILTER_SANITIZE_STRING);
		$ville = $_POST['ville'];
		$ville = filter_var($ville, FILTER_SANITIZE_STRING);
		$address = $_POST['address'];
		$address = filter_var($address, FILTER_SANITIZE_STRING);
		$pass = $_POST['pass'];
		$pass = filter_var($pass, FILTER_SANITIZE_STRING);
		$cpass = $_POST['cpass'];
		$cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

		$select_user = $conn->prepare("SELECT * FROM `Client` WHERE  ID = ?");
		$select_user->execute([$login]);
		$row = $select_user->fetch(PDO::FETCH_ASSOC);

		if ($select_user->rowCount() > 0) {
			$warning_msg[] = 'login already exist';
		}else{
			if($pass != $cpass){
				$warning_msg[] = 'confirm your password';
				
			}else{
				$insert_user = $conn->prepare("INSERT INTO `Client`(ID,Nom,Tel,Ville,Adresse,type,Password) VALUES(?,?,?,?,?,?,?)");
				$insert_user->execute([$login,$name,$tel,$ville,$address,0,$pass]);
				header('location: home.php');
				$select_user = $conn->prepare("SELECT * FROM `Client` WHERE ID = ? AND Password = ?");
				$select_user->execute([$login, $pass]);
				$row = $select_user->fetch(PDO::FETCH_ASSOC);
				if ($select_user->rowCount() > 0) {
					$_SESSION['user_id'] = $row['ID'];
					$_SESSION['user_name'] = $row['Nom'];
				}
			}
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
	<title>green tea - register now</title>
</head>
<body>
	<div class="main-container">
		<section class="form-container">
			<div class="title">
				<img src="img/download.png">
				<h1>register now</h1>
			</div>
			<form action="" method="post">
				<div class="input-field">
					<p>your name <sup>*</sup></p>
					<input type="text" name="name" required placeholder="enter your name" maxlength="50">
				</div>
				<div class="input-field">
					<p>your login<sup>*</sup></p>
					<input type="text" name="login" required placeholder="enter your login" maxlength="50" >
				</div>
				
				<div class="input-field">
					<p>your number <sup>*</sup></p>
					<input type="text" name="tel" required placeholder="enter your number" maxlength="50">
				</div>
				<div class="input-field">
					<p>your city <sup>*</sup></p>
					<input type="text" name="ville" required placeholder="enter your city" maxlength="50">
				</div>
				<div class="input-field">
					<p>your address <sup>*</sup></p>
					<input type="text" name="address" required placeholder="enter your address" maxlength="50">
				</div>
				<div class="input-field">
					<p>your password <sup>*</sup></p>
					<input type="password" name="pass" required placeholder="enter your password" maxlength="50" >
				</div>
				<div class="input-field">
					<p>confirm password <sup>*</sup></p>
					<input type="password" name="cpass" required placeholder="enter your password" maxlength="50" >
				</div>

				<input type="submit" name="submit" value="register now" class="btn">
				<p>already have an account? <a href="login.php">login now</a></p>
			</form>
		</section>
	</div>
	
	<?php include 'components/alert.php'; ?>
</body>
</html>