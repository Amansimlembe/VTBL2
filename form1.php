<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tea Catalogue Cover Page</title>
    <style>
       body {
    font-family: Century Gothic;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.cover-page1 {
    text-align: center;
    margin: 0 auto;
    padding: 8px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    margin-bottom: 15px;
}

.outertable, #cover1table {
    width: 100%;
    border-collapse: collapse; /* Ensures borders between cells are merged */
    border-spacing: 0; /* Removes spacing between cells */
}

.bordered-div {
    border: 2px solid #000;
    padding: 5px;
    margin-bottom: 8px;
    text-align: center;
}

.logo {
    display: flex;
    justify-content: center;
    align-items: center;
    color: green;
    font-weight: bolder;
}

.logo img {
    max-height: 40px;
    vertical-align: middle;
}

h1, h2 {
    margin: 5px 0;
}

h4 {
    margin: 3px 0;
}

.order-of-sale {
    margin: 10px 0;
    text-align: center;
}

.order-of-sale h1 {
    text-decoration: underline;
    text-decoration-thickness: 2px;
}

.contact-info {
    text-align: left;
}

#cover1table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 10px;
    border: 2px solid #000;
}

#cover1table th, #cover1table td {
    border: 1px solid #000;
    padding: 5px;
    text-align: center;
}

hr {
    margin: 10px 0;
    font-weight: bold;
}

.prompt {
    border-top: 2px dashed black;
    border-bottom: 2px dashed black;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;
}

.prompt-date {
    font-weight: bold;
}

.bold-row{
    font-weight: bolder;
    background-color: green;
    color:white;
}
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <section class="cover-page1">
        <div class="form-group">
            <label for="auction_no">Auction No:</label>
            <select id="auction_no" name="auction_no" required>
                <option value="">Select Auction No</option>
                <?php
                // Connect to MySQL database
                $conn = new mysqli("localhost", "root", "", "vtbl_db");

                // Fetch all auction numbers from auction_dates table
                $result = $conn->query("SELECT auction_no FROM auction_dates");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['auction_no']}'>{$row['auction_no']}</option>";
                }
                $conn->close();
                ?>
            </select>
        </div>

        <table class="outertable">
            <tr>
                <th colspan="2" class="bordered-div logo">
                    <h1>VISION TEA BROKERS LTD</h1>
                    <img src="Vision.logo1.png">
                </th>
            </tr>
            <tr>
                <th colspan="2" class="bordered-div">
                    <h1>AUCTION Sale No. <span id="auctionNoValue1"></span> of <span id="auctionDateValue1"></span></h1>
                    <h1>TANZANIA TEAS</h1>
                    <h1>FOR SALE BY ONLINE AUCTION</h1>
                    <h4>Subject to the DAR ES SALAAM TEA AUCTION RULES AND CONDITIONS of sale exhibited in the TMX Online Platform.</h4>
                </th>
            </tr>
            <tr>
                <th colspan="2" class="table-container1">
                    <table id="cover1table">
                        <thead>
                            <tr>
                                <th>Region</th>
                                <th>Lots</th>
                                <th>Fresh_Pkgs</th>
                                <th>Fresh_Kgs</th>
                                <th>Reprint Pkgs</th>
                                <th>Reprint Kgs</th>
                                <th>Total Pkgs</th>
                                <th>Total Kgs</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th id="south">SOUTHERN HIGHLANDS REGION</th>
                                <td><span id="south_lots"></span></td>
                                <td><span id="south_fresh_pkgs"></span></td>
                                <td><span id="south_fresh_kgs"></span></td>
                                <td><span id="south_reprint_pkgs"></span></td>
                                <td><span id="south_reprint_kgs"></span></td>
                                <td><span id="south_fresh_reprint_pkgs"></span></td>
                                <td><span id="south_fresh_reprint_kgs"></span></td>
                            </tr>
                            <tr>
                                <th id="tanga">TANGA REGION</th>
                                <td><span id="tanga_lots"></span></td>
                                <td><span id="tanga_fresh_pkgs"></span></td>
                                <td><span id="tanga_fresh_kgs"></span></td>
                                <td><span id="tanga_reprint_pkgs"></span></td>
                                <td><span id="tanga_reprint_kgs"></span></td>
                                <td><span id="tanga_fresh_reprint_pkgs"></span></td>
                                <td><span id="tanga_fresh_reprint_kgs"></span></td>
                            </tr>
                            <tr>
                                <th id="west">NORTH WEST ZONE</th>
                                <td><span id="west_lots"></span></td>
                                <td><span id="west_fresh_pkgs"></span></td>
                                <td><span id="west_fresh_kgs"></span></td>
                                <td><span id="west_reprint_pkgs"></span></td>
                                <td><span id="west_reprint_kgs"></span></td>
                                <td><span id="west_fresh_reprint_pkgs"></span></td>
                                <td><span id="west_fresh_reprint_kgs"></span></td>
                            </tr>
                            <tr class="bold-row">
                                <th id="total">TOTALS:</th>
                                <td><span id="total_lots"></span></td>
                                <td><span id="total_fresh_pkgs"></span></td>
                                <td><span id="total_fresh_kgs"></span></td>
                                <td><span id="total_reprint_pkgs"></span></td>
                                <td><span id="total_reprint_kgs"></span></td>
                                <td><span id="total_fresh_reprint_pkgs"></span></td>
                                <td><span id="total_fresh_reprint_kgs"></span></td>
                               
                            </tr>
                        </tbody>
                    </table>
                </th>
            </tr>
            <tr>
    <th colspan="2" class="order-of-sale">
        <h1>ORDER OF SALE</h1>
        <div>
            <h5 id="order1" class="clickable">1. VISION TEA BROKERS LTD</h5>
            <h5 id="order2" class="clickable">2. COHERENT TEA BROKERS LTD</h5>
        </div>
    </th>
</tr>
            <tr>
                <td colspan="2" class="prompt">
                    PROMPT DATE: <span id="prompt-date" class="prompt-date"></span>
                </td>
            </tr>
        </table>
    </section>
    <script>
       $(document).ready(function() {

     // Function to save the order to localStorage
function saveOrderToLocalStorage(orderData) {
    localStorage.setItem("order", JSON.stringify(orderData)); // Consistent key usage
}

// Load order from localStorage if available
const savedOrder = localStorage.getItem('order');
if (savedOrder) {
    const order = JSON.parse(savedOrder);
    // Assign values based on the saved order
    if (order[0] === '1') {
        $('#order1').text('1. VISION TEA BROKERS LTD');
        $('#order2').text('2. COHERENT TEA BROKERS LTD');
    } else if (order[0] === '2') {
        $('#order1').text('2. COHERENT TEA BROKERS LTD');
        $('#order2').text('1. VISION TEA BROKERS LTD');
    }
}

// Click event for the order items
$('.clickable').on('click', function() {
    const clickedOrder = $(this).text();
    if (this.id === 'order1') {
        // Swap order 1 with order 2
        const newOrder1 = '2. ' + $('#order2').text().split('. ')[1];
        const newOrder2 = '1. ' + clickedOrder.split('. ')[1];
        $('#order1').text(newOrder1);
        $('#order2').text(newOrder2);
    } else if (this.id === 'order2') {
        // Swap order 2 with order 1
        const newOrder2 = '2. ' + $('#order1').text().split('. ')[1];
        const newOrder1 = '1. ' + clickedOrder.split('. ')[1];
        $('#order1').text(newOrder1);
        $('#order2').text(newOrder2);
    }

    // Save the updated order to localStorage
    const order = [
        $('#order1').text().split('. ')[0], // Save the numeric part (1 or 2)
        $('#order2').text().split('. ')[0]  // Save the numeric part (1 or 2)
    ];
    saveOrderToLocalStorage(order); // Use the function to save the order
});

// Check if auction data is already stored in localStorage and populate the content accordingly
const storedData = localStorage.getItem('auction_data');
if (storedData) {
    const response = JSON.parse(storedData);
    populateAuctionData(response); // Populate auction data if available
}


    // Handle change event for auction_no
    $('#auction_no').on('change', function() {
        const auctionNo = $(this).val();

        if (auctionNo) {
            // Fetch data and store it in localStorage
            $.ajax({
                url: 'fetch_coverpage1_data.php',
                type: 'POST',
                data: { auction_no: auctionNo },
                dataType: 'json',
                success: function(response) {
                    // Store the fetched data in localStorage
                    localStorage.setItem('auction_data', JSON.stringify(response));

                    // Update Auction Sale Info
                    populateAuctionData(response);
                },
                error: function(xhr, status, error) {
                    console.log("Error: " + error);
                }
            });
        } else {
            // If no auction_no is selected, clear the data
            clearAuctionData();
            // Optionally, remove data from localStorage when no auction is selected
            localStorage.removeItem('auction_data');
        }
    });

    // Function to populate the auction data into the table
    function populateAuctionData(response) {
        // Update Auction Sale Info
        $('#auctionNoValue1').text(response.auction_no);
        $('#auctionDateValue1').text(response.auction_date);
        $('#prompt-date').text(response.prompt_date);

        // Update data for South region
        $('#south_lots').text(response.south.lots);
        $('#south_fresh_pkgs').text(response.south.fresh_pkgs);
        $('#south_fresh_kgs').text(response.south.fresh_kgs);
        $('#south_reprint_pkgs').text(response.south.reprint_pkgs);
        $('#south_reprint_kgs').text(response.south.reprint_kgs);
        $('#south_fresh_reprint_pkgs').text(response.south.total_fresh_reprint_pkgs);
        $('#south_fresh_reprint_kgs').text(response.south.total_fresh_reprint_kgs);

        // Update data for Tanga region
        $('#tanga_lots').text(response.tanga.lots);
        $('#tanga_fresh_pkgs').text(response.tanga.fresh_pkgs);
        $('#tanga_fresh_kgs').text(response.tanga.fresh_kgs);
        $('#tanga_reprint_pkgs').text(response.tanga.reprint_pkgs);
        $('#tanga_reprint_kgs').text(response.tanga.reprint_kgs);
        $('#tanga_fresh_reprint_pkgs').text(response.tanga.total_fresh_reprint_pkgs);
        $('#tanga_fresh_reprint_kgs').text(response.tanga.total_fresh_reprint_kgs);

        // Update data for West region
        $('#west_lots').text(response.west.lots);
        $('#west_fresh_pkgs').text(response.west.fresh_pkgs);
        $('#west_fresh_kgs').text(response.west.fresh_kgs);
        $('#west_reprint_pkgs').text(response.west.reprint_pkgs);
        $('#west_reprint_kgs').text(response.west.reprint_kgs);
        $('#west_fresh_reprint_pkgs').text(response.west.total_fresh_reprint_pkgs);
        $('#west_fresh_reprint_kgs').text(response.west.total_fresh_reprint_kgs);

        // Update total values
        $('#total_lots').text(response.south.lots + response.tanga.lots + response.west.lots);
        $('#total_fresh_pkgs').text(response.total_fresh_pkgs);
        $('#total_fresh_kgs').text(response.total_fresh_kgs);
        $('#total_reprint_pkgs').text(response.total_reprint_pkgs);
        $('#total_reprint_kgs').text(response.total_reprint_kgs);
        $('#total_fresh_reprint_pkgs').text(response.total_fresh_reprint_pkgs);
        $('#total_fresh_reprint_kgs').text(response.total_fresh_reprint_kgs);
        $('#total_lots').text(response.total_lots);
    }

    // Function to clear the displayed data
    function clearAuctionData() {
        $('#auctionNoValue1').text('');
        $('#auctionDateValue1').text('');
        $('#prompt-date').text('');

        $('#south_lots').text('');
        $('#south_fresh_pkgs').text('');
        $('#south_fresh_kgs').text('');
        $('#south_reprint_pkgs').text('');
        $('#south_reprint_kgs').text('');
        $('#south_fresh_reprint_pkgs').text('');
        $('#south_fresh_reprint_kgs').text('');

        $('#tanga_lots').text('');
        $('#tanga_fresh_pkgs').text('');
        $('#tanga_fresh_kgs').text('');
        $('#tanga_reprint_pkgs').text('');
        $('#tanga_reprint_kgs').text('');
        $('#tanga_fresh_reprint_pkgs').text('');
        $('#tanga_fresh_reprint_kgs').text('');

        $('#west_lots').text('');
        $('#west_fresh_pkgs').text('');
        $('#west_fresh_kgs').text('');
        $('#west_reprint_pkgs').text('');
        $('#west_reprint_kgs').text('');
        $('#west_fresh_reprint_pkgs').text('');
        $('#west_fresh_reprint_kgs').text('');

        $('#total_lots').text('');
        $('#total_fresh_pkgs').text('');
        $('#total_fresh_kgs').text('');
        $('#total_reprint_pkgs').text('');
        $('#total_reprint_kgs').text('');
        $('#total_fresh_reprint_pkgs').text('');
        $('#total_fresh_reprint_kgs').text('');
    }
});

    </script>
</body>
</html>
