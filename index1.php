<?php
// Database connection
$servername = "localhost"; // Update with your server name if needed
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "vtbl_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use isset() to avoid undefined index notices
    $row_limit_id = isset($_POST['row_limit_id']) ? $_POST['row_limit_id'] : null;
    $comments = isset($_POST['comments']) ? $_POST['comments'] : '';
    $warehouse = isset($_POST['warehouse']) ? $_POST['warehouse'] : '';
    $value = isset($_POST['value']) ? $_POST['value'] : '';
    $mark = isset($_POST['mark']) ? $_POST['mark'] : null; // Check if allowed to be null
    $grade = isset($_POST['grade']) ? $_POST['grade'] : null; // Check if allowed to be null
    $manf_date = isset($_POST['manf_date']) ? $_POST['manf_date'] : null;
    $certification = isset($_POST['certification']) ? $_POST['certification'] : '';
    $invoice = isset($_POST['invoice']) ? $_POST['invoice'] : '';
    $no_of_pkgs = isset($_POST['no_of_pkgs']) ? $_POST['no_of_pkgs'] : null;
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $net_weight = isset($_POST['net_weight']) ? $_POST['net_weight'] : null;
    $nature = isset($_POST['nature']) ? $_POST['nature'] : '';
    $sale_price = isset($_POST['sale_price']) ? $_POST['sale_price'] : null;
    $buyer_and_packages = isset($_POST['buyer_and_packages']) ? $_POST['buyer_and_packages'] : '';

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO user_inputs (row_limit_id, comments, warehouse, value, mark, grade, manf_date, certification, invoice, no_of_pkgs, type, net_weight, nature, sale_price, buyer_and_packages) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssissdssss", $row_limit_id, $comments, $warehouse, $value, $mark, $grade, $manf_date, $certification, $invoice, $no_of_pkgs, $type, $net_weight, $nature, $sale_price, $buyer_and_packages);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
// Assuming you have established a connection to your MySQL database using $conn

// Retrieve Main Lot data from row_limit
$mainLotResult = $conn->query("SELECT * FROM row_limit WHERE main_lot IS NOT NULL");

// Retrieve Secondary Lot data from row_limit
$secondaryLotResult = $conn->query("SELECT * FROM row_limit WHERE secondary_lot IS NOT NULL");

// Create an array to hold row_limit IDs for the dropdown
$rowLimitOptions = [];
while ($row = $conn->query("SELECT auction_no, main_lot, secondary_lot FROM row_limit")->fetch_assoc()) { 
    $rowLimitOptions[$row['auction_no']] = [
        'main_lot' => $row['main_lot'], 
        'secondary_lot' => $row['secondary_lot']
    ];
}

// And for user inputs data display
$userInputResult = $conn->query("SELECT * FROM user_inputs");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Inputs</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>User Input Form</h1>
    <form method="post" action="">
    <h2>Auction Input Form</h2>
    <form action="submit_auction.php" method="post">
        <label for="auction_no">Auction No:</label>
        <input type="number" id="auction_no" name="auction_no" required><br><br>
        
        <label for="main_lot">Main Lot:</label>
        <input type="number" id="main_lot" name="main_lot" required><br><br>
        
        <label for="secondary_lot">Secondary Lot:</label>
        <input type="number" id="secondary_lot" name="secondary_lot" required><br><br>
        
        <label for="start_lot">Start Lot:</label>
        <input type="number" id="start_lot" name="start_lot" required><br><br>
        
        <label for="order_of_sale">Order of Sale:</label>
        <input type="text" id="order_of_sale" name="order_of_sale" required><br><br>
        
        <input type="submit" value="Submit">
    </form>

        <label for="comments">Comments:</label>
        <input type="text" name="comments"><br>

        <label for="warehouse">Warehouse:</label>
        <input type="text" name="warehouse"><br>

        <label for="value">Value:</label>
        <input type="text" name="value"><br>

        <label for="mark">Mark:</label>
        <select name="mark" required>
            <option value="" disabled selected>Select a mark</option> <!-- Default placeholder option -->
            <option value="Arc Mountain">Arc Mountain</option>
            <option value="Dindira">Dindira</option>
            <option value="Kibena">Kibena</option>
            <option value="Ikanga">Ikanga</option>
            <option value="Itona">Itona</option>
            <option value="Livingstonia">Livingstonia</option>
            <option value="Bulwa">Bulwa</option>
            <option value="Kwamkoro">Kwamkoro</option>
            <option value="Mponde">Mponde</option>
            <option value="Kisigo">Kisigo</option>
            <option value="Kagera">Kagera</option>
            <option value="Kibwele">Kibwele</option>
            <option value="Lugoda">Lugoda</option>
            <option value="Kilima">Kilima</option>
            <option value="Lupembe">Lupembe</option>
            <option value="Luponde">Luponde</option>
            <option value="Katumba">Katumba</option>
            <option value="Mwakaleli">Mwakaleli</option>
        </select><br>
        <br>

        <label for="grade">Grade:</label>
        <select name="grade" required>
            <option value="BP1">BP1</option>
            <option value="PF1">PF1</option>
            <option value="PD">PD</option>
            <option value="D1">D1</option>
            <option value="BP">BP</option>
            <option value="PF">PF</option>
            <option value="FNGS">FNGS</option>
            <option value="D2">D2</option>
            <option value="DUST">DUST</option>
            <option value="BMF">BMF</option>
        </select><br>

        <label for="manf_date">Manufacturing Date:</label>
        <input type="date" name="manf_date"><br>

        <label for="certification">Certification:</label>
        <input type="text" name="certification"><br>

        <label for="invoice">Invoice:</label>
        <input type="text" name="invoice"><br>

        <label for="no_of_pkgs">Number of Packages:</label>
        <input type="number" name="no_of_pkgs" required><br>

        <label for="type">Type:</label>
        <input type="text" name="type"><br>

        <label for="net_weight">Net Weight:</label>
        <input type="number" step="0.01" name="net_weight" required><br>

        <label for="nature">Nature:</label>
        <input type="text" name="nature"><br>

        <label for="sale_price">Sale Price:</label>
        <input type="number" step="0.01" name="sale_price" required><br>

        <label for="buyer_and_packages">Buyer and Packages:</label>
        <input type="text" name="buyer_and_packages"><br>

        <button type="submit">Submit</button>
    </form>

    <h2>Main Lot Data</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Auction No</th>
            <th>Main Lot</th>
            <th>Secondary Lot</th>
            <th>Start Lot</th>
            <th>Order of Sale</th>
        </tr>
        <?php
        // Display Main Lot data
        if ($mainLotResult->num_rows > 0) {
            while ($row = $mainLotResult->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['row_id']}</td>
                        <td>{$row['auction_no']}</td>
                        <td>{$row['main_lot']}</td>
                        <td>{$row['secondary_lot']}</td>
                        <td>{$row['start_lot']}</td>
                        <td>{$row['order_of_sale']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No Main Lot data available</td></tr>";
        }
        ?>
    </table>

    <h2>Secondary Lot Data</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Auction No</th>
            <th>Main Lot</th>
            <th>Secondary Lot</th>
            <th>Start Lot</th>
            <th>Order of Sale</th>
        </tr>
        <?php
        // Display Secondary Lot data
        if ($secondaryLotResult->num_rows > 0) {
            while ($row = $secondaryLotResult->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['row_id']}</td>
                        <td>{$row['auction_no']}</td>
                        <td>{$row['main_lot']}</td>
                        <td>{$row['secondary_lot']}</td>
                        <td>{$row['start_lot']}</td>
                        <td>{$row['order_of_sale']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No Secondary Lot data available</td></tr>";
        }
        ?>
    </table>

    <h2>User Input Data</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Row Limit ID</th>
            <th>Comments</th>
            <th>Warehouse</th>
            <th>Value</th>
            <th>Mark</th>
            <th>Grade</th>
            <th>Manufacturing Date</th>
            <th>Certification</th>
            <th>Invoice</th>
            <th>No of Packages</th>
            <th>Type</th>
            <th>Net Weight</th>
            <th>Nature</th>
            <th>Sale Price</th>
            <th>Buyer and Packages</th>
        </tr>
        <?php
        // Display User Input data
        if ($userInputResult->num_rows > 0) {
            while ($row = $userInputResult->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['row_limit_id']}</td>
                        <td>{$row['comments']}</td>
                        <td>{$row['warehouse']}</td>
                        <td>{$row['value']}</td>
                        <td>{$row['mark']}</td>
                        <td>{$row['grade']}</td>
                        <td>{$row['manf_date']}</td>
                        <td>{$row['certification']}</td>
                        <td>{$row['invoice']}</td>
                        <td>{$row['no_of_pkgs']}</td>
                        <td>{$row['type']}</td>
                        <td>{$row['net_weight']}</td>
                        <td>{$row['nature']}</td>
                        <td>{$row['sale_price']}</td>
                        <td>{$row['buyer_and_packages']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='16'>No User Input data available</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
