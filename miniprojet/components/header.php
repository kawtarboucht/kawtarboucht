<header class="header">
	<div class="flex">
		<a href="home.php" class="logo"><img src="img/logo.png"></a>
		<nav class="navbar">
			<a href="home.php">home</a>
			<a href="view_products.php">products</a>
			<a href="about.php">about us</a>
			<a href="contact.php">contact us</a>
		</nav>
		<div class="icons">
			<i class="bx bxs-user" id="user-btn"></i>
			
			<?php
				$count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
				$count_cart_items->execute([$user_id]);
				$total_cart_items = $count_cart_items->rowCount();
			?>
			<a href="cart.php" class="cart-btn"><i class="bx bx-cart-download"></i><sup><?=$total_cart_items ?></sup></a>
			<i class='bx bx-list-plus' id="menu-btn" style="font-size: 2rem;"></i>
		</div>
		<div class="user-box">
    <p>username : <span><?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?></span></p>
     <a href="login.php" class="btn" style="color: #000;">login</a>
    <a href="register.php" class="btn" style="color: #000;">register</a>
    <form method="post">
        <button type="submit" name="logout" class="logout-btn">log out</button>
    </form>
</div>

	</div>
</header>