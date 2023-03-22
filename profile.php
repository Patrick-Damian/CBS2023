<?php include "header.php"; ?>

<?php
if (isset($_POST['update'])) {
    $usersId = $_POST['usersId'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $usersName = $_POST['usersName'];
    $usersEmail = $_POST['usersEmail'];
    $contact = $_POST['contact'];
    $newPass = md5 ($_POST['newPass']);
    

    $sql = "UPDATE `users` set `usersId`=$usersId,`fname`='$fname',`lname`='$lname',`usersName`='$usersName',`usersEmail`='$usersEmail',`contact`='$contact',`password`='$newPass' where `usersId`=$usersId";
    $result = mysqli_query($con, $sql);
    // $row = mysqli_fetch_assoc($result); // use to call the row in database tas echo row lang sa input type 
    if ($result) {
        // header("Location: profile.php?$usersId=[usersId]"); undefined uusersid daw gago!
        // echo "Record Modified Successfully";
        $message = "Record Modified Successfully";
    } else {
        die(mysqli_error($con));
    }
}
?>

<?php
// include('connection.php');
// if (count($_POST) > 0) {
//     mysqli_query($con, "UPDATE users SET name='" . $_POST['name'] . "',usersName='" . $_POST['usersName'] . "',usersEmail='" . $_POST['usersEmail'] . "',contact='" . $_POST['contact'] . " 'WHERE usersId='" . $_POST['usersId'] . "'");
//     $message = "Record Modified Successfully";
// }
$usersId = $_GET['usersId'];
$sql = "SELECT * FROM users WHERE usersId=$usersId"; // Fetch data from the table customers using id
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
?>

<div class="grid-container">
    <!-- Dapat nasa loob ng grid lahat to -->
    <nav class="sidebar-nav">
        <div class="sidebar-list">
            <ul class="list-group">
                <!--bootstrap yang class na yan tangina mo!-->
                <li><a href="profile.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-solid fa-user"></i>Account</a></li>
                <li><a href="address.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-solid fa-location-dot"></i>Address</a></li>
                <li><a href="orderDetails.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-solid fa-bag-shopping"></i>Orders</a></li>
                <li><a href="payment.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-solid fa-peso-sign"></i>Payment</a></li>
                <li><a href="wishlist.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-sharp fa-solid fa-heart-circle-check"></i>Wishlist</a></li>
                <li><a href="return_refund.php?usersId=<?php echo $row["usersId"]; ?>"><i class="fa-solid fa-arrow-right-arrow-left"></i>Return & Refund</a></li>
            </ul>
        </div>
    </nav>

    <div class="profile-content">
        <div class="form-content">
            <?php if (isset($message)) {
                echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="height:3.5rem;">
                    <p class="text-center"><i class="fa-solid fa-circle-check"></i> ' . $message . '</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            } ?>
            <!-- record modified -->
            <h1 class="mb-5 fw-bold">Hi&nbsp;<?php echo $user_data['usersName'] ?>!</h1>
            <!-- <img src="images/profile icon.png" width="150" height="150"> -->
            <form method="POST">
                <input type="hidden" name="usersId" class="txtField" value="<?php echo $row['usersId']; ?>">

                <div class="input-group mb-3">
                    <label for="name" class="input-group-text text-white" style="background-color:#630000;">Name:</label>
                    <input type="none" class="form-control" name="name" value="<?php echo $row['fname']; ?>&nbsp;<?php echo $row['lname']; ?>" readonly>
                </div>
                <div class="input-group mb-3">
                    <label for="username" class="input-group-text text-white" style="background-color:#630000;">User Name:</label>
                    <input type="text" class="form-control" name="usersName" value="<?php echo $row['usersName']; ?>" readonly>
                </div>
                <div class="input-group mb-3">
                    <label for="email" class="input-group-text text-white" style="background-color:#630000;">Email:</label>
                    <input type="email" class="form-control" name="usersEmail" value="<?php echo $row['usersEmail']; ?>" readonly>
                </div>
                <div class="input-group mb-3">
                    <label for="contact" class="input-group-text text-white" style="background-color:#630000;">Contact:</label>
                    <input type="text" class="form-control" name="contact" value="<?php echo $row['contact']; ?>" readonly>
                </div>
            </form>
            <div class="d-flex align-items-center justify-content-between">
                <a href="index.php" class="btn btn-sm text-light" style="background-color:#630000;"><i class="fa-solid fa-angles-left mx-1"></i>Home Page</a>
                <button type="submit" class="update-btn btn btn-sm text-light" style="background-color:#630000;" data-bs-toggle="modal" data-bs-target="#updateUser" data-update_usersId="<?php echo $row['usersId']; ?>" data-update_fname="<?php echo $row['fname']; ?>" data-update_lname="<?php echo $row['lname']; ?>" data-update_usersName="<?php echo $row['usersName']; ?>" data-update_usersEmail="<?php echo $row['usersEmail']; ?>" data-update_contact="<?php echo $row['contact']; ?>">
                    Edit
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Content for updating user-->
<div class=" modal fade" id="updateUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="update-usersId" class="form-control" name="usersId">
                    <div class="input-group mb-3">
                        <label for="fname" class="input-group-text text-light" style="background-color:#630000;">First Name:</label>
                        <input type="text" id="update-fname" class="form-control" name="fname">
                    </div>
                    <div class="input-group mb-3">
                        <label for="lname" class="input-group-text text-light" style="background-color:#630000;">Last Name:</label>
                        <input type="text" id="update-lname" class="form-control" name="lname">
                    </div>
                    <div class="input-group mb-3">
                        <label for="usersName" class="input-group-text text-light" style="background-color:#630000;">Username:</label>
                        <input type="text" id="update-usersName" class="form-control" name="usersName">
                    </div>
                    <div class="input-group mb-3">
                        <label for="usersEmail" class="input-group-text text-light" style="background-color:#630000;">User Email:</label>
                        <input type="text" id="update-usersEmail" class="form-control" name="usersEmail">
                    </div>
                    <div class="input-group mb-3">
                        <label for="contact" class="input-group-text text-light" style="background-color:#630000;">Contact:</label>
                        <input type="text" id="update-contact" class="form-control" name="contact">
                    </div>
                    <div class="input-group mb-3">
                        <label for="oldPass" class="input-group-text text-light" style="background-color:#630000;">Old Password:</label>
                        <input type="password" id="update-oldPass" class="form-control" name="oldPass" placeholder="Enter Old Password">
                    </div>
                    <div class="input-group mb-3">
                        <label for="newPass" class="input-group-text text-light" style="background-color:#630000;">New Password:</label>
                        <input type="password" id="update-newPass" class="form-control" name="newPass" placeholder="Enter New Password">
                    </div>
                    <div class="input-group mb-3">
                        <label for="conPass" class="input-group-text text-light" style="background-color:#630000;">Confim Password:</label>
                        <input type="password" id="update-conPass" class="form-control" name="conPass"  placeholder="Confirm Password">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn text-light" name="update" style="background-color:#630000;">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Dapat yung ganto nakalagy sa ibang files. yung footer ihihiwalay na lang para malinis -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<!--Para mag dropwon yung menu-->

<?php include "footer.php"; ?>
<script>
    const update_btn = document.querySelectorAll('.update-btn');
    if (update_btn) {
        update_btn.forEach((edit) => {
            edit.addEventListener('click', () => {
                console.log('click');
                const usersId = edit.getAttribute('data-update_usersId');
                document.getElementById('update-usersId').value = usersId;

                const fname = edit.getAttribute('data-update_fname');
                document.getElementById('update-fname').value = fname;

                const lname = edit.getAttribute('data-update_lname');
                document.getElementById('update-lname').value = lname;

                const usersName = edit.getAttribute('data-update_usersName');
                document.getElementById('update-usersName').value = usersName;

                const usersEmail = edit.getAttribute('data-update_usersEmail');
                document.getElementById('update-usersEmail').value = usersEmail;

                const contact = edit.getAttribute('data-update_contact');
                document.getElementById('update-contact').value = contact;
            });
        });
    };
</script>