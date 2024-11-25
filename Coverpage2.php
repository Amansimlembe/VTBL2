<?php
include('db_connection.php');

// Initialize auction_no and auction_date
$auctionNo = '';
$auctionDate = '';

// Function to normalize auction_no by removing dashes
function normalizeAuctionNo($auctionNo) {
    return str_replace('-', '', $auctionNo); // Remove dashes
}

// Check if auction_no is provided (via POST or GET)
if (isset($_POST['auction_no']) || isset($_GET['auction_no'])) {
    $inputAuctionNo = isset($_POST['auction_no']) ? $_POST['auction_no'] : $_GET['auction_no'];
    $normalizedAuctionNo = normalizeAuctionNo($inputAuctionNo);

    // Fetch auction_no and auction_date using the normalized auction_no
    $sql = "SELECT auction_no, auction_date FROM auction_dates WHERE REPLACE(auction_no, '-', '') = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $normalizedAuctionNo);
    $stmt->execute();
    $stmt->bind_result($auctionNo, $auctionDate);
    $stmt->fetch();
    $stmt->close();
}

// Fetch all available auction numbers for the dropdown
$dropdown_sql = "SELECT auction_no FROM auction_dates";
$dropdown_result = $conn->query($dropdown_sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tea Catalogue Cover Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #cover2body {
       
       font-family: Century Gothic;
       margin: 0;
       padding: 0;
       box-sizing: border-box;
   }

   .cover-page2 {
       text-align: center;
       margin: 0 auto;
       border: 1px solid black;
       padding: 20px;
       box-sizing: border-box;
       display: flex;
       flex-direction: column;
       justify-content: space-between;
       margin-bottom: 40px;
       border: 2px solid #000; ;
   }

   .cover-page2 .bordered-title {
       border: 2px solid #000;
       color: green;
       font-weight: bolder;
       margin-bottom: 0px;
       font-size: 1em; /* Default font size */
   }

   .cover-page2 .bordered-index {
       border-bottom: 2px solid black;
       margin: 0 0 30px 0;
       padding: 0;
       font-size: 1.2em; /* Default font size */
   }

   .cover-page2 .table-container2 {
       margin: 0;
       padding: 0;
   }

   .cover-page2 .cover2table {
       border-collapse: collapse;
       width: 100%;
   }

   .cover-page2 .cover2table th {
       padding: 5px;
       text-align: center;
       font-size: 1em; /* Default font size */
       border: none;
   }

   .cover-page2 .cover2table td {
       padding: 5px;
       text-align: center;
       font-size: 1em; /* Default font size */
       border: none;
   }

   .cover-page2 .cover2table th[colspan="7"] {
       text-align: left;
       border-top: 2px solid #000;
       border-bottom: 2px solid #000;
   }


   @media print {
    @page {
        size: landscape; /* Ensures the page prints in landscape orientation */
        margin: 1cm; /* Optional: Adjust margins */
    }

    body {
        font-size: 12pt; /* Adjust font size for better readability in print */
        color: black; /* Ensure text is visible */
    }

    .cover-page2 {
        border: none; /* Optional: Remove borders in print */
        box-shadow: none; /* Remove any box-shadow for a clean print */
    }

    /* Ensure the table looks good in print */
    .cover2table th, .cover2table td {
        border: 1px solid black; /* Add visible borders for printed table */
        padding: 10px; /* Add spacing for clarity */
    }

    .cover2table {
        width: 100%; /* Ensure the table spans the full width of the page */
    }
}

   


/* Responsive Font Sizes and Layout Adjustments */
@media (max-width: 768px) {
    .cover-page2 .cover2table th,
    .cover-page2 .cover2table td {
        font-size: 0.9em; /* Smaller font for smaller screens */
        padding: 8px; /* Adjust padding */
    }
}

@media (max-width: 480px) {
    .cover-page2 .cover2table th,
    .cover-page2 .cover2table td {
        font-size: 0.8em; /* Further reduce font size */
        padding: 6px; /* Reduce padding for compact layout */
    }

    .cover-page2 .table-container2 {
        border-width: 0; /* Optional: Hide outer border for compact devices */
    }

}
    </style>
</head>
<body>
    <section class="cover-page2">
        <div class="bordered-title">
            <h1>VISION TEA BROKERS LTD</h1>
        </div>
        <div class="bordered-index">
            <h1>Index for Auction Sale No. <span id="auctionNoValue2"></span> of <span id="auctionDateValue2"></span></h1>
        </div>

        <div class="table-container2">
            <table class="cover2table">
                <thead>
                    <tr>
                        <th>Sell Mark</th>
                        <th colspan="4">Lot Nos</th>
                        <th>Company</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Brokens</th>
                        <th>Dusts</th>
                        <th>Secondary</th>
                        <th>Orthodox</th>
                        <th>Estate/Producer Name</th>
                        <th>Warehouse Name (WH Code)</th>
                    </tr>
                </thead>
                <tbody id="data-table-body">
                    <?php if (empty($auctionNo)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: red;">No Auction Number Selected</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {



            const auctionSelect = document.getElementById('auction_no');
            const dataTableBody = document.getElementById('data-table-body');

            // Load data if auction_no exists in localStorage
            const storedAuctionNo = localStorage.getItem('auction_no');
            if (storedAuctionNo) {
                auctionSelect.value = storedAuctionNo;
                fetchAuctionData(storedAuctionNo);
            }

            // Fetch data on auction_no change
            auctionSelect.addEventListener('change', function () {
                const auctionNo = this.value;
                if (auctionNo) {
                    localStorage.setItem('auction_no', auctionNo);
                    fetchAuctionData(auctionNo);
                } else {
                    localStorage.removeItem('auction_no');
                    dataTableBody.innerHTML = `
                        <tr>
                            <td colspan="7" style="text-align: center; color: red;">No Auction Number Selected</td>
                        </tr>
                    `;
                }
            });

            // Function to fetch auction data
            function fetchAuctionData(auctionNo) {
                fetch(`fetch_coverpage2_data.php?auction_no=${auctionNo}`)
                    .then(response => response.text())
                    .then(data => {
                        if (data) {
                            dataTableBody.innerHTML = data;
                        } else {
                            dataTableBody.innerHTML = `
                                <tr>
                                    <td colspan="7" style="text-align: center; color: red;">No Data Available</td>
                                </tr>
                            `;
                        }
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }
        });
    </script>
</body>
</html>
