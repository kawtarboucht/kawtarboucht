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
   

    
   if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);

    $varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $varify_cart->execute([$user_id, $product_id]);

    $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $max_cart_items->execute([$user_id]);

    if ($varify_cart->rowCount() > 0) {
        $warning_msg[] = 'product already exist in your cart';
    }else if ($max_cart_items->rowCount() > 20) {
        $warning_msg[] = 'cart is full';
    }else{
        $select_price = $conn->prepare("SELECT * FROM `Produit` WHERE Référence = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id,product_id,prix,quantite) VALUES(?,?,?,?)");
        $insert_cart->execute([ $user_id, $product_id, $fetch_price['Prix'], $qty]);
        $success_msg[] = 'product added to cart successfully';
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
	<title>Green Coffee - shop page</title>
    </head>
    <body>
	<?php include 'components/header.php'; ?>
	<div class="main">
		<div class="banner">
			<h1>Vegetables</h1>
		</div>
		<div class="title2">
			<a href="home.php">home </a>
		</div>
		<section class="products">
			<div class="box-container">
            <?php 
					$search = $conn->prepare("SELECT * FROM Produit WHERE Catégorie = 'flower'");
                    $search->execute();
					if ($search->rowCount() > 0) {
						while ($s_result = $search->fetch(PDO::FETCH_ASSOC)) {
						
			?>
            <form action="" method="post" class="box">
					<img src="img1/<?=$s_result['Référence']; ?>" class="img">
					<div class="button">
						<button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
						<a href="view_page.php?pid=<?php echo $s_result['Référence']; ?>" class="bx bxs-show"></a>
					</div>
					<h3 class="name"><?=$s_result['Désignation']; ?></h3>
					<input type="hidden" name="product_id" value="<?=$s_result['Référence']; ?>">
					<div class="flex">
						<p class="price">Price: MAD<?=$s_result['Prix']; ?></p>
						<input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
					</div>
					<a href="checkout.php?get_id=<?=$s_result['Référence']; ?>" class="btn">buy now</a>

				</form>
                <?php 
						}
					}else{
						echo '<p class="empty">no products are added yet!</p>';
					}
				?>
			</div>
		</section>
		<?php include 'components/footer.php'; ?>
        </div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include 'components/alert.php'; ?>
</body>
</html>