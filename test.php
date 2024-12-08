<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contract & Invoice</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <!-- Add Font Awesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
      body {
    font-family: Arial, sans-serif;
    margin: 10px;
    font-size: 11px;
}

.container {
    margin-top: 20px;
}

.container, #fetchTable, #invoiceForm {
    width: 100%;
    max-width: 1100px;
    margin: auto;
}

.header {
    position: relative;
    text-align: center;
    margin-bottom: 20px;
}

.header h1 {
    font-size: 24px;
    margin-top: 30px;
    position: relative;
    z-index: 1;
    color: green;
}

.header img.logo {
    position: absolute;
    top: 0;
    left: 90%;
    transform: translate(-90%, 0);
    z-index: 2;
    width: 40px;
    height: 30px;
}

.invoice-title {
    border: 2px solid #000;
    display: inline-block;
    text-decoration: underline;
    width: 100%;
    box-sizing: border-box;
    margin-top: 20px;
}

.details {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.details-left, .details-right {
    width: 48%;
}

.details-right {
    text-align: right;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f4f4f4;
}

.flex-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-top: 5px;
}

.payment-info {
    width: 48%;
    line-height: 1.8;
}

.summary {
    width: 48%;
    text-align: right;
}


.note {
    margin-top: 5px;
    margin-left: 35px;
}
.footer {
    text-align: center;
    margin-top: 5px;
    color: green;
}

.signature {
    margin-top: 40px;
    text-align: center;
}

.contact {
    font-size: 0.9rem;
}

.signature {
    margin-top: 20px;
    text-align: center;
    font-weight: bold;
}

.stamp {
    margin-top: 10px;
    max-width: 200px;
    height: auto;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

#fetchTable {
    display: none;
}

/* Scrollable sales results table */
#salesResultsTable4 {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #ddd;
}

#salesResultsTable4 thead th {
    position: sticky;
    top: 0;
    background-color: #f4f4f4;
    z-index: 1;
}

#salesResultsTable4 tbody {
    display: block;
    max-height: 300px;
    overflow-y: auto;
    width: 100%;
}

#salesResultsTable4 thead, #salesResultsTable4 tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
}

#selectedBuyerData {
    width: 100%;
    max-height: 300px; /* Set fixed height */
    overflow-y: auto; /* Enable vertical scrolling */
    overflow-x: auto; /* Enable horizontal scrolling if needed */
    border: 1px solid #ddd; /* Optional: Add a border for clarity */
}

#selectedBuyerData thead th {
    position: sticky;
    top: 0;
    background-color: #f4f4f4;
    z-index: 1;
}

#selectedBuyerData tbody {
    display: block;
    max-height: 260px; /* Adjust for header and footer space */
    overflow-y: scroll;
    width: 100%;
}

#selectedBuyerData thead, #selectedBuyerData tbody tr, #selectedBuyerData tfoot tr {
    display: table;
    width: 100%;
    table-layout: fixed;
}

#selectedBuyerData tfoot {
    display: table-footer-group; /* Ensure footer is correctly displayed */
    position: sticky;
    bottom: 0;
    background-color: #f9f9f9; /* Optional: Highlight the footer */
    z-index: 1;
    border-top: 2px solid #ddd; /* Optional: Add a top border for distinction */
}

  /* Form styling */
  #invoiceForm {
        display: flex;
        flex-direction: column;
        width: 30%; /* Form on left */
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
      }

      #invoiceForm label {
        margin-bottom: 5px;
        font-size: 14px;
        font-weight: bold;
      }

      #invoiceForm select, #invoiceForm button, #invoiceForm input  {
        padding: 10px;
        margin-bottom: 15px;
        font-size: 14px;
        border-radius: 5px;
        border: 1px solid #ddd;
      }

      /* Button styling */
      #invoiceForm button {
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }

      #invoiceForm button:hover {
        background-color: #45a049;
      }

      /* Animating button */
      #invoiceForm button:active {
        transform: scale(0.98);
      }

      #exportPdf, #cancel {
    padding: 10px 20px;
    font-size: 14px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 10px;
    position: relative;
}

#exportPdf {
    background-color: #4CAF50;
    color: white;
}

#exportPdf:hover {
    background-color: #45a049;
    transform: scale(1.05);
}

#exportPdf:active {
    transform: scale(0.95);
}

#cancel {
    background-color: red;
    color: white;
    position: absolute;
    top: 10px;
    right: 10px;
}

#cancel:hover {
    background-color: darkred;
    transform: scale(1.05);
}

#cancel:active {
    transform: scale(0.95);
}


@media print {
    body {
        margin-bottom: 5px !important; /* Apply the 5px margin during print */
    }

    /* Ensure no page breaks between table rows */
    table, tr {
        page-break-inside: avoid !important; /* Prevent breaking rows across pages */
    }

    /* Ensure divs break as a whole */
    #flex-container, #signaturePart {
        page-break-after: always; /* Ensure the entire div is on the same page */
        
    }
}

 /* Default icon styling */
 .fas.fa-edit {
        color: inherit;
        transition: color 0.3s ease, font-size 0.3s ease;
    }

    /* Hover effect for icon */
    .fas.fa-edit:hover {
        color: #007bff; /* Blue shade */
        font-size: 1.5em; /* Larger size */
    }


    </style>
</head>
<body>
<div class="form-container">
        <form id="invoiceForm">
            <label for="year4">The Year:</label>
            <select name="year" id="year4" required>
                <option value="">Select Year</option>
                <?php
                $connection = new mysqli('localhost', 'root', '', 'vtbl_db');
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                $query = "SELECT DISTINCT YEAR(auction_date) AS year FROM auction_dates ORDER BY year ASC";
                $result = $connection->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['year'] . "'>" . $row['year'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No years available</option>";
                }

                $connection->close();
                ?>
            </select>

            <label for="auction_no4">Auction No:</label>
            <select name="auction_no" id="auction_no4" required>
               
            </select>


            <label for="buyer">Buyer Name:</label>
<select name="buyer" id="buyer">
    <option value="">Select Buyer</option>
    <!-- The options will be dynamically populated here -->
</select>

<label for="Payee"> Payee Name:</label>
<div style="position: relative; display: inline-block;">
<select name="bank_name" id="bankName">
    <option value="">Select Payee Name</option>
    <option>VISION TEA BROKERS LTD </option>
    <option>TANZANIA MERCHANTILE EXCHANGE</option>
    <!-- The options will be dynamically populated here -->

</select>

<i class="fas fa-edit" id="editBankNameIcon" style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"></i>
</div>
        <label for="exchangeRateInput">Exchange Rate:</label>
        <input type="number" id="exchangeRateInput"  id="rate"  required placeholder="Enter exchange rate" />
        <button id="saveExchangeRateBtn" style="display:none;" >Save Rate</button>
 


            <button id="generate" type="button">Generate Invoice</button>
        </form>
    </div>


<div id="fetchTable">
<h2 style="color:green; text-align:center;">INVOICES SOLD IN AUCTION NO: <span id="auction4"></span></h2>
<table id="salesResultsTable4">
            <thead>
                <tr>
                    <th>Date Sold</th>
                    <th>Lot Number</th>
                    <th>Sell Mark</th>
                    <th>Invoice</th>
                    <th>Packages</th>
                    <th>Net Weight</th>
                    <th>Grade</th>
                    <th>Price</th>
                    <th>Proceeds</th>
                    <th>Buyer Name</th>
                    <th>Warehouse</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="salesResultsTable4tbody">
                <!-- Data will be dynamically loaded -->
            </tbody>
        </table>
        </div>
        <button id="exportPdf"  class=" no-print " type="button">Export To PDF</button>
       
<button class="cancel" id="cancel">&times;</button>
        <div class="container">
       
        <div class="header">
            <img src="Vision.logo1.png" alt="Logo" class="logo">
            <h1>VISION TEA BROKERS LIMITED</h1>
            <div class="invoice-title">
                <h2>CONTRACT & INVOICE</h2>
            </div>
        </div>

        <div class="details">
            <div class="details-left">
                <p><strong>Account with</strong></p>
                <p id="selectedbuyer"></p>
                <p id="buyerAdress"></p>
                <p id="pleceAdress"></p>
            </div>
            <div class="details-right">
            <p >
    <strong>Invoice No:</strong> 
    <span style="display: inline-block; letter-spacing: -0.1em; padding:5px;">
        <span id="buyerCode"></span><span id="auctionSaleNo"></span>
    </span>
</p>

                  <p><strong>Sale No:</strong> <span id="auctionNo4" style="display: inline-block; padding:5px;"></span></p>
                <p><strong>Sale Date:</strong> <span id="dateSold" style="display: inline-block; padding:5px;"></span></p>
                <p><strong>Prompt Date:</strong> <span id="promptDate4" style="display: inline-block; padding:5px;"></span></p>
            </div>
        </div>

        <p>We have this day sold to you the under mentioned teas:</p>

        <table id="selectedBuyerData">
            <thead>
                <tr>
                    <th>Mark</th>
                    <th>Invoice No</th>
                    <th>Pkgs</th>
                    <th>Grade</th>
                    <th>Net Kg</th>
                    <th>Price/Kg</th>
                    <th>Values $</th>
                </tr>
            </thead>
            <tbody id="selectedBuyerDatatbody">
                
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><strong>Total</strong></td>
                    <td><strong id="totalPacakages"></strong></td>
                    <td></td>
                    <td><strong id="totalNetWeight"></strong></td>
                    <td></td>
                    <td><strong id="TotalProceeds"></strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="flex-container">
    <div class="payment-info">
    <p><strong>Pay To:</strong> <span id="payTo" style="display: inline-block; padding:5px;"></span></p>
        <p><strong>Pay in:</strong> <span id="currencyType" style="display: inline-block; padding:5px;"></span></p>
        <p id="rate" style="display:none; padding:5px;">
            <strong>Ex Rate:</strong> <span id="ExchangeRate" style="display: inline-block; padding:5px;"></span>
        </p>
        <p><strong>Account Name:</strong> <span id="accountName" style="display: inline-block; padding:5px;"></span> </p>
        <p><strong>Account Number:</strong> <span id="accountNo" style="display: inline-block; padding:5px;"></span></p>
        <p><strong>Swift Code:</strong> <span id="branch" style="display: inline-block; padding:5px;"></span></p>
    </div>

    <div class="summary">
        <p id="TZS">
            <strong>Tea Value converted to TZS:</strong>
            <span id="proceedsInTz" style="display: inline-block; padding:5px;"></span>
        </p>
        <p><strong>Brokerage Fee (0.5%):</strong> <span id="brokerage" style="display: inline-block; padding:5px;"></span></p>
        <p><strong>Gross Amount:</strong> <span id="grossAmount" style="display: inline-block; padding:5px;"></span></p>
        <p><strong>WHTax (5%):</strong> <span id="withholdingTax" style="display: inline-block; padding:5px;"></span></p>
        <p><strong>Payable Amount:</strong> <span id="payableAmount" style="display: inline-block; padding:5px;"></span></p>
    </div>
</div>

<div id="signaturePart"></div>
        <div class="note">
            <p><strong>NOTE:</strong></p>
            <ol>
                <li>Withholding Tax is payable by the 20th of the following month.</li>
                <li>EFD Receipt will be issued by the Producer upon receipt of funds.</li>
            </ol>
        </div>

        <div class="signature">
            <p>Official Stamp & Signature</p>
            <img src="stamp.jpg" alt="Vision Tea Brokers Limited Stamp" class="stamp">
        </div>

        <div class="footer">
            <p>Head Office, IPS Building 10th Floor Samora Avenue/Azikiwe Street, P.O. Box 79359, Dar es Salaam, Tanzania.</p>
            <p>Telephone: +255 22 212 3240 | Fax: +255 22 211 0746 | Email: info@visionteabrokers.co.tz</p>
        </div>
    </div>
   
    <script>
        $(document).ready(function () {
// Fetch exchange rate and perform calculations for domestic buyers
function fetchExchangeRateAndCalculate(auctionNo) {
    $.ajax({
        url: 'exchange_rate.php',
        type: 'POST',
        data: { auction_no: auctionNo },
        dataType: 'json',
        success: function (response) {
            const exchangeRateInput = $("#exchangeRateInput");
            const saveButton = $("#saveExchangeRateBtn");

            // Clear exchange rate input and reset button visibility
            exchangeRateInput.val('');
            saveButton.hide();

            if (response.status === 'success' && response.exchange_rate !== null) {
                const exchangeRate = parseFloat(response.exchange_rate);

                if (!isNaN(exchangeRate) && exchangeRate > 0) {
                    exchangeRateInput.val(exchangeRate);
                    calculateForDomestic(exchangeRate); // Calculate using fetched exchange rate
                    chemistyAmmy();
                } else {
                    resetFinancials(); // Reset financial fields
                    saveButton.show(); // Show save button for invalid exchange rate
                }
            } else {
                resetFinancials(); // Reset financial fields
                console.error(response.message || 'Exchange rate not found.');
                saveButton.show(); // Show save button if no exchange rate is found
            }
        },
        error: function () {
            alert('Error fetching exchange rate.');
            resetFinancials(); // Reset financial fields
            $("#saveExchangeRateBtn").show(); // Show save button for request failure
        }
    });
}

// Reset financial fields to their initial state
function resetFinancials() {
    $("#ExchangeRate, #proceedsInTz, #brokerage, #grossAmount, #withholdingTax, #payableAmount").text('-');
}




    // Domestic calculation logic
    function calculateForDomestic(exchangeRate) {
        const totalProceeds = parseFloat($("#TotalProceeds").text()) || 0;
        const proceedsInTz = totalProceeds * exchangeRate;
        const brokerage = proceedsInTz * 0.005;
        const grossAmount = brokerage + proceedsInTz;
        const withholdingTax = brokerage * 0.05;
        const payableAmount = grossAmount - withholdingTax;

        // Update UI for domestic calculations
        $("#ExchangeRate").text(exchangeRate.toFixed(2));
        $("#proceedsInTz").text(proceedsInTz.toLocaleString());
        $("#brokerage").text(brokerage.toFixed(2));
        $("#grossAmount").text(grossAmount.toFixed(2));
        $("#withholdingTax").text(withholdingTax.toFixed(2));
        $("#payableAmount").text(payableAmount.toFixed(2));
    }

    // Export calculation logic
    function calculateForExport() {
        const totalProceeds = parseFloat($("#TotalProceeds").text()) || 0;
        const brokerage = totalProceeds * 0.005;
        const grossAmount = brokerage + totalProceeds;
        const withholdingTax = brokerage * 0.05;
        const payableAmount = grossAmount - withholdingTax;

        // Update UI for export calculations
        $("#brokerage").text(brokerage.toFixed(2));
        $("#grossAmount").text(grossAmount.toFixed(2));
        $("#withholdingTax").text(withholdingTax.toFixed(2));
        $("#payableAmount").text(payableAmount.toFixed(2));
        $("#currencyType").text("UNITED STATES DOLLAR (USD)");
        $("#rate").hide();
        $("#TZS").hide();
    }



    // Dropdown change handlers
    $("#auction_no4").on("change", function () {
        const auctionNo = $(this).val();
        fetchExchangeRateAndCalculate(auctionNo);
    });


    // Save exchange rate to the database
    $("#saveExchangeRateBtn").click(function () {
        const auctionNo = $("#auction_no4").val().trim(); // Get selected auction number (string)
        const exchangeRate = parseFloat($("#exchangeRateInput").val());

        if (!auctionNo || auctionNo.trim() === '') {
            alert("Please select a valid auction number.");
            return;
        }

        if (!isNaN(exchangeRate) && exchangeRate > 0) {
            $.ajax({
                url: 'exchange_rate.php',
                type: 'POST',
                data: {
                    auction_no: auctionNo,
                    exchange_rate: exchangeRate
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        $('#saveExchangeRateBtn').hide();
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert('Error saving exchange rate.');
                }
            });
        } else {
            alert("Please enter a valid exchange rate.");
        }
    });


   function chemistyAmmy(){
    const exchangeRateInput = $("#exchangeRateInput");
    const saveButton = $("#saveExchangeRateBtn");

    // Create Font Awesome edit icon
    const editIcon = $("<i>")
        .addClass("fas fa-edit")
        .css({
            "cursor": "pointer",
            "margin-left": "10px",
            "position": "absolute",
            "right": "10px",
            "top": "50%",
            "transform": "translateY(-50%)",
            "transition": "transform 0.3s ease",
        })
       

    // Initially make the exchange rate input readonly
    exchangeRateInput.prop("readonly", true).css("padding-right", "30px"); // Ensure space for the icon

    // Add the edit icon after the input field
    exchangeRateInput.wrap('<div style="position: relative; display: inline-block;"></div>').after(editIcon);

    // Click event for the edit icon
    editIcon.on("click", function () {
        const pin = prompt("Enter the PIN to edit the exchange rate:");

        // Replace "1234" with your actual PIN or implement secure logic
        if (pin === "1234") {
            alert("PIN verified. You can now edit the exchange rate.");
            exchangeRateInput.prop("readonly", false); // Allow editing
            saveButton.show(); // Show save button
        } else {
            alert("Incorrect PIN. Editing is not allowed.");
        }
    });

    // Hide the save button initially
    saveButton.hide();
   }




        // Function to fetch and populate prompt date
function fetchPromptDate(auctionNo) {
    // Always make an AJAX call to fetch the data
    $.ajax({
        url: 'fetch_coverpage1_data.php',
        type: 'POST',
        data: { auction_no: auctionNo },
        dataType: 'json',
        success: function(response) {
            console.log("Response from server:", response); // Debugging the response
            if (response && response.prompt_date) {
                // Populate the prompt date
                $('#promptDate4').text(response.prompt_date);
                $('#dateSold').text(response.auction_date);
              
            } else {
                // Handle case where prompt_date is not available
                $('#promptDate4').text('N/A');
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching data:", error);
            $('#promptDate4').text('Error');
        }
    });
}

    

      // Export to PDF functionality
      $('#exportPdf').on('click', function () {
                const { jsPDF } = window.jspdf; // Initialize jsPDF
                const pdf = new jsPDF('p', 'mm', 'a4'); // Portrait orientation

                const container = document.querySelector('.container');

                // Temporarily hide elements with "no-print" class
                $('.no-print').addClass('hidden');

                // Add HTML content directly to the PDF
                pdf.html(container, {
                    callback: function (doc) {
                        // Show elements again after PDF generation
                        $('.no-print').removeClass('hidden');

                        // Save the PDF
                        doc.save('container-content.pdf');
                    },
                    x: 10, // X offset
                    y: 10, // Y offset
                    width: 190, // Content width (A4 page width minus margins)
                    windowWidth: container.scrollWidth, // Use full container width
                });
            });


            $('#generate').hide(); 
            $('.container').hide(); 
            $('#exportPdf').hide(); 
            $('#cancel').hide(); 

            

            const bankNameDropdown = $("#bankName");
    const editIcon = $("#editBankNameIcon");

    // Initially, make the dropdown uneditable
    bankNameDropdown.prop("disabled", true);

    // Handle the change event of the #bankName dropdown
    bankNameDropdown.change(function () {
        const auctionNo = $("#auction_no4").val().trim();
        const bankName = $(this).val();

        if (!auctionNo) {
            alert("Please enter an auction number before selecting a bank name.");
            return;
        }

        // Save the selected bank name to the database
        $.ajax({
            url: "bank_name_handler.php",
            method: "POST",
            data: {
                request_type: "save",
                auction_no: auctionNo,
                bank_name: bankName,
            },
            success: function (response) {
                const data = JSON.parse(response);
                if (data.status === "success") {
                    alert("Bank name saved successfully.");
                    bankNameDropdown.prop("disabled", true); // Lock it again
                } else {
                    alert(data.message);
                }
            },
        });
    });

    // Fetch the bank name when the auction number changes
    $("#auction_no4").blur(function () {
        const auctionNo = $(this).val().trim();

        if (!auctionNo) {
            alert("Please enter an auction number.");
            return;
        }

        // Fetch the bank name from the database
        $.ajax({
            url: "bank_name_handler.php",
            method: "GET",
            data: {
                request_type: "fetch",
                auction_no: auctionNo,
            },
            success: function (response) {
                const data = JSON.parse(response);
                if (data.status === "success" && data.data.bank_name) {
                    const bankName = data.data.bank_name;
                    bankNameDropdown.val(bankName).prop("disabled", true); // Set value and lock
                } else {
                    bankNameDropdown.val("").prop("disabled", false); // Reset and unlock
                }
            },
        });
    });

    // Edit icon click handler
    editIcon.click(function () {
        if (bankNameDropdown.prop("disabled")) {
            const pin = prompt("Enter the PIN to edit the bank name:");
            if (pin === "Misheck") {
                alert("PIN has verified. You can now edit the bank name.");
                bankNameDropdown.prop("disabled", false); // Allow editing
            } else {
                alert(" Sorry, you are not authorized to edit exchange rate!");
            }
        }
    });

   

// Handle buyer and bank selection changes
$("#buyer, #auction_no4").change(function () {


    const selectedBuyer = $("#buyer").val();
    fetchAuctionDetails(selectedBuyer);
   

    $('.container').show(); 
    $('#generate').click(function(){
        $('#exportPdf').show(); 
        $('#cancel').show(); 
            $('#fetchTable, .form-container').hide(); // Hide the #fetchTable div
            $('.container').show(); 
            $('#selectedBuyerData tbody').css({
        'max-height': 'none',
        'overflow-y': 'visible',
        'display': 'table-row-group'
    });
        });


        $('#cancel').click(function(){
        $('#exportPdf').hide(); 
        $('#cancel').hide(); 
        $('#selectedBuyerData tbody').css({
        'max-height': '260',
        'overflow-y': 'scroll',
        'display': 'block'
    });
            $('#fetchTable, .form-container').show(); // Hide the #fetchTable div
            $('.container').show(); 
           
        });





    // Handle buyer and bank change
    $("#buyer, #bankName").change(function () {
      
        const buyer = $("#buyer").val().trim();
    const bankName = $("#bankName").val().trim();


    






    if (buyer && bankName) {
        $('#generate').show(); // Show the button only if both are selected
    } else {
        $('#generate').hide(); // Hide the button otherwise
    }

        const selectedBuyer = $("#buyer").val();
        
        const selectedBank = $("#bankName").val();

        const isExporter = ["Tea Export Agency Limited", "Tanzglobal Investments Co. Ltd"].includes(selectedBuyer);
        const isDomestic = selectedBuyer !== "" && !isExporter;

        // Handle Exporter logic
        if (isExporter) {
        
            if (selectedBank === "VISION TEA BROKERS LTD") {
                $("#payTo").text("VISION TEA BROKERS LTD");
                $("#accountName").text("MKOMBOZI COMMERCIAL BANK");
                $("#accountNo").text("00151618633001");
                $("#branch").text("MKCBTZTZXXX");
                
           
            } else if (selectedBank === "TANZANIA MERCHANTILE EXCHANGE") {
                $("#payTo").text("TANZANIA MERCHANTILE EXCHANGE");
                $("#accountName").text("STANBIC BANK TANZANIA LIMITED");
                $("#accountNo").text("9120003078475");
                $("#branch").text("SBICTZTX");
            } else {
                clearBankFields();
            }

            // Handle Exporter specific UI adjustments
            $("#currencyType").text("UNITED SATATES DOLLAR (USD)");
            $("#rate").hide();
            $("#TZS").hide();
            $("#exchangeRateInput").off("input");
        } else if (isDomestic) {
          
            if (selectedBank === "VISION TEA BROKERS LTD") {
                $("#payTo").text("VISION TEA BROKERS LTD");
                $("#accountName").text("MKOMBOZI BANK");
                $("#accountNo").text("00110618633001");
                $("#branch").text("MKCBTZTZXXX");
            } else if (selectedBank === "TANZANIA MERCHANTILE EXCHANGE") {
                $("#payTo").text("TANZANIA MERCHANTILE EXCHANGE");
                $("#accountName").text("CRDB BANK");
                $("#accountNo").text("0150259178501");
                $("#branch").text("CORUTZTZ");
            } else {
                clearBankFields();
            }

            // Handle Domestic specific UI adjustments
            $("#currencyType").text("TANZANIA SHILLINGS (TZS)");
            $("#rate").show();
            $("#TZS").show();
            addExchangeRateInput();
        } else {
          
            clearBankFields();
        }

     
    });
   
});

// Clears the bank-related fields
function clearBankFields() {
    $("#payTo, #accountName, #accountNo, #branch").text("");
}

   


// Fetch selected auction details for the buyer
function fetchAuctionDetails(selectedBuyer) {
    var selectedRow = $("#salesResultsTable4 tbody tr").filter(function () {
        return $(this).find("td").eq(9).text().trim() === selectedBuyer;
    }).first();

    if (selectedRow.length > 0) {
      
      
        const auctionNo = $("#auction_no4").val().replace(/-\d+$/, "");
        const auctionNo4 = $("#auction_no4").val().replace(/-/g, "/");


// Display auction detail
$("#auctionNo4").text(auctionNo);
$("#auctionSaleNo").text(auctionNo4);

       
       

         // Mapping for buyer details
    var buyerDetails = {
        "Chai Bora Ltd": {
            buyerAdress: "P.O.Box 228",
            placeAdress: "Iringa, Tanzania",
            buyerCode: "CBL"
        },
        "Afri Tea Coffee Blenders Ltd": {
            buyerAdress: "P.O.Box 747",
            placeAdress: "Dar es Salaam, Tanzania",
            buyerCode: "ATCBL"
        },
        "AK Confectionery Co. Ltd": {
            buyerAdress: "P.O.Box 668",
            placeAdress: "Iringa, Tanzania",
            buyerCode: "ACCL"
        },
        "LULU Tea Solutions Ltd": {
            buyerAdress: "P.O.Box 1245",
            placeAdress: "Dar es Salaam, Tanzania",
            buyerCode: "LTSL"
        },
        "SHF Holdings and Farm Ltd": {
            buyerAdress: "P.O.Box 747",
            placeAdress: "Dar es Salaam, Tanzania",
            buyerCode: "SHFL"
        },
        "Tea Export Agency Limited": {
            buyerAdress: "P.O.Box 000",
            placeAdress: "Dar es Salaam, Tanzania",
            buyerCode: "TEAL"
        },
        "Tanzglobal Investments Co. Ltd": {
            buyerAdress: "P.O.Box 000",
            placeAdress: "Dar es Salaam, Tanzania",
            buyerCode: "TICL"
        },
        "Alifaa Food Packers Limited": {
            buyerAdress: "P.O.Box 000",
            placeAdress: "Dar es Salaam, Tanzania",
            buyerCode: "AFPL"
        }
    };


   
    $("#selectedbuyer").text(selectedBuyer.toUpperCase());
     // Display buyer address, place address, and buyer code
     if (buyerDetails[selectedBuyer]) {
      
            $("#buyerAdress").text(buyerDetails[selectedBuyer].buyerAdress);
            $("#pleceAdress").text(buyerDetails[selectedBuyer].placeAdress);
            $("#buyerCode").text(buyerDetails[selectedBuyer].buyerCode);
        } else {
            $("#buyerAdress").text("N/A");
            $("#pleceAdress").text("N/A");
            $("#buyerCode").text("N/A");
        }

        // Update totals for selected buyer
        updateSelectedBuyerData(selectedBuyer);
    } else {
        $('.container').hide(); 
        $('#generate').hide();
      
        resetBuyerDataFields();
    }
}





 // Update selected buyer data table and totals
 function updateSelectedBuyerData(selectedBuyer) {
        $("#selectedBuyerData tbody").empty();

        let totalPackages = 0;
        let totalNetWeight = 0;
        let totalProceeds = 0;

        $("#salesResultsTable4 tbody tr").each(function () {
            const rowBuyer = $(this).find("td").eq(9).text().trim();
            if (rowBuyer === selectedBuyer) {
                const sellMark = $(this).find("td").eq(2).text().trim();
                const invoice = $(this).find("td").eq(3).text().trim();
                const packages = parseInt($(this).find("td").eq(4).text().trim()) || 0;
                const grade = $(this).find("td").eq(6).text().trim();
                const netWeight = parseFloat($(this).find("td").eq(5).text().trim()) || 0;
                const price = parseFloat($(this).find("td").eq(7).text().trim()) || 0;
                const proceeds = parseFloat($(this).find("td").eq(8).text().trim()) || 0;

                // Append the row data to the table
                $("#selectedBuyerData tbody").append(`
                    <tr>
                        <td>${sellMark}</td>
                        <td>${invoice}</td>
                        <td>${packages}</td>
                        <td>${grade}</td>
                        <td>${netWeight.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        <td>${(price / 100).toFixed(2)}</td>
                        <td>${proceeds.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                    </tr>
                `);

                totalPackages += packages;
                totalNetWeight += netWeight;
                totalProceeds += proceeds;
           
            }
        });

        // Update totals
        $("#totalPacakages").text(totalPackages);
        $("#totalNetWeight").text(totalNetWeight.toFixed(0));
        $("#TotalProceeds").text(totalProceeds.toFixed(2));
      
       
    
    }

  
    // Handle buyer selection
    $("#buyer").change(function () {
        const selectedBuyer = $(this).val();
        if (selectedBuyer) {
            updateSelectedBuyerData(selectedBuyer);
           
        } else {
            resetBuyerDataFields();
        }
        const buyer = $(this).val();
        if (buyer === "Tea Export Agency Limited" || buyer === "Tanzglobal Investments Co. Ltd") {
            calculateForExport();
            updateSelectedBuyerData(selectedBuyer);
            
        } else {
            const exchangeRate = parseFloat($("#exchangeRateInput").val()) || 0;
            if (exchangeRate > 0) {
                calculateForDomestic(exchangeRate);
                updateSelectedBuyerData(selectedBuyer);
            }
        }
    });





// Reset selected buyer fields
function resetBuyerDataFields() {
    $("#totalPacakages, #totalNetWeight, #TotalProceeds, #proceedsInTz, #brokerage, #grossAmount, #withholdingTax, #payableAmount").text("");
    localStorage.removeItem('selectedBuyerData'); // Clear localStorage when resetting
}



    // Year and Auction Number Change Handling
    $("#year4").change(function () {
        var selectedYear4 = $(this).val();

        if (selectedYear4 !== "") {
            // Fetch auction numbers based on the selected year
            fetchAuctionNumbers(selectedYear4);
        } else {
            // Reset the auction_no dropdown if no year is selected
            $("#auction_no4").html("<option value=''>Select Auction No</option>");
        }
    });

    // Auction number change handling
    $("#auction_no4").change(function () {
        var selectedAuctionNo = $(this).val();

        if (selectedAuctionNo !== "") {
            const auction4 = selectedAuctionNo.replace(/-\d+$/, "");
            $('#fetchTable').show();

            // Fetch sales results based on the selected auction number
            $.ajax({
                url: "fetch_sold_results.php",
                type: "GET",
                data: { auction_no: selectedAuctionNo },
                success: function (data) {
                    // Populate the sales results table with the fetched data
                    $('.container').hide();
                    $("#auction4").text(auction4);
                    $("#salesResultsTable4 tbody").html(data);

                    // Fetch the buyer names dynamically and populate the dropdown
                    populateBuyerDropdown(data);
                },
                error: function () {
                    alert("Failed to fetch sales results.");
                }
            });

            // Fetch the prompt date for the selected auction number
            fetchPromptDate(selectedAuctionNo);
        }
    });

    // Function to fetch auction numbers based on selected year
    function fetchAuctionNumbers(year) {
        $.ajax({
            url: "fetch_auction_numbers4.php",
            type: "GET",
            data: { year: year },
            success: function (data) {
                $("#auction_no4").html(data); // Populate the dropdown with auction numbers
            },
            error: function () {
                alert("Failed to fetch auction numbers.");
            }
        });
    }

  

    function populateBuyerDropdown(data) {
        var buyers = [];
        // Extract buyer names from the data returned (assuming it's HTML output)
        $('#salesResultsTable4 tbody tr').each(function () {
            var buyerName = $(this).find('td').eq(9).text(); // 'buyer_name' is in the 10th column (index 9)
            if (buyerName && $.inArray(buyerName, buyers) === -1) {
                buyers.push(buyerName);
            }
        });

        // Clear existing dropdown options
        $('#buyer').empty();
        $('#buyer').append('<option value="">Select Buyer</option>');

        // Add buyer names to dropdown
        $.each(buyers, function (index, buyer) {
            $('#buyer').append('<option value="' + buyer + '">' + buyer + '</option>');
        });
    }

    

           
});


    </script>

    
</body>


</html>

