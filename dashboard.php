<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Vision Tea Brokers Management System</title>
    <link rel="stylesheet" href="VTBL-NavBar3.css">
    <link rel="stylesheet" href="AuctionCatalog.css">
    <script src="https://kit.fontawesome.com/9458984521.js" crossorigin="anonymous"></script>
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            animation: fadeIn 1.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .dashboard-container {
            padding: 20px;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 80px;
            grid-template-rows: repeat(2, 1fr);
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            justify-items: center;
            align-items: center;
        }
        #auction-container {
    position: fixed; /* Ensures the container stays relative to the viewport */
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    width: 216px; /* Adjust width as needed */
    display: none;
    overflow: hidden;
}

#auction-container select {
    width: 100%; /* Adjust to the desired width */
    height: auto; /* Allow the dropdown to adjust dynamically */
    max-height: calc(9 * 2.5em); /* Approximate height for 9 rows; adjust '2.5em' if row height varies */
    overflow-y: auto; /* Enable scrolling for additional options */
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #f9f9f9;
    color: green;
    font-weight: bold;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}



        .card {
            background: linear-gradient(135deg, #ffffff, #f0f0f5);
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transform: scale(1) translateY(50px);
            opacity: 0;
            animation: cardLoad 0.8s ease forwards;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
            margin: 0;
        }

        @keyframes cardLoad {
            to {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            background: linear-gradient(135deg, #e0f7fa, #ffffff);
        }

        .card:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 0%;
            background: rgba(43, 103, 119, 0.1);
            z-index: -1;
            transition: height 0.3s;
        }

        .card:hover:before {
            height: 100%;
        }

        .card i {
            font-size: 48px;
            color: #2b6777;
            margin-bottom: 10px;
            transition: transform 0.3s, color 0.3s;
        }

        .card:hover i {
            transform: scale(1.2);
            color: #1d4e57;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        .card:hover i {
            animation: bounce 1s;
        }

        .card h2 {
            font-size: 20px;
            color: #333;
            margin: 0;
            transition: text-shadow 0.3s, color 0.3s;
        }

        .card:hover h2 {
            color: #1d4e57;
            text-shadow: 0 0 5px #1d4e57;
        }

        .card p {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .summary-cards {
                grid-template-columns: 1fr;
                grid-template-rows: auto;
            }
        }
    </style>
</head>
<body id="body">
    
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <div class="summary-cards">
            <div class="card" id="card1">
                <i class="fa-solid fa-prescription"></i>
                <h2>Catalogues</h2>
                <p>Manage auction catalogues and private offers.</p>
            </div>
            <div class="card" id="card2">
                <i class="fa-solid fa-universal-access"></i>
                <h2>Sales Results</h2>
                <p>View auction and private sale results.</p>
            </div>
            <div class="card" id="card3">
                <i class="fa-solid fa-file-invoice"></i>
                <h2>Accounts</h2>
                <p>Generate invoices, bank letters, and more.</p>
            </div>
            <div class="card" id="card4">
                <i class="fa-regular fa-flag"></i>
                <h2>Reports</h2>
                <p>Access market and trade statistics reports.</p>
            </div>
        </div>
    </div>

    <!-- Dropdown for Auction Numbers -->
    <div id="auction-container" style="display:none; text-align:center;">
        <select id="auction_no" name="auction_no" size="9" required >
            
            <?php
            // PHP to fetch and display auction numbers
            $conn = new mysqli("localhost", "root", "", "vtbl_db");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $result = $conn->query("SELECT auction_no FROM auction_dates");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['auction_no']}'>CATALOGUE NO: {$row['auction_no']}</option>";
            }
            $conn->close();
            ?>
        </select>
    </div>
    <script>
        $(document).ready(function () {
            // Show auction container when #card1 is clicked
            $('#card1').click(function () {
                const offset = $(this).offset();
                const cardWidth = $(this).outerWidth();
                const containerWidth = $('#auction-container').outerWidth();
                const containerHeight = $('#auction-container').outerHeight();

                // Center the auction container on top of the card
                $('#auction-container')
                    .css({
                        top: offset.top - containerHeight - -250 + 'px',  // 10px offset above the card
                        left: offset.left + (cardWidth / 2) - (containerWidth / 2) + 'px'
                    })
                    .fadeIn(200); // Show the container
            });

            // Hide auction container when clicking outside
            $(document).click(function (e) {
                if (!$(e.target).closest('#auction-container, #card1').length) {
                    $('#auction-container').fadeOut(200); // Hide container
                }
            });
            
     
        });

    </script>
</body>
</html>
