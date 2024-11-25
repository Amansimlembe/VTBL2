<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tea Catalogue Cover Page</title>
    <style>
    /* Ensure the entire body behaves as a flex container */
#cover1body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%; /* Ensures full height of viewport */
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    
   
}

/* Style the footer to stay at the bottom */
#footer-adress {
    text-align: center;
    background-color: transparent;
    margin-top: 60px; /* Add more space above the footer */
    margin-bottom: 5px; /* Add more space below the footer */
    padding: 12px; /* Optional: Add padding inside the footer */
}

/* Cover page styling */
.cover-page1 {
    margin: 0 auto;
    padding: 23px; /* Increase padding */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 30px; /* Add vertical spacing between child elements */
    border: none; 
}

/* Border styling for divs */
.bordered-div {
    border: 2px solid #000; /* Uniform border width */
    text-align: center;
    margin-bottom: 40px; /* Adjust spacing between bordered divs */
    padding: 10px; /* Increase padding inside the div */
    margin-top: 40px; /* Correct the margin syntax */
}

/* Logo styling */
.logo1 {
    display: flex;
    justify-content: center;
    align-items: center;
    color: green;
    font-weight: bolder;
}

.logo1 img {
    max-height: 40px;
   
}
 /* New style for logo in the top-right corner */
 .logo-right-corner {
            position: absolute;
            right: 65px;
            max-width: 90px;
            height: auto;
           
        }

/* Heading styling */
.cover-page1 h1, .cover-page1 h2 {
    margin: 5px 0;
}

.cover-page1 .h4-custom {
    margin: 3px 0;
}

/* Order of sale styling */
.order-of-sale {
    margin: 50px 50px; /* Add vertical spacing above and below the order of sale */
    text-align: center;

    border: none; /* Ensure no border is applied */
}

.order-of-sale .h1-custom {
    text-decoration: underline;
    text-decoration-thickness: 2px;
}

.contact-info {
    text-align: left;
}

/* Table styling */
#cover1table {
    width: 100%;
    margin-top: 30px; /* Add space above the table */
    margin-bottom: 30px; /* Add space below the table */
    border-collapse: collapse;

    border: none; /* Ensure no border is applied */
}

#cover1table th, #cover1table td {
    border: 2px solid #000; /* Unified border width for table cells */
    padding: 12px;
    text-align: center;
}

/* Horizontal rule styling */
hr {
    margin: 10px 0;
    font-weight: bold;
}

/* Prompt styling */
.prompt {
    border-top: 2px dashed black;
    border-bottom: 2px dashed black;
    font-weight: bold;
    text-align: center;
    margin-top: 30px; /* Add space above */
    margin-bottom: 30px; /* Add space below */
}

.prompt-date {
    font-weight: bold;
}

/* Bold row styling */
.bold-row {
    font-weight: bolder;
    background-color: green;
    color:white;
}

/* Responsive styling */
@media screen and (max-width: 768px) {
    #cover1table, .outertable {
        font-size: 12px;
    }

    #cover1table th, #cover1table td {
        padding: 3px;
    }

    .cover-page1 h1 {
        font-size: 1.2em;
    }

    .logo1 img {
        max-height: 30px;
    }

    .bordered-div h1 {
        font-size: 1.1em;
    }

    .order-of-sale .h1-custom {
        font-size: 1.2em;
    }

    .order-of-sale h5 {
        font-size: 0.7em;
    }
}

@media screen and (max-width: 480px) {
    .cover-page1 h1 {
        font-size: 1em;
    }

    .bordered-div h1 {
        font-size: 1em;
    }

    .order-of-sale .h1-custom {
        font-size: 1em;
    }

    #cover1table th, #cover1table td {
        padding: 2px;
    }

    .logo1 img {
        max-height: 25px;
    }

    .order-of-sale h5 {
        font-size: 0.8em;
    }
}

/* Logo row table styling */
.logorow tr {
    border: 2px solid #000; /* Ensure consistent border width */
    width: 100%;
    table-layout: fixed;
}

.logorow th {
    width: auto;
    padding: 10px;
}

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body id="cover1body">
    <section class="cover-page1">
        <table class="outertable">
            <tr class="logorow">
                <th  class="bordered-div logo1">
                    <h1>VISION TEA BROKERS LTD</h1>
                    <img src="Vision.logo1.png" class="logo-right-corner">
                </th>
            </tr>
            <tr>
                <th colspan="2" class="bordered-div">
                    <h1>AUCTION Sale No. <span id="auctionNoValue1"></span> of <span id="auctionDateValue1"></span></h1>
                    <h1>TANZANIA TEAS</h1>
                    <h1>FOR SALE BY ONLINE AUCTION</h1>
                    <h4 class="h4-custom">Subject to the DAR ES SALAAM TEA AUCTION RULES AND CONDITIONS of sale exhibited in the TMX Online Platform.</h4>
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
                    <h1 class="h1-custom">ORDER OF SALE</h1>
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

        <div style="margin-top:50px; margin-bottom:20px;" id="footer-adress">
            <h1 style="color: green;">REGISTERED ADDRESS</h1>
            <p>
                Head Office, IPS Building 5th & 10th Floor Samora Avenue/Azikiwe Street,<br>
                P.O. Box 8680, Dar es Salaam, Tanzania.<br>
                Tel: +255 22 2127537 Mobile: +255754276123, +255714968285<br>
                Email: info@visionteabrokers.co.tz<br>
                <a href="http://www.visionteabrokers.co.tz" target="_blank">www.visionteabrokers.co.tz</a>
            </p>
            <hr>
        </div>
    </section>
    <script>
        // JavaScript code remains the same as provided
           // JavaScript code remains the same
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

      // Function to remove the dash and the number following it from the auction_no
      function sanitizeAuctionNo(auctionNo) {
        // Check if there is a dash in the auction_no and remove it along with the part after the dash
        return auctionNo.includes('-') ? auctionNo.split('-')[0] : auctionNo;
    }
   // Update Auction Sale Info
   $('#auctionNoValue1, #auctionNoValue2').text(sanitizeAuctionNo(response.auction_no));
   $('#auctionDateValue1, #auctionDateValue2').text(response.auction_date);
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
