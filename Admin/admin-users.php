<?php
session_start();

include("../connection.php");
include("../functions.php");

$admin_data = check_login_admin($con);

// Function for deleting users per id
if (isset($_POST['delete'])) { //button name
    $usersId = $_POST['usersId'];

    $sql = "Delete from `users` where usersId=$usersId";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: admin-users.php");
    } else {
        die(mysqli_error($con));
    }
}
?>
<?php include "admin-header.php"; ?>
<div class="admin-user">
    <div class="user-container">
        <h1 class="text-center mt-4 fw-bold">Users/Customers</h1>

        <!-- Table for displaying users -->
        <table class="table table-bordered border-dark align-middle table-responsive my-5">
            <thead class="text-center">
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">User email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `users` ORDER BY `date` DESC";
                $result = mysqli_query($con, $sql);
                $number = 1;
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $usersId = $row['usersId'];
                        $fname = $row['fname'];
                        $lname = $row['lname'];
                        $usersName = $row['usersName'];
                        $usersEmail = $row['usersEmail'];
                        $contact = $row['contact'];
                        $date = $row['date'];
                        echo '
                        <tr class="p-3">
                            <th scope="row" class="text-center">' . $number . '</th>
                            <td class="text-center">' . $fname . '&nbsp;' . $lname . '</td>
                            <td class="text-center">' . $usersName . '</td>
                            <td class="text-center">' . $usersEmail . '</td>
                            <td class="text-center">' . $contact . '</td>
                            <td class="text-center">' . $date . '</td>
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
<div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="delete-id" class="form-control" name="usersId">
                    <div class="mb-3">
                        <p>Are you sure you want to delete this user?</p>
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
                const usersId = del.getAttribute('data-delete-usersId');
                document.getElementById('delete-id').value = usersId;
            });
        });
    };
</script>