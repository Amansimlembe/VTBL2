<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Display Sales Results</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: auto;
            background-color: #f8f9fa;
        }

        h2 {
            color: green;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bolder;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        label {
            font-weight: bold;
            flex: 100%;
            font-size: 14px;
        }

        select, input[type="file"], button {
            padding: 8px;
            font-size: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            max-width: 200px;
        }

        #upload1 {
            cursor: pointer;
            background-color: #007BFF;
            color: #fff;
            border: none;
            transition: background 0.3s;
        }

        #salesResultsHeader {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
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
            font-size: 30px;
        }

        #salesResultsTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        #company {
    position: absolute;
    top: 150px; /* Adjust this value as needed */
    right: 65%; /* Adjust this value as needed */
    width: 200px; /* Optional: to ensure a consistent width */
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
}

        
    </style>
</head>
<body>
    <div class="container">
        <h2> Sales Results for Auction No <span id="auction"></span></h2>

        <form id="uploadForm" enctype="multipart/form-data" action="upload.php">
            <label for="year">Select Year:</label>
            <select name="year" id="year" required>
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

            <label for="auction_no">Select Auction No:</label>
            <select name="auction_no" id="auction_no" required>
                <option value="">Select Auction No</option>
            </select>

            <label for="file">Upload Excel File:</label>
            <input type="file" name="file" id="file" accept=".xlsx, .xls" required>
            <button id="upload1" type="submit">Upload</button>


            <select name="company" id="company" required>
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
                    <th>Buyer Name</th>
                    <th>Warehouse</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be dynamically loaded -->
            </tbody>
        </table>
    </div>

    <script>
      $(document).ready(function () {
    // Fetch auction numbers based on the selected year
    $("#year").change(function () {
        var selectedYear = $(this).val();
        if (selectedYear !== "") {
            $.ajax({
                url: "fetch_auction_numbers.php",
                type: "GET",
                data: { year: selectedYear },
                success: function (data) {
                    // Populate auction numbers
                    $("#auction_no").html(data);
                    // Automatically select the first auction number, if available
                    var firstAuctionNo = $("#auction_no option:first").val();
                    if (firstAuctionNo) {
                        $("#auction_no").val(firstAuctionNo).trigger("change");
                    }
                },
                error: function () {
                    alert("Failed to fetch auction numbers.");
                }
            });
        } else {
            $("#auction_no").html("<option value=''>Select Auction</option>");
        }
    });

    // Handle file upload
    $("#uploadForm").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "upload.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert(response); // Notify the user of upload success

                // Refetch sales results for the current auction
                var auctionNo = $("#auction_no").val();
                if (auctionNo !== "") {
                    fetchSalesResults(auctionNo);
                }
            },
            error: function () {
                alert("Failed to upload file.");
            }
        });
    });

    // Fetch and display sales results based on auction number
    $("#auction_no").change(function () {
        var auctionNo = $(this).val();
        if (auctionNo !== "") {
            fetchSalesResults(auctionNo);
        }
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
        filterRowsByMarks(marks);
    });

    // Filter rows in the table based on marks
    function filterRowsByMarks(marks) {
        $("#salesResultsTable tbody tr").each(function () {
            const rowMark = $(this).find("td:nth-child(3)").text(); // Assuming the 3rd column is 'Sell Mark'
            if (marks.includes(rowMark)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // Reusable function to fetch sales results for auction and reset filtering
    function fetchSalesResults(auctionNo) {
        $.ajax({
            url: "fetch_sales_results.php",
            type: "POST",
            data: { auction_no: auctionNo },
            success: function (data) {
                $("#salesResultsTable tbody").html(data);
                $("#company").val(""); // Reset company filter
            },
            error: function () {
                alert("Failed to fetch data.");
            }
        });
    }

    // Handle auction selection
    $("#auction_no").change(function () {
        const auctionNo = $(this).val();
        if (auctionNo !== "") {
            fetchSalesResults(auctionNo);
        }
    });
});


    </script>
</body>
</html>
