<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: space-between;
            margin: 20px;
        }

        form {
            width: 45%;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        form input,
        form select,
        form button {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        .summary {
            width: 45%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        .summary h2 {
            margin-bottom: 20px;
        }

        .summary-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 10px;
        }

        .summary-item {
            width: 48%; /* Ensure two items per row */
        }

        .summary-item label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .summary-item input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #f3f3f3;
        }

        .summary-item input[readonly] {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container">
        <form id="uploadForm" enctype="multipart/form-data" action="upload.php">
            <h2>Sales Results for Auction No <span id="auction"></span></h2>
            <label for="year">Select Year:</label>
            <select name="year" id="year" required>
                <option value="">Select Year</option>
                <!-- PHP code to populate options -->
            </select>

            <label for="auction_no">Select Auction No:</label>
            <select name="auction_no" id="auction_no" required>
                <option value="">Select Auction No</option>
            </select>

            <label for="file">Upload Excel File:</label>
            <input type="file" name="file" id="file" accept=".xlsx, .xls" required>

            <button id="upload1" type="submit">Upload</button>

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
</body>
</html>
