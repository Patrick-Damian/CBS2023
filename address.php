<?php include "header.php"; ?>

<?php
// include('connection.php');
$usersId = $_GET['usersId'];
$sql = "SELECT * FROM `users` WHERE usersId=$usersId"; // Fetch data from the table customers using id
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Function for adding address
if (isset($_POST['add'])) {
    $usersId = $_GET['usersId'];
    $house_no = $_POST['house_no'];
    $street = $_POST['street'];
    $brgy = $_POST['brgy'];
    $city = $_POST['city'];
    $zip_code = $_POST['zip_code'];

    $sql = "INSERT INTO `address` (`usersId`,`house_no`,`street`,`brgy`,`city`,`zip_code`) VALUES ('$usersId','$house_no','$street','$brgy','$city','$zip_code')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: address.php?usersId=$usersId");
    } else {
        die(mysqli_error($con));
    }
}
// Function for deleting address
if (isset($_POST['delete'])) { //button name
    $add_id = $_POST['add_id'];

    $sql = "Delete from `address` where add_id=$add_id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: address.php?usersId=$usersId");
    } else {
        die(mysqli_error($con));
    }
}

if (isset($_POST['update'])) {
    $add_id = $_POST['add_id'];
    $house_no = $_POST['house_no'];
    $street = $_POST['street'];
    $brgy = $_POST['brgy'];
    $city = $_POST['city'];
    $zip_code = $_POST['zip_code'];

    $sql = "UPDATE `address` set `house_no`='$house_no',`street`='$street',`brgy`='$brgy',`city`='$city',`zip_code`='$zip_code' where `add_id`=$add_id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: address.php?usersId=$usersId");
    } else {
        die(mysqli_error($con));
    }
}
?>

<div class="grid-address">
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

    <div class="address">
        <h1 class="text-center fw-bold mt-4">My Address</h1>
        <button type="button" class="btn text-light my-3" data-bs-toggle="modal" data-bs-target="#addAddress" style="background:#630000;">Add Address</button>
        <?php
        // $usersId = $_GET['usersId']; //isang beses lang dapat ideclared since global variable
        $sql = "SELECT * FROM `address` WHERE usersId=$usersId GROUP BY house_no,street,brgy,city,zip_code;"; //lagay DISTINCT if ever may error sa multiple adding different address
        $result = mysqli_query($con, $sql);
        $index = 0;
        // $row = mysqli_fetch_assoc($result);
        while ($row = mysqli_fetch_assoc($result)) {
            $add_id = $row['add_id'];
            $usersId = $row['usersId'];
            $house_no = $row['house_no'];
            $street = $row['street'];
            $brgy = $row['brgy'];
            $city = $row['city'];
            $zip_code = $row['zip_code'];
            $index++;
        ?>
            <div class="mb-3">
                <label for="address" class="form-label">Address <?= $index ?></label>
                <input type="text" readonly class="form-control form-control-lg" id="address" value="<?= $house_no, '&nbsp;', $street, '&nbsp;', $brgy, '&nbsp;', $city, '&nbsp;', $zip_code ?>" style="width: 40rem;">
            </div>

            <button type="submit" class="update-btn btn text-light btn-sm" style="background:#630000;" data-bs-toggle="modal" data-bs-target="#updateAddress" data-update_add_id="<?= $add_id ?>" data-update_house="<?= $house_no ?>" data-update_street="<?= $street ?>" data-update_brgy="<?= $brgy ?>" data-update_city="<?= $city ?>" data-update_zip="<?= $zip_code ?>">
                Edit
            </button>
            <button type="button" class="delete-btn btn btn-sm text-light" style="background:red;" data-bs-toggle="modal" data-bs-target="#deleteAddress" data-delete-add_id="<?= $add_id ?>">
                Delete
            </button>

        <?php
        }
        ?>
    </div>
</div>

<!-- Modal Content for adding address-->
<div class="modal fade" id="addAddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <input type="hidden" class="form-control" name="usersId">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text text-light" style="background:#630000;">House No:</span>
                        <input type="text" class="form-control" name="house_no" placeholder="House No.">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text text-light" style="background:#630000;">Street:</span>
                        <input type="text" class="form-control" name="street" placeholder="Street">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text text-light" style="background:#630000;">City:</span>
                        <select id="country" class="form-select" name="city" required>
                            <option>Choose your city</option>
                            <option>Pasig City</option>
                            <option>Las Pinas</option>
                            <option>Taguig</option>
                            <option>Sta. Ana</option>
                            <option>Pateros</option>
                            <option>San Juan</option>
                            <option>Quezon</option>
                            <option>Mandaluyong</option>
                            <option>Malate</option>
                            <option>Pasay City</option>
                            <option>San Miguel</option>
                            <option>Muntinlupa City</option>
                            <option>Sampaloc</option>
                            <option>Ermita</option>
                            <option>Tondo</option>
                            <option>Paco</option>
                            <option>Binondo</option>
                            <option>Intramuros</option>
                            <option>Santa Cruz</option>
                            <option>Makati City</option>
                            <option>Quiapo</option>
                            <option>Navotas City</option>
                            <option>San Nicolas</option>
                            <option>Paranaque City</option>
                            <option>Marikina City</option>
                            <option>Caloocan City</option>
                            <option>Malabon City</option>
                            <option>Valenzuela City</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text text-light" style="background:#630000;">Barangay:</span>
                        <select id="location" class="form-select" name="brgy" placeholder="Barangay"></select>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text text-light" style="background:#630000;">Zip Code:</span>
                        <input type="text" class="form-control" name="zip_code" placeholder="Zip Code">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn text-light" name="add" style="background:#630000;">Confirm</button>
                    <button type="button" class="btn text-light" style="background:red;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Content for updating address-->
<div class="modal fade" id="updateAddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <input type="hidden" class="form-control" name="usersId">
                <div class="modal-body">
                    <input type="hidden" id="update-add_id" class="form-control" name="add_id">
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background: #630000; color:#fff;">House No:</span>
                        <input type="text" id="update-house" class="form-control" name="house_no" placeholder="House No.">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background:#630000;color:#fff;">Street:</span>
                        <input type="text" id="update-street" class="form-control" name="street" placeholder="Street">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background:#630000;color:#fff;">Barangay:</span>
                        <input type="text" id="update-brgy" class="form-control" name="brgy" placeholder="Barangay">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background:#630000;color:#fff;">City:</span>
                        <input type="text" id="update-city" class="form-control" name="city" placeholder="City">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" style="background:#630000;color:#fff;">Zip Code:</span>
                        <input type="text" id="update-zip" class="form-control" name="zip_code" placeholder="Zip Code">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn text-light" name="update" style="background:#630000;">Update</button>
                    <button type="button" class="btn text-light" style="background:red;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Content for deleting address-->
<div class="modal fade" id="deleteAddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="delete-id" class="form-control" name="add_id">
                    <div class="mb-3">
                        <p>Are you sure you want to delete your Address?</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn text-light" style="background:red;" name="delete">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
<!-- Dapat yung ganto nakalagy sa ibang files. yung footer ihihiwalay na lang para malinis -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<!--Para mag dropwon yung menu-->

<script>
    jQuery(function($) {
        var locations = {
            'Pasig City': ['Bagong Ilog',
                'Bagong Katipunan',
                'Bambang',
                'Buting',
                'Caniogan',
                'Dela Paza',
                'Kalawaan',
                'Kapasigan',
                'Kapitolyo',
                'Malinao',
                'Manggahan',
                'Maybunga',
                'Oranbo',
                'Palatiw',
                'Pinagbuhatan',
                'Pineda',
                'Rosario',
                'Sagad',
                'San Antonio',
                'San Joaquin',
                'San Jose',
                'San Miguel',
                'San Nicolas',
                'Santa Cruz',
                'Santa Lucia',
                'Santa Rosa',
                'Santo Tomas',
                'Santolan',
                'Sumilang',
                'Ugong'
            ],
            'Las Pinas': ['Almanza Dos',
                'Almanza Uno',
                'B. F. International Village',
                'Daniel Fajardo',
                'Elias Aldana',
                'Ilaya',
                'Manuyo Dos',
                'Manuyo Uno',
                'Pamplona Dos',
                'Pamplona Tres',
                'Pamplona Uno',
                'Pilar',
                'Pulang Lupa Dos',
                'Pulang Lupa Uno',
                'Talon Dos',
                'Talon Kuatro',
                'Talon Singko',
                'Talon Tres',
                'Talon Uno',
                'Zapote'
            ],

            'Taguig': ['Bagumbayan', 'Bambang', 'Calzada', 'Central Bicutan', 'Central Signal Village', 'Fort Bonifacio', 'Hagonoy', 'Ibayo-Tipas', 'Katuparan', 'Ligid-Tipas', 'Lower Bicutan', 'Maharlika Village', 'Napindan', 'New Lower Bicutan', 'North Daang Hari', 'North Signal Village', 'Palingon', 'Pinagsama', 'San Miguel', 'Santa Ana', 'South Daang Hari', 'South Signal Village', 'Tanyag', 'Tuktukan', 'Upper Bicutan', 'Ususan', 'Wawa', 'Western Bicutan'],
            'Sta. Ana': ['Barangay 745', 'Barangay 746', 'Barangay 747', 'Barangay 748', 'Barangay 749', 'Barangay 750', 'Barangay 751', 'Barangay 752', 'Barangay 753', 'Barangay 754', 'Barangay 755', 'Barangay 756', 'Barangay 757', 'Barangay 758', 'Barangay 759', 'Barangay 760', 'Barangay 761', 'Barangay 762', 'Barangay 763', 'Barangay 764', 'Barangay 765', 'Barangay 766', 'Barangay 767', 'Barangay 768', 'Barangay 769', 'Barangay 770', 'Barangay 771', 'Barangay 772', 'Barangay 773', 'Barangay 774', 'Barangay 775', 'Barangay 776', 'Barangay 777', 'Barangay 778', 'Barangay 779', 'Barangay 780', 'Barangay 781', 'Barangay 782', 'Barangay 783', 'Barangay 784', 'Barangay 785', 'Barangay 786', 'Barangay 787', 'Barangay 788', 'Barangay 789', 'Barangay 790', 'Barangay 791', 'Barangay 792', 'Barangay 793', 'Barangay 794', 'Barangay 795', 'Barangay 796', 'Barangay 797', 'Barangay 798', 'Barangay 799', 'Barangay 800', 'Barangay 801', 'Barangay 802', 'Barangay 803', 'Barangay 804', 'Barangay 805', 'Barangay 806', 'Barangay 807', 'Barangay 808', 'Barangay 818-A', 'Barangay 866', 'Barangay 873', 'Barangay 874', 'Barangay 875', 'Barangay 876', 'Barangay 877', 'Barangay 878', 'Barangay 879', 'Barangay 880', 'Barangay 881', 'Barangay 882', 'Barangay 883', 'Barangay 884', 'Barangay 885', 'Barangay 886', 'Barangay 887', 'Barangay 888', 'Barangay 889', 'Barangay 890', 'Barangay 891', 'Barangay 892', 'Barangay 893', 'Barangay 894', 'Barangay 895', 'Barangay 896', 'Barangay 897', 'Barangay 898', 'Barangay 899', 'Barangay 900', 'Barangay 901', 'Barangay 902', 'Barangay 903', 'Barangay 904', 'Barangay 905'],
            'Pateros': ['Aguho', 'Magtanggol', 'Martires del 96', 'Poblacion', 'San Pedro', 'San Roque', 'Santa Ana', 'Santo Rosario-Kanluran', 'Santo Rosario-Silangan', 'Tabacalera'],
            'San Juan': ['Addition Hills', 'Balong-Bato', 'Batis', 'Corazon de Jesus', 'Ermitaño', 'Greenhills', 'Halo-halo', 'Isabelita', 'Kabayanan', 'Little Baguio', 'Maytunas', 'Onse', 'Pasadeña', 'Pedro Cruz', 'Progreso', 'Rivera', 'Salapan', 'San Perfecto', 'Santa Lucia', 'Tibagan', 'West Crame'],
            'Quezon': ['Alicia', 'Amihan', 'Apolonio Samson', 'Aurora', 'Baesa', 'Bagbag', 'Bagong Lipunan ng Crame', 'Bagong Pag-asa', 'Bagong Silangan', 'Bagumbayan', 'Bagumbuhay', 'Bahay Toro', 'Balingasa', 'Balong Bato', 'Batasan Hills', 'Bayanihan', 'Blue Ridge A', 'Blue Ridge B', 'Botocan', 'Bungad', 'Camp Aguinaldo', 'Capri', 'Central', 'Claro', 'Commonwealth', 'Culiat', 'Damar', 'Damayan', 'Damayang Lagi', 'Del Monte', 'Dioquino Zobel', 'Don Manuel', 'Doña Imelda', 'Doña Josefa', 'Duyan-duyan', 'E. Rodriguez', 'East Kamias', 'Escopa I', 'Escopa II', 'Escopa III', 'Escopa IV', 'Fairview', 'Greater Lagro', 'Gulod', 'Holy Spirit', 'Horseshoe', 'Immaculate Concepcion', 'Kaligayahan', 'Kalusugan', 'Kamuning', 'Katipunan', 'Kaunlaran', 'Kristong Hari', 'Krus na Ligas', 'Laging Handa', 'Libis', 'Lourdes', 'Loyola Heights', 'Maharlika', 'Malaya', 'Mangga', 'Manresa', 'Mariana', 'Mariblo', 'Marilag', 'Masagana', 'Masambong', 'Matandang Balara', 'Milagrosa', 'N. S. Amoranto', 'Nagkaisang Nayon', 'Nayong Kanluran', 'New Era', 'North Fairview', 'Novaliches Proper', 'Obrero', 'Old Capitol Site', 'Paang Bundok', 'Pag-ibig sa Nayon', 'Paligsahan', 'Paltok', 'Pansol', 'Paraiso', 'Pasong Putik Proper', 'Pasong Tamo', 'Payatas', 'Phil-Am', 'Pinagkaisahan', 'Pinyahan', 'Project 6', 'Quirino 2-A', 'Quirino 2-B', 'Quirino 2-C', 'Quirino 3-A', 'Ramon Magsaysay', 'Roxas', 'Sacred Heart', 'Saint Ignatius', 'Saint Peter', 'Salvacion', 'San Agustin', 'San Antonio', 'San Bartolome', 'San Isidro', 'San Isidro Labrador', 'San Jose', 'San Martin de Porres', 'San Roque', 'San Vicente', 'Sangandaan', 'Santa Cruz', 'Santa Lucia', 'Santa Monica', 'Santa Teresita', 'Santo Cristo', 'Santo Domingo', 'Santo Niño', 'Santol', 'Sauyo', 'Sienna', 'Sikatuna Village', 'Silangan', 'Socorro', 'South Triangle', 'Tagumpay', 'Talayan', 'Talipapa', 'Tandang Sora', 'Tatalon', 'Teachers Village East', 'Teachers Village West', 'U.P. Campus', 'U.P. Village', 'Ugong Norte', 'Unang Sigaw', 'Valencia', 'Vasra', 'Veterans Village', 'Villa Maria Clara', 'West Kamias', 'West Triangle', 'White Plains'],
            'Mandaluyong': ['Addition Hills', 'Bagong Silang', 'Barangka Drive', 'Barangka Ibaba', 'Barangka Ilaya', 'Barangka Itaas', 'Buayang Bato', 'Burol', 'Daang Bakal', 'Hagdang Bato Itaas', 'Hagdang Bato Libis', 'Harapin Ang Bukas', 'Highway Hills', 'Hulo', 'Mabini-J. Rizal', 'Malamig', 'Mauway', 'Namayan', 'New Zañiga', 'Old Zañiga', 'Pag-asa', 'Plainview', 'Pleasant Hills', 'Poblacion', 'San Jose', 'Vergara', 'Wack-wack Greenhills'],
            'Malate': ['Barangay 688', 'Barangay 689', 'Barangay 690', 'Barangay 691', 'Barangay 692', 'Barangay 693', 'Barangay 694', 'Barangay 695', 'Barangay 696', 'Barangay 697', 'Barangay 698', 'Barangay 699', 'Barangay 700', 'Barangay 701', 'Barangay 702', 'Barangay 703', 'Barangay 704', 'Barangay 705', 'Barangay 706', 'Barangay 707', 'Barangay 708', 'Barangay 709', 'Barangay 710', 'Barangay 711', 'Barangay 712', 'Barangay 713', 'Barangay 714', 'Barangay 715', 'Barangay 716', 'Barangay 717', 'Barangay 718', 'Barangay 719', 'Barangay 720', 'Barangay 721', 'Barangay 722', 'Barangay 723', 'Barangay 724', 'Barangay 725', 'Barangay 726', 'Barangay 727', 'Barangay 728', 'Barangay 729', 'Barangay 730', 'Barangay 731', 'Barangay 732', 'Barangay 733', 'Barangay 734', 'Barangay 735', 'Barangay 736', 'Barangay 737', 'Barangay 738', 'Barangay 739', 'Barangay 740', 'Barangay 741', 'Barangay 742', 'Barangay 743', 'Barangay 744'],
            'Pasay City': ['Barangay 1', 'Barangay 2', 'Barangay 3', 'Barangay 4', 'Barangay 5', 'Barangay 6', 'Barangay 7', 'Barangay 8', 'Barangay 9', 'Barangay 10', 'Barangay 100', 'Barangay 101', 'Barangay 102', 'Barangay 103', 'Barangay 104', 'Barangay 105', 'Barangay 106', 'Barangay 107', 'Barangay 108', 'Barangay 109', 'Barangay 11', 'Barangay 110', 'Barangay 111', 'Barangay 112', 'Barangay 113', 'Barangay 114', 'Barangay 115', 'Barangay 116', 'Barangay 117', 'Barangay 118', 'Barangay 119', 'Barangay 12', 'Barangay 120', 'Barangay 121', 'Barangay 122', 'Barangay 123', 'Barangay 124', 'Barangay 125', 'Barangay 126', 'Barangay 127', 'Barangay 128', 'Barangay 129', 'Barangay 13', 'Barangay 130', 'Barangay 131', 'Barangay 132', 'Barangay 133', 'Barangay 134', 'Barangay 135', 'Barangay 136', 'Barangay 137', 'Barangay 138', 'Barangay 139', 'Barangay 14', 'Barangay 140', 'Barangay 141', 'Barangay 142', 'Barangay 143', 'Barangay 144', 'Barangay 145', 'Barangay 146', 'Barangay 147', 'Barangay 148', 'Barangay 149', 'Barangay 15', 'Barangay 150', 'Barangay 151', 'Barangay 152', 'Barangay 153', 'Barangay 154', 'Barangay 155', 'Barangay 156', 'Barangay 157', 'Barangay 158', 'Barangay 159', 'Barangay 16', 'Barangay 160', 'Barangay 161', 'Barangay 162', 'Barangay 163', 'Barangay 164', 'Barangay 165', 'Barangay 166', 'Barangay 167', 'Barangay 168', 'Barangay 169', 'Barangay 17', 'Barangay 170', 'Barangay 171', 'Barangay 172', 'Barangay 173', 'Barangay 174', 'Barangay 175', 'Barangay 176', 'Barangay 177', 'Barangay 178', 'Barangay 179', 'Barangay 18', 'Barangay 180', 'Barangay 181', 'Barangay 182', 'Barangay 183', 'Barangay 184', 'Barangay 185', 'Barangay 186', 'Barangay 187', 'Barangay 188', 'Barangay 189', 'Barangay 19', 'Barangay 190', 'Barangay 191', 'Barangay 192', 'Barangay 193', 'Barangay 194', 'Barangay 195', 'Barangay 196', 'Barangay 197', 'Barangay 198', 'Barangay 199', 'Barangay 20', 'Barangay 200', 'Barangay 201', 'Barangay 21', 'Barangay 22', 'Barangay 23', 'Barangay 24', 'Barangay 25', 'Barangay 26', 'Barangay 27', 'Barangay 28', 'Barangay 29', 'Barangay 30', 'Barangay 31', 'Barangay 32', 'Barangay 33', 'Barangay 34', 'Barangay 35', 'Barangay 36', 'Barangay 37', 'Barangay 38', 'Barangay 39', 'Barangay 40', 'Barangay 41', 'Barangay 42', 'Barangay 43', 'Barangay 44', 'Barangay 45', 'Barangay 46', 'Barangay 47', 'Barangay 48', 'Barangay 49', 'Barangay 50', 'Barangay 51', 'Barangay 52', 'Barangay 53', 'Barangay 54', 'Barangay 55', 'Barangay 56', 'Barangay 57', 'Barangay 58', 'Barangay 59', 'Barangay 60', 'Barangay 61', 'Barangay 62', 'Barangay 63', 'Barangay 64', 'Barangay 65', 'Barangay 66', 'Barangay 67', 'Barangay 68', 'Barangay 69', 'Barangay 70', 'Barangay 71', 'Barangay 72', 'Barangay 73', 'Barangay 74', 'Barangay 75', 'Barangay 76', 'Barangay 77', 'Barangay 78', 'Barangay 79', 'Barangay 80', 'Barangay 81', 'Barangay 82', 'Barangay 83', 'Barangay 84', 'Barangay 85', 'Barangay 86', 'Barangay 87', 'Barangay 88', 'Barangay 89', 'Barangay 90', 'Barangay 91', 'Barangay 92', 'Barangay 93', 'Barangay 94', 'Barangay 95', 'Barangay 96', 'Barangay 97', 'Barangay 98', 'Barangay 99'],
            'Port Area': ['Barangay 649', 'Barangay 650', 'Barangay 651', 'Barangay 652', 'Barangay 653'],
            'San Miguel': ['Barangay 637', 'Barangay 638', 'Barangay 639', 'Barangay 640', 'Barangay 641', 'Barangay 642', 'Barangay 643', 'Barangay 644', 'Barangay 645', 'Barangay 646', 'Barangay 647', 'Barangay 648'],
            'Muntinlupa City': ['Alabang', 'Bayanan', 'Buli', 'Cupang', 'New Alabang Village', 'Poblacion', 'Putatan', 'Sucat', 'Tunasan'],
            'Sampaloc': ['Barangay 395', 'Barangay 396', 'Barangay 397', 'Barangay 398', 'Barangay 399', 'Barangay 400', 'Barangay 401', 'Barangay 402', 'Barangay 403', 'Barangay 404', 'Barangay 405', 'Barangay 406', 'Barangay 407', 'Barangay 408', 'Barangay 409', 'Barangay 410', 'Barangay 411', 'Barangay 412', 'Barangay 413', 'Barangay 414', 'Barangay 415', 'Barangay 416', 'Barangay 417', 'Barangay 418', 'Barangay 419', 'Barangay 420', 'Barangay 421', 'Barangay 422', 'Barangay 423', 'Barangay 424', 'Barangay 425', 'Barangay 426', 'Barangay 427', 'Barangay 428', 'Barangay 429', 'Barangay 430', 'Barangay 431', 'Barangay 432', 'Barangay 433', 'Barangay 434', 'Barangay 435', 'Barangay 436', 'Barangay 437', 'Barangay 438', 'Barangay 439', 'Barangay 440', 'Barangay 441', 'Barangay 442', 'Barangay 443', 'Barangay 444', 'Barangay 445', 'Barangay 446', 'Barangay 447', 'Barangay 448', 'Barangay 449', 'Barangay 450', 'Barangay 451', 'Barangay 452', 'Barangay 453', 'Barangay 454', 'Barangay 455', 'Barangay 456', 'Barangay 457', 'Barangay 458', 'Barangay 459', 'Barangay 460', 'Barangay 461', 'Barangay 462', 'Barangay 463', 'Barangay 464', 'Barangay 465', 'Barangay 466', 'Barangay 467', 'Barangay 468', 'Barangay 469', 'Barangay 470', 'Barangay 471', 'Barangay 472', 'Barangay 473', 'Barangay 474', 'Barangay 475', 'Barangay 476', 'Barangay 477', 'Barangay 478', 'Barangay 479', 'Barangay 480', 'Barangay 481', 'Barangay 482', 'Barangay 483', 'Barangay 484', 'Barangay 485', 'Barangay 486', 'Barangay 487', 'Barangay 488', 'Barangay 489', 'Barangay 490', 'Barangay 491', 'Barangay 492', 'Barangay 493', 'Barangay 494', 'Barangay 495', 'Barangay 496', 'Barangay 497', 'Barangay 498', 'Barangay 499', 'Barangay 500', 'Barangay 501', 'Barangay 502', 'Barangay 503', 'Barangay 504', 'Barangay 505', 'Barangay 506', 'Barangay 507', 'Barangay 508', 'Barangay 509', 'Barangay 510', 'Barangay 511', 'Barangay 512', 'Barangay 513', 'Barangay 514', 'Barangay 515', 'Barangay 516', 'Barangay 517', 'Barangay 518', 'Barangay 519', 'Barangay 520', 'Barangay 521', 'Barangay 522', 'Barangay 523', 'Barangay 524', 'Barangay 525', 'Barangay 526', 'Barangay 527', 'Barangay 528', 'Barangay 529', 'Barangay 530', 'Barangay 531', 'Barangay 532', 'Barangay 533', 'Barangay 534', 'Barangay 535', 'Barangay 536', 'Barangay 537', 'Barangay 538', 'Barangay 539', 'Barangay 540', 'Barangay 541', 'Barangay 542', 'Barangay 543', 'Barangay 544', 'Barangay 545', 'Barangay 546', 'Barangay 547', 'Barangay 548', 'Barangay 549', 'Barangay 550', 'Barangay 551', 'Barangay 552', 'Barangay 553', 'Barangay 554', 'Barangay 555', 'Barangay 556', 'Barangay 557', 'Barangay 558', 'Barangay 559', 'Barangay 560', 'Barangay 561', 'Barangay 562', 'Barangay 563', 'Barangay 564', 'Barangay 565', 'Barangay 566', 'Barangay 567', 'Barangay 568', 'Barangay 569', 'Barangay 570', 'Barangay 571', 'Barangay 572', 'Barangay 573', 'Barangay 574', 'Barangay 575', 'Barangay 576', 'Barangay 577', 'Barangay 578', 'Barangay 579', 'Barangay 580', 'Barangay 581', 'Barangay 582', 'Barangay 583', 'Barangay 584', 'Barangay 585', 'Barangay 586', 'Barangay 587', 'Barangay 587-A', 'Barangay 588', 'Barangay 589', 'Barangay 590', 'Barangay 591', 'Barangay 592', 'Barangay 593', 'Barangay 594', 'Barangay 595', 'Barangay 596', 'Barangay 597', 'Barangay 598', 'Barangay 599', 'Barangay 600', 'Barangay 601', 'Barangay 602', 'Barangay 603', 'Barangay 604', 'Barangay 605', 'Barangay 606', 'Barangay 607', 'Barangay 608', 'Barangay 609', 'Barangay 610', 'Barangay 611', 'Barangay 612', 'Barangay 613', 'Barangay 614', 'Barangay 615', 'Barangay 616', 'Barangay 617', 'Barangay 618', 'Barangay 619', 'Barangay 620', 'Barangay 621', 'Barangay 622', 'Barangay 623', 'Barangay 624', 'Barangay 625', 'Barangay 626', 'Barangay 627', 'Barangay 628', 'Barangay 629', 'Barangay 630', 'Barangay 631', 'Barangay 632', 'Barangay 633', 'Barangay 634', 'Barangay 635', 'Barangay 636'],
            'Ermita': ['Barangay 659', 'Barangay 659-A', 'Barangay 660', 'Barangay 660-A', 'Barangay 661', 'Barangay 663', 'Barangay 663-A', 'Barangay 664', 'Barangay 666', 'Barangay 667', 'Barangay 668', 'Barangay 669', 'Barangay 670'],
            'Tondo': ['Barangay 1', 'Barangay 2', 'Barangay 3', 'Barangay 4', 'Barangay 5', 'Barangay 6', 'Barangay 7', 'Barangay 8', 'Barangay 9', 'Barangay 10', 'Barangay 11', 'Barangay 12', 'Barangay 13', 'Barangay 14', 'Barangay 15', 'Barangay 16', 'Barangay 17', 'Barangay 18', 'Barangay 19', 'Barangay 20', 'Barangay 25', 'Barangay 26', 'Barangay 28', 'Barangay 29', 'Barangay 30', 'Barangay 31', 'Barangay 32', 'Barangay 33', 'Barangay 34', 'Barangay 35', 'Barangay 36', 'Barangay 37', 'Barangay 38', 'Barangay 39', 'Barangay 41', 'Barangay 42', 'Barangay 43', 'Barangay 44', 'Barangay 45', 'Barangay 46', 'Barangay 47', 'Barangay 48', 'Barangay 49', 'Barangay 50', 'Barangay 51', 'Barangay 52', 'Barangay 53', 'Barangay 54', 'Barangay 55', 'Barangay 56', 'Barangay 57', 'Barangay 58', 'Barangay 59', 'Barangay 60', 'Barangay 61', 'Barangay 62', 'Barangay 63', 'Barangay 64', 'Barangay 65', 'Barangay 66', 'Barangay 67', 'Barangay 68', 'Barangay 69', 'Barangay 70', 'Barangay 71', 'Barangay 72', 'Barangay 73', 'Barangay 74', 'Barangay 75', 'Barangay 76', 'Barangay 77', 'Barangay 78', 'Barangay 79', 'Barangay 80', 'Barangay 81', 'Barangay 82', 'Barangay 83', 'Barangay 84', 'Barangay 85', 'Barangay 86', 'Barangay 87', 'Barangay 88', 'Barangay 89', 'Barangay 90', 'Barangay 91', 'Barangay 92', 'Barangay 93', 'Barangay 94', 'Barangay 95', 'Barangay 96', 'Barangay 97', 'Barangay 98', 'Barangay 99', 'Barangay 100', 'Barangay 101', 'Barangay 102', 'Barangay 103', 'Barangay 104', 'Barangay 105', 'Barangay 106', 'Barangay 107', 'Barangay 108', 'Barangay 109', 'Barangay 110', 'Barangay 111', 'Barangay 112', 'Barangay 116', 'Barangay 117', 'Barangay 118', 'Barangay 119', 'Barangay 120', 'Barangay 121', 'Barangay 122', 'Barangay 123', 'Barangay 124', 'Barangay 125', 'Barangay 126', 'Barangay 127', 'Barangay 128', 'Barangay 129', 'Barangay 130', 'Barangay 131', 'Barangay 132', 'Barangay 133', 'Barangay 134', 'Barangay 135', 'Barangay 136', 'Barangay 137', 'Barangay 138', 'Barangay 139', 'Barangay 140', 'Barangay 141', 'Barangay 142', 'Barangay 143', 'Barangay 144', 'Barangay 145', 'Barangay 146', 'Barangay 147', 'Barangay 148', 'Barangay 149', 'Barangay 150', 'Barangay 151', 'Barangay 152', 'Barangay 153', 'Barangay 154', 'Barangay 155', 'Barangay 156', 'Barangay 157', 'Barangay 158', 'Barangay 159', 'Barangay 160', 'Barangay 161', 'Barangay 162', 'Barangay 163', 'Barangay 164', 'Barangay 165', 'Barangay 166', 'Barangay 167', 'Barangay 168', 'Barangay 169', 'Barangay 170', 'Barangay 171', 'Barangay 172', 'Barangay 173', 'Barangay 174', 'Barangay 175', 'Barangay 176', 'Barangay 177', 'Barangay 178', 'Barangay 179', 'Barangay 180', 'Barangay 181', 'Barangay 182', 'Barangay 183', 'Barangay 184', 'Barangay 185', 'Barangay 186', 'Barangay 187', 'Barangay 188', 'Barangay 189', 'Barangay 190', 'Barangay 191', 'Barangay 192', 'Barangay 193', 'Barangay 194', 'Barangay 195', 'Barangay 196', 'Barangay 197', 'Barangay 198', 'Barangay 199', 'Barangay 200', 'Barangay 201', 'Barangay 202', 'Barangay 202-A', 'Barangay 203', 'Barangay 204', 'Barangay 205', 'Barangay 206', 'Barangay 207', 'Barangay 208', 'Barangay 209', 'Barangay 210', 'Barangay 211', 'Barangay 212', 'Barangay 213', 'Barangay 214', 'Barangay 215', 'Barangay 216', 'Barangay 217', 'Barangay 218', 'Barangay 219', 'Barangay 220', 'Barangay 221', 'Barangay 222', 'Barangay 223', 'Barangay 224', 'Barangay 225', 'Barangay 226', 'Barangay 227', 'Barangay 228', 'Barangay 229', 'Barangay 230', 'Barangay 231', 'Barangay 232', 'Barangay 233', 'Barangay 234', 'Barangay 235', 'Barangay 236', 'Barangay 237', 'Barangay 238', 'Barangay 239', 'Barangay 240', 'Barangay 241', 'Barangay 242', 'Barangay 243', 'Barangay 244', 'Barangay 245', 'Barangay 246', 'Barangay 247', 'Barangay 248', 'Barangay 249', 'Barangay 250', 'Barangay 251', 'Barangay 252', 'Barangay 253', 'Barangay 254', 'Barangay 255', 'Barangay 256', 'Barangay 257', 'Barangay 258', 'Barangay 259', 'Barangay 260', 'Barangay 261', 'Barangay 262', 'Barangay 263', 'Barangay 264', 'Barangay 265', 'Barangay 266', 'Barangay 267'],
            'Paco': ['Barangay 662', 'Barangay 664-A', 'Barangay 671', 'Barangay 672', 'Barangay 673', 'Barangay 674', 'Barangay 675', 'Barangay 676', 'Barangay 677', 'Barangay 678', 'Barangay 679', 'Barangay 680', 'Barangay 681', 'Barangay 682', 'Barangay 683', 'Barangay 684', 'Barangay 685', 'Barangay 686', 'Barangay 687', 'Barangay 809', 'Barangay 810', 'Barangay 811', 'Barangay 812', 'Barangay 813', 'Barangay 814', 'Barangay 815', 'Barangay 816', 'Barangay 817', 'Barangay 818', 'Barangay 819', 'Barangay 820', 'Barangay 821', 'Barangay 822', 'Barangay 823', 'Barangay 824', 'Barangay 825', 'Barangay 826', 'Barangay 827', 'Barangay 828', 'Barangay 829', 'Barangay 830', 'Barangay 831', 'Barangay 832'],
            'Binondo': ['Barangay 287', 'Barangay 288', 'Barangay 289', 'Barangay 290', 'Barangay 291', 'Barangay 292', 'Barangay 293', 'Barangay 294', 'Barangay 295', 'Barangay 296'],
            'Intramuros': ['Barangay 654', 'Barangay 655', 'Barangay 656', 'Barangay 657', 'Barangay 658'],
            'Santa Cruz': ['Barangay 297', 'Barangay 298', 'Barangay 299', 'Barangay 300', 'Barangay 301', 'Barangay 302', 'Barangay 303', 'Barangay 304', 'Barangay 305', 'Barangay 310', 'Barangay 311', 'Barangay 312', 'Barangay 313', 'Barangay 314', 'Barangay 315', 'Barangay 316', 'Barangay 317', 'Barangay 318', 'Barangay 319', 'Barangay 320', 'Barangay 321', 'Barangay 322', 'Barangay 323', 'Barangay 324', 'Barangay 325', 'Barangay 326', 'Barangay 327', 'Barangay 328', 'Barangay 329', 'Barangay 330', 'Barangay 331', 'Barangay 332', 'Barangay 333', 'Barangay 334', 'Barangay 335', 'Barangay 336', 'Barangay 337', 'Barangay 338', 'Barangay 339', 'Barangay 340', 'Barangay 341', 'Barangay 342', 'Barangay 343', 'Barangay 344', 'Barangay 345', 'Barangay 346', 'Barangay 347', 'Barangay 348', 'Barangay 349', 'Barangay 350', 'Barangay 351', 'Barangay 352', 'Barangay 353', 'Barangay 354', 'Barangay 355', 'Barangay 356', 'Barangay 357', 'Barangay 358', 'Barangay 359', 'Barangay 360', 'Barangay 361', 'Barangay 362', 'Barangay 363', 'Barangay 364', 'Barangay 365', 'Barangay 366', 'Barangay 367', 'Barangay 368', 'Barangay 369', 'Barangay 370', 'Barangay 371', 'Barangay 372', 'Barangay 373', 'Barangay 374', 'Barangay 375', 'Barangay 376', 'Barangay 377', 'Barangay 378', 'Barangay 379', 'Barangay 380', 'Barangay 381', 'Barangay 382'],
            'Makati City': ['Bangkal', 'Bel-Air', 'Carmona', 'Cembo', 'Comembo', 'Dasmariñas', 'East Rembo', 'Forbes Park', 'Guadalupe Nuevo', 'Guadalupe Viejo', 'Kasilawan', 'La Paz', 'Magallanes', 'Olympia', 'Palanan', 'Pembo', 'Pinagkaisahan', 'Pio del Pilar', 'Pitogo', 'Poblacion', 'Post Proper Northside', 'Post Proper Southside', 'Rizal', 'San Antonio', 'San Isidro', 'San Lorenzo', 'Santa Cruz', 'Singkamas', 'South Cembo', 'Tejeros', 'Urdaneta', 'Valenzuela', 'West Rembo'],
            'Quiapo': ['Barangay 306', 'Barangay 307', 'Barangay 308', 'Barangay 309', 'Barangay 383', 'Barangay 384', 'Barangay 385', 'Barangay 386', 'Barangay 387', 'Barangay 388', 'Barangay 389', 'Barangay 390', 'Barangay 391', 'Barangay 392', 'Barangay 393', 'Barangay 394'],
            'Navotas City': ['Bagumbayan North', 'Bagumbayan South', 'Bangculasi', 'Daanghari', 'NBBS Dagat-dagatan', 'NBBS Kaunlaran', 'NBBS Proper', 'Navotas East', 'Navotas West', 'North Bay Boulevard North', 'San Jose', 'San Rafael Village', 'San Roque', 'Sipac-Almacen', 'Tangos North', 'Tangos South', 'Tanza 1', 'Tanza 2'],
            'San Nicolas': ['Barangay 268', 'Barangay 269', 'Barangay 270', 'Barangay 271', 'Barangay 272', 'Barangay 273', 'Barangay 274', 'Barangay 275', 'Barangay 276', 'Barangay 281', 'Barangay 282', 'Barangay 283', 'Barangay 284', 'Barangay 285', 'Barangay 286'],
            'Paranaque City': ['Baclaran', 'B. F. Homes', 'Don Bosco', 'Don Galo', 'La Huerta', 'Marcelo Green Village', 'Merville', 'Moonwalk', 'San Antonio', 'San Dionisio', 'San Isidro', 'San Martin De Porres', 'Santo Niño', 'Sun Valley', 'Tambo', 'Vitalez'],
            'Marikina City': ['Barangka', 'Calumpang', 'Concepcion Dos', 'Concepcion Uno', 'Fortune', 'Industrial Valley', 'Jesus De La Peña', 'Malanday', 'Marikina Heights (Concepcion)', 'Nangka', 'Parang', 'San Roque', 'Santa Elena', 'Santo Niño', 'Tañong', 'Tumana'],
            'Caloocan City': ['Barangay 1', 'Barangay 2', 'Barangay 3', 'Barangay 4', 'Barangay 5', 'Barangay 6', 'Barangay 7', 'Barangay 8', 'Barangay 9', 'Barangay 10', 'Barangay 100', 'Barangay 101', 'Barangay 102', 'Barangay 103', 'Barangay 104', 'Barangay 105', 'Barangay 106', 'Barangay 107', 'Barangay 108', 'Barangay 109', 'Barangay 11', 'Barangay 110', 'Barangay 111', 'Barangay 112', 'Barangay 113', 'Barangay 114', 'Barangay 115', 'Barangay 116', 'Barangay 117', 'Barangay 118', 'Barangay 119', 'Barangay 12', 'Barangay 120', 'Barangay 121', 'Barangay 122', 'Barangay 123', 'Barangay 124', 'Barangay 125', 'Barangay 126', 'Barangay 127', 'Barangay 128', 'Barangay 129', 'Barangay 13', 'Barangay 130', 'Barangay 131', 'Barangay 132', 'Barangay 133', 'Barangay 134', 'Barangay 135', 'Barangay 136', 'Barangay 137', 'Barangay 138', 'Barangay 139', 'Barangay 14', 'Barangay 140', 'Barangay 141', 'Barangay 142', 'Barangay 143', 'Barangay 144', 'Barangay 145', 'Barangay 146', 'Barangay 147', 'Barangay 148', 'Barangay 149', 'Barangay 15', 'Barangay 150', 'Barangay 151', 'Barangay 152', 'Barangay 153', 'Barangay 154', 'Barangay 155', 'Barangay 156', 'Barangay 157', 'Barangay 158', 'Barangay 159', 'Barangay 16', 'Barangay 160', 'Barangay 161', 'Barangay 162', 'Barangay 163', 'Barangay 164', 'Barangay 165', 'Barangay 166', 'Barangay 167', 'Barangay 168', 'Barangay 169', 'Barangay 17', 'Barangay 170', 'Barangay 171', 'Barangay 172', 'Barangay 173', 'Barangay 174', 'Barangay 175', 'Barangay 176', 'Barangay 177', 'Barangay 178', 'Barangay 179', 'Barangay 18', 'Barangay 180', 'Barangay 181', 'Barangay 182', 'Barangay 183', 'Barangay 184', 'Barangay 185', 'Barangay 186', 'Barangay 187', 'Barangay 188', 'Barangay 19', 'Barangay 20', 'Barangay 21', 'Barangay 22', 'Barangay 23', 'Barangay 24', 'Barangay 25', 'Barangay 26', 'Barangay 27', 'Barangay 28', 'Barangay 29', 'Barangay 30', 'Barangay 31', 'Barangay 32', 'Barangay 33', 'Barangay 34', 'Barangay 35', 'Barangay 36', 'Barangay 37', 'Barangay 38', 'Barangay 39', 'Barangay 40', 'Barangay 41', 'Barangay 42', 'Barangay 43', 'Barangay 44', 'Barangay 45', 'Barangay 46', 'Barangay 47', 'Barangay 48', 'Barangay 49', 'Barangay 50', 'Barangay 51', 'Barangay 52', 'Barangay 53', 'Barangay 54', 'Barangay 55', 'Barangay 56', 'Barangay 57', 'Barangay 58', 'Barangay 59', 'Barangay 60', 'Barangay 61', 'Barangay 62', 'Barangay 63', 'Barangay 64', 'Barangay 65', 'Barangay 66', 'Barangay 67', 'Barangay 68', 'Barangay 69', 'Barangay 70', 'Barangay 71', 'Barangay 72', 'Barangay 73', 'Barangay 74', 'Barangay 75', 'Barangay 76', 'Barangay 77', 'Barangay 78', 'Barangay 79', 'Barangay 80', 'Barangay 81', 'Barangay 82', 'Barangay 83', 'Barangay 84', 'Barangay 85', 'Barangay 86', 'Barangay 87', 'Barangay 88', 'Barangay 89', 'Barangay 90', 'Barangay 91', 'Barangay 92', 'Barangay 93', 'Barangay 94', 'Barangay 95', 'Barangay 96', 'Barangay 97', 'Barangay 98', 'Barangay 99'],
            'Malabon City': ['Acacia', 'Baritan', 'Bayan-Bayanan', 'Catmon', 'Concepcion', 'Dampalit', 'Flores', 'Hulong Duhat', 'Ibaba', 'Longos', 'Maysilo', 'Muzon', 'Niugan', 'Panghulo', 'Potrero', 'San Agustin', 'Santolan', 'Tañong', 'Tinajeros', 'Tonsuya', 'Tugatog'],
            'Valenzuela City': ['Arkong Bato', 'Bagbaguin', 'Balangkas', 'Bignay', 'Bisig', 'Canumay East', 'Canumay West', 'Coloong', 'Dalandanan', 'Gen. T. de Leon', 'Isla', 'Karuhatan', 'Lawang Bato', 'Lingunan', 'Mabolo', 'Malanday', 'Malinta', 'Mapulang Lupa', 'Marulas', 'Maysan', 'Palasan', 'Parada', 'Pariancillo Villa', 'Paso de Blas', 'Pasolo', 'Poblacion', 'Pulo', 'Punturin', 'Rincon', 'Tagalag', 'Ugong', 'Viente Reales', 'Wawang Pulo'],
        }

        var $locations = $('#location');
        $('#country').change(function() {
            var country = $(this).val(),
                lcns = locations[country] || [];

            var html = $.map(lcns, function(lcn) {
                return '<option value="' + lcn + '">' + lcn + '</option>'
            }).join('');
            $locations.html(html)
        });
    });
</script>

<script>
    const update_btn = document.querySelectorAll('.update-btn');
    if (update_btn) {
        update_btn.forEach((edit) => {
            edit.addEventListener('click', () => {
                console.log('click');
                const add_id = edit.getAttribute('data-update_add_id');
                document.getElementById('update-add_id').value = add_id;

                const house_no = edit.getAttribute('data-update_house');
                document.getElementById('update-house').value = house_no;

                const street = edit.getAttribute('data-update_street');
                document.getElementById('update-street').value = street;

                const brgy = edit.getAttribute('data-update_brgy');
                document.getElementById('update-brgy').value = brgy;

                const city = edit.getAttribute('data-update_city');
                document.getElementById('update-city').value = city;

                const zip_code = edit.getAttribute('data-update_zip');
                document.getElementById('update-zip').value = zip_code;
            });
        });
    };
    const del_btn = document.querySelectorAll('.delete-btn');
    if (del_btn) {
        del_btn.forEach((del) => {
            del.addEventListener('click', () => {
                console.log('click');
                const add_id = del.getAttribute('data-delete-add_id');
                document.getElementById('delete-id').value = add_id;
            });
        });
    };
</script>