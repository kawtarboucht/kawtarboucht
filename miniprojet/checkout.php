<?php 
 include 'components/connection.php';
 session_start();
 if (isset($_SESSION['user_id'])) {
		$user_id = $_SESSION['user_id'];
	}else{
		$user_id = '';
	}

	if (isset($_POST['logout'])) {
		session_destroy();
		header("location: login.php");
	}
	if (isset($_POST['place_order'])) {

		
		$date = time();

		
		$varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?");
		$varify_cart->execute([$user_id]);

		if (isset($_GET['get_id'])) {
			$get_product = $conn->prepare("SELECT * FROM `Produit` WHERE Référence=? LIMIT 1");
			$get_product->execute([$_GET['get_id']]);
			if ($get_product->rowCount() > 0) {
				while($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)){
					$insert_order = $conn->prepare("INSERT INTO `Commande`(Date,Numclt) VALUES(?,?)");
			        $insert_order->execute([$date,$user_id]);
					$n = $conn->lastInsertId();
					$insert_order2 = $conn->prepare("INSERT INTO `Lignedecommande`(Refprod,Numcmd,Quantité) VALUES(?,?,?)");
			        $insert_order2->execute([$fetch_p['Référence'],$n,1]);

			            header('location:home.php');
					
					
				}
			}else{
				$warning_msg[] = 'somthing went wrong';
			}
		}elseif ($varify_cart->rowCount()>0) {
			while($f_cart = $varify_cart->fetch(PDO::FETCH_ASSOC)){
				$insert_order = $conn->prepare("INSERT INTO `Commande`(Date,Numclt) VALUES(?,?)");
				$insert_order->execute([$date,$user_id]);
				$n = $conn->lastInsertId();
				$insert_order2 = $conn->prepare("INSERT INTO `Lignedecommande`(Refprod,Numcmd,Quantité) VALUES(?,?,?)");
				$insert_order2->execute([$f_cart['product_id'],$n,$f_cart['quantite']]);
			            header('location:home.php');
			}
			if ($insert_order) {
				$delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
				$delete_cart_id->execute([$user_id]);
				header('location: home.php');
			}
		}else{
			$warning_msg[] = 'somthing went wrong';
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
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<title>Green Coffee - checkout page</title>
</head>
<body>
	<?php include 'components/header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>checkout summary</h1>
		</div>
		<div class="title2">
			<a href="home.php">home </a><span>/ checkout summary</span>
		</div>
		<section class="checkout">
			<div class="title">
				<img src="img/download.png" class="logo">
				<h1>checkout summary</h1>
				
            </div>
                <div class="row">
                	<form method="post">
                		<h3>billing details</h3>
                		<div class="flex">
                			<div class="box">
                				<div class="input-field">
                					<p>your login <span>*</span></p>
                					<input type="text" name="login" required maxlength="50" placeholder="Enter Your name" class="input">
                				</div>
                				<div class="input-field">
                					<p>your number <span>*</span></p>
                					<input type="number" name="number" required maxlength="10" placeholder="Enter Your number" class="input">
                				</div>
                				<div class="input-field">
                					<p>your email <span>*</span></p>
                					<input type="email" name="email" required maxlength="50" placeholder="Enter Your email" class="input">
                				</div>
                				<div class="input-field">
                					<p>payment method <span>*</span></p>
                					<select name="method" class="input">
                						<option value="cash on delivery">cash on delivery</option>
                						
                					</select>
                				</div>
                				
                			</div>
                			
                		</div>
                		<button type="submit" name="place_order" class="btn">place order</button>
                	</form>
                	<div class="summary">
                		<h3>my bag</h3>
                		<div class="box-container">
                			<?php 
                				$grand_total=0;
                				if (isset($_GET['get_id'])) {
                					$select_get = $conn->prepare("SELECT * FROM `Produit` WHERE Référence=?");
                					$select_get->execute([$_GET['get_id']]);
                					while($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)){
                						$sub_total = $fetch_get['Prix'];
                						$grand_total+=$sub_total;
                					
                			?>
                			<div class="flex">
                				<img src="img1/<?=$fetch_get['Référence']; ?>" class="image">
                				<div>
                					<h3 class="name"><?=$fetch_get['Désignation']; ?></h3>
                					<p class="price"><?=$fetch_get['Prix']; ?></p>
                				</div>
                			</div>
                			<?php 
                					}
                				}else{
                					$select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?");
                					$select_cart->execute([$user_id]);
                					if ($select_cart->rowCount()>0) {
                						while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                							$select_products=$conn->prepare("SELECT * FROM `Produit` WHERE Référence=?");
                							$select_products->execute([$fetch_cart['product_id']]);
                							$fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
                							$sub_total= ($fetch_cart['quantite'] * $fetch_product['Prix']);
                							$grand_total += $sub_total;
                						
                			?>
                			<div class="flex">
                				<img src="img1/<?=$fetch_product['Référence']; ?>">
                				<div>
                					<h3 class="name"><?=$fetch_product['Désignation']; ?></h3>
                					<p class="price"><?=$fetch_product['Prix']; ?> X <?=$fetch_cart['quantite']; ?></p>
                				</div>
                			</div>
                			<?php 
                						}
                					}else{
                						echo '<p class="empty">your cart is empty</p>';
                					}
                				}
                			?>
                		</div>
                		<div class="grand-total"><span>total amount payable: </span>MAD<?= $grand_total ?></div>
                	</div>
			</div>
		</section>
		<?php include 'components/footer.php'; ?>
	</div>
	<script src="script.js"></script>
	<?php include 'components/alert.php'; ?>
</body>
</html>