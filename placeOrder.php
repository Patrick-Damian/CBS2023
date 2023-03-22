<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);
?>
<?php include "header.php"; ?>
    <section>
        <div class="p-order">
            <h1>Thankyou for your order!</h1>
            <h3>PHP-2022-001</h3>
            <p>Order Code</p>
            <button onclick="location.href='products.php'" type="button" class="place-btn">Continue Shopping</button>
        </div>
    </section>

    <!-- Dapat yung ganto nakalagy sa ibang files. yung footer ihihiwalay na lang para malinis -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script> <!--Para mag dropwon yung menu-->

    <?php include "footer.php"; ?>