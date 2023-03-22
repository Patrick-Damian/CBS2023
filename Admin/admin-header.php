<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>CBS || Admin Panel</title>
</head>
<body>
    <nav class="sidebar-nav">
        <div class="sidebar-list">
            <header>CBS <?php echo $admin_data['admin_name'];?></header>
            <ul class="list-group"><!--bootstrap yang class na yan tangina mo!-->
                <li><a href="admin-index.php"><i class="fas fa-qrcode"></i>Dashboard</a></li>
                <li><a href="admin-registration.php"><i class="fa-solid fa-user-lock"></i>Admins</a></li>
                <li><a href="admin-products.php"><i class="fa-brands fa-product-hunt"></i>Products</a></li>
                <li><a href="admin-category.php"><i class="fa-solid fa-list"></i>Categories</a></li>
                <li><a href="admin-users.php"><i class="fa-solid fa-users"></i>Users</a></li>
                <li><a href="admin-orders.php"><i class="fa-solid fa-bag-shopping"></i>Orders</a></li>
                <li><a href="admin-payment.php"><i class="fa-solid fa-peso-sign"></i>Payments</a></li>
                <li><a href="admin-return-cancel.php"><i class="fa-solid fa-right-left"></i>Return and Cancellation</a></li>
                <li><a href="admin-supplier.php"><i class="fa-solid fa-truck-field"></i>Supplier</a></li>
                <li><a href="admin-contacts.php"><i class="fas fa-envelope"></i>Inquiries</a></li>
                <li><a href="admin-logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
            </ul>
        </div>
    </nav>