<?php
session_start();

include("../connection.php");
include("../functions.php");

$admin_data = check_login_admin($con);

// Function for exporting sales to excel
$filename = "Sales.xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");

?>

<table class="table mt-4 table-bordered border-dark">
    <h2 style="text-align: center; margin-top:3rem;">Sales Per Week</h2>
    <thead class="text-center">
        <tr>
            <th scope="col" style="border: 1px solid black;">Date</th>
            <th scope="col" style="border: 1px solid black;">Place Order</th>
            <th scope="col" style="border: 1px solid black;">Total Products</th>
            <th scope="col" style="border: 1px solid black;">Total Price</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $export_data = "SELECT * FROM user_order ORDER BY `date` DESC"; // Fetch data from the table customers using id
        $result = mysqli_query($con, $export_data);
        $grand_total = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $grand_total += ($row['total_price']);
        ?>
            <tr>
                <td style="border: 1px solid black;"><?php echo $row["date"]; ?></td>
                <td style="border: 1px solid black;"><?php echo $row["place_order"]; ?></td>
                <td style="border: 1px solid black;"><?php echo $row["total_products"]; ?></td>
                <td style="border: 1px solid black;">₱<?php echo number_format($row["total_price"]); ?>.00</td>
            </tr>
        <?php
        }

        ?>
        <tr>
            <td class="fw-bold" colspan="3" style="border: 1px solid black;">Total Sales</td>
            <td class="fw-bold" style="border: 1px solid black;">₱<?php echo number_format($grand_total); ?>.00</td>
        </tr>
    </tbody>
</table>