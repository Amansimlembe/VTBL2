<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Display Sales Results</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    <style>
      body {
    font-family: Arial, sans-serif;
    margin: 20px;
    padding: 10px;
}

.container {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

#uploadForm2 {
    width: 40%; /* Reduced width */
    padding: 10px; /* Reduced padding */
    box-sizing: border-box;
}

#uploadForm2 label {
    display: block;
    margin-bottom: 3px; /* Reduced margin */
    font-weight: bold;
    font-size: 14px;
}

#uploadForm2 input,
#uploadForm2 select,
#uploadForm2 button {
    width: 100%;
    margin-bottom: 10px; /* Reduced margin */
    padding: 8px; /* Reduced padding */
    font-size: 14px; /* Reduced font size */
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

#uploadForm2 button {
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
}

#uploadForm2 button:hover {
    background-color: #0056b3;
}

.summary {
    width: 45%; /* Reduced width */
    padding: 10px; /* Reduced padding */
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f9f9f9;
    box-sizing: border-box;
    overflow: hidden; /* Prevent scrolling */
}

.summary h2 {
    margin-bottom: 2px; /* Reduced margin */
    font-size: 18px;
}

.summary-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px; /* Reduced gap */
}

.summary-item {
    width: 48%;
}

.summary-item label {
    display: block;
    margin-bottom: 3px; /* Reduced margin */
    font-weight: bold;
    font-size: 14px;
}

.summary-item input {
    width: 100%;
    padding: 6px; /* Reduced padding */
    font-size: 14px; /* Reduced font size */
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    background-color: #f3f3f3;
}

.summary-item input[readonly] {
    background-color: #e9ecef;
}

#salesResultsHeader {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

#salesResultsTable {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    table-layout: fixed; /* Ensures columns have fixed widths */
}

#salesResultsTable th,
#salesResultsTable td {
    padding: 8px;
    text-align: left;
    border: 1px solid #ddd;
    overflow: hidden; /* Prevent content from overflowing */
    text-overflow: ellipsis; /* Truncate overflowing content */
    white-space: nowrap; /* Prevent wrapping */
}

#salesResultsTable th {
    background-color: #f4f4f4;
    position: sticky;
    top: 0; /* Fix the header row */
    z-index: 1;
    width: 10%; /* Example width, adjust as needed */
}

#salesResultsTable tbody {
    display: block;
    max-height: 400px; /* Set the height of the scrollable area */
    overflow-y: auto; /* Make tbody scrollable */
    width: 100%;
}

#salesResultsTable thead,
#salesResultsTable tbody tr {
    display: table;
    width: 100%; /* Ensure alignment with the table */
    table-layout: fixed; /* Fixed layout for all rows */
}


.clear-button {
    cursor: pointer;
    font-size: 20px;
    color: #ff0000;
    background: none;
    border: none;
    text-align: right;
}

.clear-button:hover {
    color: #d9534f;
    font-size: 22px;
}

#export {
    background-color: #28a745;  /* Green background color */
    color: white;               /* White text color */
    font-weight: bold;          /* Make the text bold */
    padding: 12px 24px;         /* Add padding for better size */
    font-size: 16px;            /* Adjust font size */
    text-align: center;         /* Center the text */
    border-radius: 5px;         /* Rounded corners */
    cursor: pointer;           /* Pointer cursor on hover */
    transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transition for hover effects */
    display: inline-block;
    margin-top: 10px;
}

#export:hover {
    background-color: #218838;  /* Darker green when hovered */
    transform: scale(1.1);       /* Slightly enlarge the button on hover */
}


#export {
    font-size: 16px;
    padding: 12px 24px;
    background-color: #007bff;  /* Blue background */
    color: white;
    text-align: center;
    cursor: pointer;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s ease, transform 0.3s ease;
}




       

    </style>
</head>
<body>
<div class="container">
        <form id="uploadForm2" enctype="multipart/form-data" action="upload.php">
            <h2 style="color:green;">SALES RESULTS FOR AUCTION NO: <span id="auction"></span></h2>
            <label for="year">Select Year:</label>
            <select name="year" id="year1" required>
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

<label for="auction_no3">Select Auction No:</label>
<select name="auction_no3" id="auction_no3" required>
    <option value="">Select Auction No</option>
</select>

<label for="file">Upload Excel File:</label>
<input type="file" name="file" id="file" accept=".xlsx, .xls" required>

<button id="upload1" type="button">Upload</button>

<label for="company">Select Company:</label>
<select name="company" id="company">
    <option value="">Select Company</option>
    <option value="MeTL">MeTL</option>
    <option value="Lipton Teas and Infusions">Lipton Teas and Infusions</option>
    <option value="DL Group Ltd">DL Group Ltd</option>
    <option value="Wakulima Tea Company Ltd">Wakulima Tea Company Ltd</option>
    <option value="East Usambara Tea Company Ltd">East Usambara Tea Company Ltd</option>
    <option value="Mponde Holding Company Ltd">Mponde Holding Company Ltd</option>
    <option value="Kagera Tea Company Ltd">Kagera Tea Company Ltd</option>
    <option value="Kisigo Tea Company Ltd">Kisigo Tea Company Ltd</option>
    <option value="Lupembe Tea Company Ltd">Lupembe Tea Company Ltd</option>
</select>
</form>

<div class="summary" id="saleSummary">
<h2>SALE SUMMARY FOR <span style="display:none; color:blue;" id="namebtn"> AUCTION NO:</span>
    <span id="auctionNo" style="color:blue;"></span> 
    <span style="color:blue;" id="companName"></span>
</h2>
<div class="summary-container">
    <div class="summary-item">
        <label for="kilos_offered">Kilos Offered:</label>
        <input type="text" id="kilos_offered" readonly>
    </div>
    <div class="summary-item">
        <label for="kilos_sold">Kilos Sold:</label>
        <input type="text" id="kilos_sold" readonly>
    </div>
    <div class="summary-item">
        <label for="pkgs_offered">Pkgs Offered:</label>
        <input type="text" id="pkgs_offered" readonly>
    </div>
    <div class="summary-item">
        <label for="pkgs_sold">Pkgs Sold:</label>
        <input type="text" id="pkgs_sold" readonly>
    </div>
    <div class="summary-item">
        <label for="total_proceeds">Total Proceeds:</label>
        <input type="text" id="total_proceeds" readonly>
    </div>
    <div class="summary-item">
        <label for="percent_sold">% Sold:</label>
        <input type="text" id="percent_sold" readonly>
    </div>
    <div class="summary-item">
        <label for="avg_price">Average Price:</label>
        <input type="text" id="avg_price" readonly>
    </div>
</div>
</div>
</div>

        <div id="salesResultsHeader">
            <h2>Sales Results</h2>
            <button class="clear-button" id="clearTable">&times;</button>
        </div>

        <table id="salesResultsTable">
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
            <tbody>
                <!-- Data will be dynamically loaded -->
            </tbody>
        </table>
   <div id="export" style="margin: 20px 5px;">Export to Excel</div>
 

    <script>
      $(document).ready(function () {
       
        $('#export').click(function () { 
    // Check if there are any rows in the table
    var tableRows = document.querySelectorAll('#salesResultsTable tbody tr');
    var tableHasData = tableRows.length > 0;

       // Check if the table is empty
    var tablem = document.querySelector("#salesResultsTable tbody").innerHTML.trim() === 
                 '<tr><td colspan="11" style="text-align: center;">No sales results found for this auction.</td></tr>';
    // Check if the sales summary inputs have valid data
    var salesSummaryInputs = [
        $('#kilos_offered').val(),
        $('#kilos_sold').val(),
        $('#pkgs_offered').val(),
        $('#pkgs_sold').val(),
        $('#total_proceeds').val(),
        $('#percent_sold').val(),
        $('#avg_price').val()
    ];
    var salesSummaryHasData = salesSummaryInputs.every(function (value) {
        return value && value.trim() !== ""; // Ensure all fields are non-empty
    });

   // Validate both conditions
    if (tablem || !tableHasData) {
        alert('No table data available to export.');
        return; // Stop further execution
    }

    if (!salesSummaryHasData) {
        alert('Sales summary data is incomplete. Please fill in all required fields.');
        return; // Stop further execution
    }

   // Get and clean the auction number
var auctionNoFull = $('#auction').text().trim(); // Get the full auction number text
var auctionNo = auctionNoFull.includes('-') 
    ? auctionNoFull.split('-')[0].trim() // Extract the part before the dash if present
    : auctionNoFull.trim(); // Use the full text if there's no dash

var companyName = $('#companName').text().trim().toUpperCase(); // Get the company name
var isCompanySelected = companyName.length > 0; // Check if a company is selected

let filename;
if (isCompanySelected) {
    filename = `${companyName} SALE ${auctionNo} COMFIRMATION.xlsx`; // Use company name if available
} else {
    filename = `SALE NO: ${auctionNo} COMFIRMATION.xlsx`; // Use default format
}

    
    // Set the sheet name dynamically
    var sheetName = `Sale ${auctionNo} Results`;

    // Proceed with data export if both conditions are met
    $('#saleSummary').show(); // Make sure the sale summary is visible.

    // Align the summary input fields with the table width
    var tableColumns = $('#salesResultsTable th');
    $('#saleSummary .summary-item').each(function (index) {
        var colWidth = $(tableColumns[index]).width();
        $(this).find('input').css('width', colWidth); // Match width of inputs to table columns
    });

    // Prepare workbook and sheet
    var wb = XLSX.utils.book_new();
    var ws = XLSX.utils.aoa_to_sheet([
        [`VISION TEA BROKERS LTD`], // Title at A1
        [`SALE CONFIRMATION FOR AUCTION SALE NO: ${auctionNo}`] // Title at A2
    ]);

  // Merge and center cells A1:L1 and A2:L2
if (!ws['!merges']) ws['!merges'] = [];
ws['!merges'].push(
    { s: { r: 0, c: 0 }, e: { r: 0, c: 11 } }, // Merge A1:L1
    { s: { r: 1, c: 0 }, e: { r: 1, c: 11 } }  // Merge A2:L2
);

// Apply styles for centering both vertically and horizontally
var centerStyle = {
    alignment: {
        vertical: "center",   // Vertical alignment
        horizontal: "center" // Horizontal alignment
    }
};

// Apply styles to the merged cells
ws['A1'].s = centerStyle;
ws['A2'].s = centerStyle;

// Add borders to A2 for the horizontal line
ws['A2'].s = {
    border: { top: { style: "thin" } },
    alignment: centerStyle.alignment
};
    // Export table data
    XLSX.utils.sheet_add_dom(ws, document.getElementById('salesResultsTable'), { origin: "A3" });

    // Add the sheet to the workbook
    XLSX.utils.book_append_sheet(wb, ws, sheetName);

    // Add a blank row after the last table row
    var range = wb.Sheets[sheetName]['!ref'];
    var lastRowExcel = XLSX.utils.decode_range(range).e.r; // Get the last row in the current sheet
    var columnCount = tableColumns.length; // Number of columns in the table

    // Create a truly blank row by adding empty cells for each column
    var blankRow = Array(columnCount).fill(""); // Create an array of empty strings for each column
    XLSX.utils.sheet_add_aoa(wb.Sheets[sheetName], [blankRow], { origin: { r: lastRowExcel + 1, c: 0 } });

 
  // Gather the "MARK" values from the table rows
var marksData = {}; 
tableRows.forEach(function(row) {
    var markName = row.querySelector('td:nth-child(3)').innerText.trim();
    var status = row.querySelector('td:nth-child(12)').innerText.trim();
    var netWeight = parseFloat(row.querySelector('td:nth-child(6)').innerText.trim()) || 0;
    var packages = parseInt(row.querySelector('td:nth-child(5)').innerText.trim()) || 0;
    var proceeds = parseFloat(row.querySelector('td:nth-child(9)').innerText.trim()) || 0;
    
    // Initialize the mark entry if it doesn't exist
    if (!marksData[markName]) {
        marksData[markName] = {
            kilosOffered: 0,
            kilosSold: 0,
            pkgsOffered: 0,
            pkgsSold: 0,
            totalProceeds: 0,
            soldKilos: 0
        };
    }

    // Update values per mark
    marksData[markName].kilosOffered += netWeight;
    marksData[markName].pkgsOffered += packages;

    // Update sold values only if the status is "Sold"
    if (status === 'Sold') {
        marksData[markName].kilosSold += netWeight;
        marksData[markName].pkgsSold += packages;
        marksData[markName].totalProceeds += proceeds;
    }
});

// Prepare summary data for export
var saleSummaryData = Object.keys(marksData).map(function(mark) {
    var markData = marksData[mark];
    
    // Calculate the percentage sold
    var percentSold = (markData.kilosOffered > 0) 
        ? (markData.kilosSold / markData.kilosOffered * 100).toFixed(2) 
        : 0;
    
    // Calculate the average price
    var avgPrice = (markData.kilosSold > 0) 
        ? (markData.totalProceeds / markData.kilosSold).toFixed(2) 
        : 0;

    return {
        "MARK": mark,
        "KILOS OFFERED": markData.kilosOffered,
        "KILOS SOLD": markData.kilosSold,
        "PKGS OFFERED": markData.pkgsOffered,
        "PKGS SOLD": markData.pkgsSold,
        "TOTAL PROCEEDS": markData.totalProceeds.toFixed(0),
        "% SOLD": percentSold,
        "AVERAGE PRICE": avgPrice
    };
});

// Calculate Grand Totals
var grandTotals = {
    "MARK": "GRAND TOTAL",
    "KILOS OFFERED": 0,
    "KILOS SOLD": 0,
    "PKGS OFFERED": 0,
    "PKGS SOLD": 0,
    "TOTAL PROCEEDS": 0,
    "% SOLD": 0, // We won't calculate percentage for the grand total
    "AVERAGE PRICE": 0 // We won't calculate average price for the grand total
};

// Sum up the totals for all marks
saleSummaryData.forEach(function(data) {
    grandTotals["KILOS OFFERED"] += parseFloat(data["KILOS OFFERED"]);
    grandTotals["KILOS SOLD"] += parseFloat(data["KILOS SOLD"]);
    grandTotals["PKGS OFFERED"] += data["PKGS OFFERED"];
    grandTotals["PKGS SOLD"] += data["PKGS SOLD"];
    grandTotals["TOTAL PROCEEDS"] += parseFloat(data["TOTAL PROCEEDS"]);
});

// Calculate the percentage sold and average price for the grand total
var totalKilosOffered = grandTotals["KILOS OFFERED"];
var totalKilosSold = grandTotals["KILOS SOLD"];
var totalProceeds = grandTotals["TOTAL PROCEEDS"].toFixed(0);

grandTotals["% SOLD"] = (totalKilosOffered > 0) 
    ? ((totalKilosSold / totalKilosOffered) * 100).toFixed(2) 
    : 0;

grandTotals["AVERAGE PRICE"] = (totalKilosSold > 0) 
    ? (totalProceeds / totalKilosSold).toFixed(2) 
    : 0;

// Add the Grand Total row to the summary data
saleSummaryData.push(grandTotals);

// Now `saleSummaryData` includes the summary for each "MARK" followed by the Grand Total row
console.log(saleSummaryData);




    // Add the sale summary data below the blank row
    XLSX.utils.sheet_add_json(wb.Sheets[sheetName], saleSummaryData, { origin: { r: lastRowExcel + 2, c: 0 } });

    // Auto-size column widths and center align
    var ws = wb.Sheets[sheetName];
    var colWidths = [];
    var range = XLSX.utils.decode_range(ws['!ref']);
    for (var C = range.s.c; C <= range.e.c; C++) {
        var maxWidth = 0;
        for (var R = range.s.r; R <= range.e.r; R++) {
            var cell = ws[XLSX.utils.encode_cell({ r: R, c: C })];
            if (cell && cell.v) {
                maxWidth = Math.max(maxWidth, cell.v.toString().length);
            }
        }
        colWidths[C] = maxWidth;
    }
    ws['!cols'] = colWidths.map(function (width) {
        return { wch: width };
    });

    // Write the file with the dynamic filename
    XLSX.writeFile(wb, filename);
});



$("#year1").change(function () {
    var selectedYear = $(this).val();

    if (selectedYear !== "") {
        // Fetch auction numbers based on the selected year
        $.ajax({
            url: "fetch_auction_numbers.php",
            type: "GET",
            data: { year: selectedYear },
            success: function (data) {
                // Populate auction numbers
                $("#auction_no3").html(data);

                // Automatically select the first auction number, if available
                var firstAuctionNo = $("#auction_no3 option:first").val();
                if (firstAuctionNo) {
                    $("#auction_no3").val(firstAuctionNo).trigger("change");
                }
            },
            error: function () {
                alert("Failed to fetch auction numbers.");
            }
        });
    } else {
        // Clear and hide elements if the year is deselected
        $("#namebtn").hide(); // Hide the "AUCTION NO:" label
        $("#auction").text(""); // Clear auction number display
         $("#auctionNo").text("");
        $("#companName").text("");
         $("#company").prop("selectedIndex", 0);// Reset dropdowns
        $("#auction_no3").html("<option value=''>Select Auction</option>"); // Reset auction number dropdown
        $("#salesResultsTable tbody").html(""); // Clear table content
        $("#saleSummary").find("input").val(""); // Clear input fields
    }
});

// Handle file upload with button click
$("#upload1").click(function () {
    var form = $("#uploadForm2")[0]; // Get the form element
    var formData = new FormData(form); // Create FormData from the form

    $.ajax({
        url: "upload.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            alert(response); // Notify the user of upload success

            // Refetch sales results for the current auction
            var auctionNo = $("#auction_no3").val();
            if (auctionNo !== "") {
                fetchSalesResults(auctionNo);
            }
        },
        error: function () {
            alert("Failed to upload file.");
        }
    });
});


   

    // Reusable function to fetch sales results
    function fetchSalesResults(auctionNo) {
        // Trim the auction number to only include the part before the dash
        var cleanAuctionNo = auctionNo.split('-')[0];
        $("#auction").text(cleanAuctionNo); // Update the auction number in the header

        $.ajax({
            url: "fetch_sales_results.php",
            type: "POST",
            data: { auction_no: auctionNo },
            success: function (data) {
                // Check if data is returned
                if (data.trim() === "") {
                    // If no data, display a message in the table with colspan for all columns
                    $("#salesResultsTable tbody").html('<tr><td colspan="11" style="text-align: center;">No sales results found for this auction.</td></tr>');
                } else {
                    // Otherwise, display the data
                    $("#salesResultsTable tbody").html(data);
                }
                sessionStorage.setItem("tableData", data); // Save data in session storage
                sessionStorage.setItem("auctionNo", auctionNo); // Store current auction number
            },
            error: function () {
                alert("Failed to fetch data.");
            }
        });
    }

    // Load table content from session storage when the page is loaded
    var tableData = sessionStorage.getItem("tableData");
    var auctionNo = sessionStorage.getItem("auctionNo");
    if (tableData && auctionNo) {
        $("#salesResultsTable tbody").html(tableData);
        // Extract and display the auction number before the dash if loaded from sessionStorage
        var cleanAuctionNo = auctionNo.split('-')[0];
        $("#auction").text(cleanAuctionNo); // Ensure the auction number is shown when data is loaded from sessionStorage
    }

    // Clear the table content
    $("#clearTable").click(function () {
        $("#salesResultsTable tbody").empty();
        sessionStorage.removeItem("tableData"); // Clear session storage
        sessionStorage.removeItem("auctionNo"); // Remove stored auction number
    });

 // Fetch and display sales results based on auction number
 $("#auction_no3").change(function () {
  
     // Get and clean the auction number
    var auctionNoFull = $(this).val();// Get the full auction number text
    var auctionNo = auctionNoFull.split('-')[0]; // Extract the part before the dash

       

        if (auctionNo !== "") {

            fetchSalesResults(auctionNo);
            $("#auctionNo").text(auctionNo); // Display selected auction_no
            $("#namebtn").show(); // Show "AUCTION NO:" label
        } else {
            $("#namebtn").hide(); // Hide "AUCTION NO:" label
            $("#auctionNo").text(""); // Clear auction_no display
        }
        $("#companName").text(""); // Reset company name display
        $("#company").val(""); // Reset company dropdown
        
    });


    const companyMarks = {
    'MeTL': ['Arc Mountain', 'Dindira', 'Chivanjee'],
    'Lipton Teas and Infusions': ['Lugoda', 'Kibwere', 'Kilima', 'Kabambe'],
    'DL Group Ltd': ['Itona', 'Kibena', 'Ikanga', 'Luponde', 'Livingstonia'],
    'Wakulima Tea Company Ltd': ['Katumba', 'Mwakaleli'],
    'East Usambara Tea Company Ltd': ['Kwamkoro', 'Bulwa'],
    'Mponde Holding Company Ltd': ['Mponde'],
    'Kagera Tea Company Ltd': ['Kagera'],
    'Kisigo Tea Company Ltd': ['Kiganga'],
    'Lupembe Tea Company Ltd': ['Lupembe']
};

// Handle company selection
$("#company").change(function () {
    const selectedCompany = $(this).val();
    const marks = companyMarks[selectedCompany] || [];
  
    const auctionNo = $("#auction_no3").val(); // Read auction_no from an input or dropdown field


  

    // Ensure auction_no is provided before making a request
    if (!auctionNo) {
        alert("Please select an auction number.");
        return;
    }

    filterRowsByMarks(marks);
    updateSalesSummary(auctionNo, marks);

   
        if (selectedCompany !== "" && auctionNo !== "") {
            $("#companName").text("" + selectedCompany); // Display selected company
            $("#namebtn").hide(); // Show "AUCTION NO:" label
        $("#auctionNo").text(""); // Clear auction_no display
        } else {
            $("#companName").text(""); // Clear company display if not selected
        }
});

// Filter rows in the table based on marks
function filterRowsByMarks(marks) {
    $("#salesResultsTable tbody tr").each(function () {
        const rowMark = $(this).find("td:nth-child(3)").text().trim(); // Assuming the 3rd column is 'Sell Mark'
        if (marks.includes(rowMark)) {
            $(this).show();
        } else {
                  $(this).hide();
        }
    });
}

// Update sales summary based on auction number and marks
function updateSalesSummary(auctionNo, marks) {
   

    $.ajax({
        url: "fetch_sales_summary.php", // Backend script to process the request
        type: "POST",
        data: { 
            auction_no: auctionNo, 
            marks: JSON.stringify(marks) // Send marks as JSON
        },
        success: function (response) {
            try {
                const data = JSON.parse(response);

                if (data.error) {
                    
                    alert(data.error);
                    return;
                }

                // Update sale summary fields
                $("#kilos_offered").val(data.kilosOffered || 0);
                $("#kilos_sold").val(data.kilosSold || 0);
                $("#pkgs_offered").val(data.pkgsOffered || 0);
                $("#pkgs_sold").val(data.pkgsSold || 0);
                $("#total_proceeds").val(data.totalProceeds || 0);
                $("#percent_sold").val(data.percentSold || 0);
                $("#avg_price").val(data.avgPrice || 0);

                // Update table rows
                $("#salesResultsTable tbody").html(data.tableRows);
            } catch (err) {
                alert("Failed to process the response. Please try again.");
            }
        },
        error: function () {
            alert("Failed to fetch sales summary.");
        }
    });
}

   
    // Reusable function to fetch sales results
    function fetchSalesResults(auctionNo) {
        // Trim the auction number to only include the part before the dash
        var cleanAuctionNo = auctionNo.split('-')[0];
        $("#auction").text(cleanAuctionNo); // Update the auction number in the header

        $.ajax({
            url: "fetch_sales_results.php",
            type: "POST",
            data: { auction_no: auctionNo },
            success: function (data) {
                // Parse the response JSON data
                var response = JSON.parse(data);

                // Check if data is returned
                if (response.tableRows.trim() === "") {
                    // If no data, display a message in the table with colspan for all columns
                    $("#salesResultsTable tbody").html('<tr><td colspan="11" style="text-align: center;">No sales results found for this auction.</td></tr>');
                } else {
                    // Otherwise, display the data
                    $("#salesResultsTable tbody").html(response.tableRows);
                }

                // Update the sale summary fields
                $("#kilos_offered").val(response.kilosOffered);
                $("#kilos_sold").val(response.kilosSold);
                $("#pkgs_offered").val(response.pkgsOffered);
                $("#pkgs_sold").val(response.pkgsSold);
                $("#total_proceeds").val(response.totalProceeds);
                $("#percent_sold").val(response.percentSold);
                $("#avg_price").val(response.avgPrice);
            },
            error: function () {
                alert("Failed to fetch sales results.");
            }
        });
    }
    
    // Handle auction selection
    $("#auction_no3").change(function () {
        const auctionNo = $(this).val();
        if (auctionNo !== "") {
        
        fetchSalesResults(auctionNo);
           
        }
    });
});


    </script>
</body>
</html>