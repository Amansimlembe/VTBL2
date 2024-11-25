<?php 
// Database configuration
$host = 'localhost'; 
$username = 'root'; 
$password = ''; 
$database = 'vtbl_db'; 

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Normalize auction_no by removing dashes
function normalizeAuctionNo($auctionNo) {
    return str_replace('-', '', $auctionNo);
}

// Fetching auction data based on selected auction_no
if (isset($_POST['auction_no'])) {
    $auction_no_input = $_POST['auction_no'];
    $normalized_auction_no = normalizeAuctionNo($auction_no_input);

    // Prepare the query to fetch auction dates
    $query = "
        SELECT 
            auction_no,
            DATE_FORMAT(auction_date, '%d-%m-%Y') AS auction_date,
            DATE_FORMAT(prompt_date, '%d-%m-%Y') AS prompt_date
        FROM auction_dates 
        WHERE REPLACE(auction_no, '-', '') = '$normalized_auction_no';
    ";
    
    $result = $conn->query($query);
    $auction_data = $result->fetch_assoc();

    // Define the marks associated with each region
    $regions = [
        'south' => ['Chivanjee', 'kibena', 'Itona', 'Ikanga', 'Kiganga', 'Kibwere', 'Lugoda', 'Kilima', 'kabambe', 'Luponde', 'Lupembe', 'Katumba', 'Mwakaleli', 'Livingstonia'], 
        'tanga' => ['Arc mountain', 'Dindira', 'Kwamkoro', 'Mponde'], 
        'west' => ['Kagera']
    ];
    
    $region_data = [];
    $total_fresh_pkgs = 0;
    $total_fresh_kgs = 0;
    $total_reprint_pkgs = 0;
    $total_reprint_kgs = 0;
    $total_lots = 0; // Variable to accumulate total lots across all regions

    // Loop through each region to fetch data, calculate totals, and count rows (lots)
    foreach ($regions as $region => $marks) {
        // Query for region data based on `mark` values and calculate total lots (row count)
        $region_query = "
            SELECT 
                COUNT(*) AS lots, 
                SUM(CASE WHEN nature = 'Fresh' THEN no_of_pkgs ELSE 0 END) AS fresh_pkgs,
                SUM(CASE WHEN nature = 'Fresh' THEN net_weight ELSE 0 END) AS fresh_kgs,
                SUM(CASE WHEN nature = 'Reprint' THEN no_of_pkgs ELSE 0 END) AS reprint_pkgs,
                SUM(CASE WHEN nature = 'Reprint' THEN net_weight ELSE 0 END) AS reprint_kgs
            FROM user_inputs
            WHERE REPLACE(auction_no, '-', '') = '$normalized_auction_no'
            AND mark IN ('" . implode("','", $marks) . "');
        ";
        
        $region_result = $conn->query($region_query);
        $region_data[$region] = $region_result->fetch_assoc();

        // Update total sums and total lots
        $total_fresh_pkgs += $region_data[$region]['fresh_pkgs'];
        $total_fresh_kgs += $region_data[$region]['fresh_kgs'];
        $total_reprint_pkgs += $region_data[$region]['reprint_pkgs'];
        $total_reprint_kgs += $region_data[$region]['reprint_kgs'];
        $total_lots += $region_data[$region]['lots']; // Accumulate lots count from each region

        // Calculate total fresh-reprint packages and kgs for each region
        $region_data[$region]['total_fresh_reprint_pkgs'] = $region_data[$region]['fresh_pkgs'] + $region_data[$region]['reprint_pkgs'];
        $region_data[$region]['total_fresh_reprint_kgs'] = $region_data[$region]['fresh_kgs'] + $region_data[$region]['reprint_kgs'];
    }

    // Prepare total fresh-reprint packages and kgs for the entire dataset
    $total_fresh_reprint_pkgs = $total_fresh_pkgs + $total_reprint_pkgs;
    $total_fresh_reprint_kgs = $total_fresh_kgs + $total_reprint_kgs;

    // Prepare response data
    $response = [
        'auction_no' => $auction_data['auction_no'] ?? '',
        'auction_date' => $auction_data['auction_date'] ?? '',
        'prompt_date' => $auction_data['prompt_date'] ?? '',
        'south' => $region_data['south'] ?? [],
        'tanga' => $region_data['tanga'] ?? [],
        'west' => $region_data['west'] ?? [],
        'total_fresh_pkgs' => $total_fresh_pkgs,
        'total_fresh_kgs' => $total_fresh_kgs,
        'total_reprint_pkgs' => $total_reprint_pkgs,
        'total_reprint_kgs' => $total_reprint_kgs,
        'total_fresh_reprint_pkgs' => $total_fresh_reprint_pkgs,
        'total_fresh_reprint_kgs' => $total_fresh_reprint_kgs,
        'total_lots' => $total_lots // Total lots across all regions
    ];

    // Output data as JSON
    echo json_encode($response);

    // Close database connection
    $conn->close();
}
?>
