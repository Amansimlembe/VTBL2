<?php
// Start PHP script

// Connect to MySQL database
$conn = new mysqli("localhost", "root", "", "vtbl_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data for a specific auction_no
$auction_no = $_GET['auction_no'] ?? ''; // Assuming auction_no is passed in the URL query string

if (empty($auction_no)) {
    die("Error: auction_no is required.");
}

// Check if auction_no contains a dash
$is_dashed = strpos($auction_no, '-') !== false;

// Define the marks associated with each region
$regions = [
    'Southern Highlands Region' => ['Chivanjee', 'Kibena', 'Itona', 'Ikanga', 'Kiganga', 'Kibwere', 'Lugoda', 'Kilima', 'Luponde', 'Lupembe', 'Kabambe', 'Katumba', 'Mwakaleli', 'Livingstonia'],
    'Tanga Region' => ['Arc Mountain', 'Dindira', 'Kwamkoro', 'Bulwa', 'Mponde'],
    'North West Region' => ['Kagera']
];

// Define grade types
$grade_types = [
    'Brokens' => ['BP1', 'PF1'],
    'Dusts' => ['PD', 'D1'],
    'Secondary' => ['BP', 'PF', 'FNGS', 'D2', 'DUST', 'BMF'],
    'Orthodox' => ['Orthodox']
];

// Initialize counters for each grade type
$grade_lot_ranges = [
    'Brokens' => [],
    'Dusts' => [],
    'Secondary' => [],
    'Orthodox' => []
];

// Adjust the query based on dashed or non-dashed auction_no
$query = $is_dashed ? "SELECT * FROM user_inputs WHERE auction_no LIKE ?" : "SELECT * FROM user_inputs WHERE auction_no = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $auction_no);
$stmt->execute();
$result = $stmt->get_result();

// Flag to check if data exists
$data_exists = false;

// Process rows
while ($row = $result->fetch_assoc()) {
    $data_exists = true; // Mark that data exists
    $mark = $row['mark'];
    $grade = $row['grade'];
    $lot_no = $row['lot_no'];

    // Check and collect lot numbers for the current grade and mark
    foreach ($grade_types as $type => $grades) {
        if (in_array($grade, $grades)) {
            $grade_lot_ranges[$type][$mark][] = $lot_no;
        }
    }
}

// Function to get company and warehouse based on mark
function getCompanyAndWarehouse($mark, $conn, $auction_no) {
    $companies = [
        'MeTL' => ['Arc Mountain', 'Dindira', 'Chivanjee'],
        'Lipton Teas and Infusions' => ['Lugoda', 'Kibwere', 'Kilima', 'Kabambe'],
        'DL Group Ltd' => ['Itona', 'Kibena', 'Ikanga', 'Luponde', 'Livingstonia'],
        'Wakulima Tea Company Ltd' => ['Katumba', 'Mwakaleli'],
        'East Usambara Tea Company Ltd' => ['Kwamkoro', 'Bulwa'],
        'Mponde Holding Company Ltd' => ['Mponde'],
        'Kagera Tea Company Ltd' => ['Kagera'],
        'Kisigo Tea Company Ltd' => ['Kiganga'],
        'Lupembe Tea Company Ltd' => ['Lupembe']
    ];

    // Query for warehouse based on mark and auction_no
    $warehouse = '';
    $stmt = $conn->prepare("SELECT warehouse FROM user_inputs WHERE mark = ? AND auction_no = ?");
    $stmt->bind_param("ss", $mark, $auction_no);
    $stmt->execute();
    $stmt->bind_result($warehouse);
    $stmt->fetch();
    $stmt->close();

    foreach ($companies as $company => $marks) {
        if (in_array($mark, $marks)) {
            return [$company, $warehouse];
        }
    }
    return ['', $warehouse];
}

// Output table rows
if ($data_exists) {
    foreach ($regions as $region => $marks) {
        echo "<tbody>";
        echo "<tr><th colspan='7'>$region</th></tr>"; // Region heading

        foreach ($marks as $mark) {
            if (isset($grade_lot_ranges['Brokens'][$mark]) || isset($grade_lot_ranges['Dusts'][$mark]) || isset($grade_lot_ranges['Secondary'][$mark]) || isset($grade_lot_ranges['Orthodox'][$mark])) {
                // Get lot numbers for each grade type
                $min_max_lot_numbers = [];
                foreach ($grade_types as $type => $grades) {
                    if (isset($grade_lot_ranges[$type][$mark])) {
                        $lot_numbers = $grade_lot_ranges[$type][$mark];
                        $min_max_lot_numbers[$type] = count($lot_numbers) === 1
                            ? $lot_numbers[0] // Single lot_no
                            : min($lot_numbers) . " - " . max($lot_numbers); // Range
                    } else {
                        $min_max_lot_numbers[$type] = '-';
                    }
                }

                // Get company and warehouse
                list($company, $warehouse) = getCompanyAndWarehouse($mark, $conn, $auction_no);

                // Output the row
                echo "<tr>";
                echo "<td>" . htmlspecialchars($mark) . "</td>";
                echo "<td>" . htmlspecialchars($min_max_lot_numbers['Brokens']) . "</td>";
                echo "<td>" . htmlspecialchars($min_max_lot_numbers['Dusts']) . "</td>";
                echo "<td>" . htmlspecialchars($min_max_lot_numbers['Secondary']) . "</td>";
                echo "<td>" . htmlspecialchars($min_max_lot_numbers['Orthodox']) . "</td>";
                echo "<td>" . htmlspecialchars($company) . "</td>";
                echo "<td>" . htmlspecialchars($warehouse) . "</td>";
                echo "</tr>";
            }
        }

        echo "</tbody>";
    }
} else {
    // Display placeholder only if no data exists
    echo "<tr><td colspan='7' style='text-align: center; color: red;'>No data available for this auction number.</td></tr>";
}

$conn->close();
?>
