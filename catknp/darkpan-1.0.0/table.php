          <style>
    body {
        background-color: black;
        color: red;
    }

    h6,
    a,
    th,
    td {
        color: red;
    }

    .table {
        background-color: black;
        color: red;
    }

    .table-bordered,
    .table-bordered th,
    .table-bordered td {
        border-color: red;
    }

    .btn-primary {
        background-color: red;
        color: black;
    }

    .btn-primary:hover {
        background-color: black;
        color: red;
    }
</style>

            <?php     
// Include the database connection file
include('dbconnection.php');

// Extract ADNO from the URL
$adno = $_GET['adno']; // You might need to adjust this based on your URL structure

// Query to fetch data from the database for the specified ADNO
$sql = "SELECT img_name, date, ADNO, Marks FROM recieved WHERE ADNO = :adno";
$stmt = $db->prepare($sql);
$stmt->bindParam(':adno', $adno, PDO::PARAM_INT);
$stmt->execute();

// Check if there are rows in the result set
if ($stmt->rowCount() > 0) {
    echo '
    <h6 class="mb-0">Recent Sales</h6>
    <a href="">Show All</a>
    <div class="table-responsive">
        <table class="table text-start align-middle table-bordered table-hover mb-0">
            <thead>
                <tr class="text-white">
                    <th scope="col"><input class="form-check-input" type="checkbox"></th>
                    <th scope="col">Date</th>
                    <th scope="col">Image Name</th>
                    <th scope="col">ADNO</th>
                    <th scope="col">Marks</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>';

    // Loop through the rows and display data
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '
        <tr>
            <td><input class="form-check-input" type="checkbox"></td>
            <td>' . $row['date'] . '</td>
            <td>' . $row['img_name'] . '</td>
            <td>' . $row['ADNO'] . '</td>
            <td>' . $row['Marks'] . '</td>
            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
        </tr>';
    }

    echo '
            </tbody>
        </table>
    </div>
</div>';
} else {
    echo '<p>No records found for ADNO ' . $adno . '</p>';
}

// Close the database connection
unset($db);
?>