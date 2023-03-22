<?php
session_start();

include("../connection.php");
include("../functions.php");

$admin_data = check_login_admin($con);
// Function for deleting products
if (isset($_POST['delete'])) { //button name
    $contact_id = $_POST['contact_id'];

    $sql = "Delete from `contact` where contact_id=$contact_id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-contacts.php");
    } else {
        die(mysqli_error($con));
    }
}
?>
<?php include "admin-header.php"; ?>
<div class="admin-contact">
    <div class="user-container">
        <h1 class="text-center mt-4 fw-bold">Customers Inquiries</h1>

        <!-- Table for displaying users -->
        <table class="table table-bordered border-dark align-middle table-responsive mt-4">
            <thead class="text-center">
                <tr>
                    <th scope="col">Contact ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Message</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "Select * from `contact`";
                $result = mysqli_query($con, $sql);
                $number = 1;
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $contact_id = $row['contact_id'];
                        $fname = $row['fname'];
                        $lname = $row['lname'];
                        $email = $row['email'];
                        $message = $row['message'];
                        echo '<tr class="p-3">
                        <th scope="row" class="text-center">' . $contact_id . '</th>
                        <td class="text-center">' . $fname . '</td>
                        <td class="text-center">' . $lname . '</td>
                        <td class="text-center">' . $email . '</td>
                        <td class="text-center">' . $message . '</td>
                        <td class="text-center">
                            <button type="button" class="delete-btn btn btn-danger btn-m" data-bs-toggle="modal" data-bs-target="#deleteContact" 
                                data-delete-contact=' . $contact_id . '>
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>';
                        $number++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal Content for deleting users-->
<div class="modal fade" id="deleteContact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="delete-id" class="form-control" name="contact_id">
                    <div class="mb-3">
                        <p>Are you sure you want to delete this message?</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn" style="background-color: #630000;color:#fff;" name="delete">Delete</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "admin-footer.php"; ?>
<script>
    const del_btn = document.querySelectorAll('.delete-btn');
    if (del_btn) {
        del_btn.forEach((del) => {
            del.addEventListener('click', () => {
                console.log('click');
                const contact_id = del.getAttribute('data-delete-contact');
                document.getElementById('delete-id').value = contact_id;
            });
        });
    };
</script>