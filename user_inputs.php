



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction Data</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <!-- Include necessary libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script> <!-- Excel support -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script> <!-- PDF support -->
    <!-- Add FontAwesome CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- DataTables AutoFill CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/autoFill/2.5.0/css/autoFill.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- DataTables AutoFill JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/autoFill/2.5.0/js/dataTables.autoFill.min.js"></script>


    <style>
       #dataTable {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    #dataTable th, #dataTable td {
        border: 1px solid #ddd;
        text-align: left;
        padding: 8px;
        font-size: 12px;
        word-wrap: break-word;
    }

    #dataTable th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    #dataTable td input {
        width: 100%;
        padding: 5px;
        font-size: 12px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    #uploadForm, #dataTable form {
        max-width: 1200px;
        margin: 0 auto;
        overflow-x: auto;
    }

    .close-btn1 {
    position: fixed; /* Fixed position for sticky placement */
    top: 50px; /* Distance from the top of the viewport */
    right: 50px; /* Distance from the right of the viewport */
    padding: 10px 15px; /* Padding for a comfortable click area */
    font-size: 16px; /* Adjust font size */
    font-weight: bold; /* Emphasize the 'X' */
    color: #ffffff; /* White text color */
    background-color: #ff5252; /* Bright red background */
    border: none; /* Remove default border */
    border-radius: 50%; /* Make the button circular */
    cursor: pointer; /* Pointer cursor on hover */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow */
    transition: all 0.3s ease; /* Smooth transition for hover effects */
    z-index: 9999; /* Ensure it stays above other elements */
}

.close-btn1:hover {
    background-color: #ff1744; /* Darker red on hover */
    transform: scale(1.1); /* Slightly enlarge on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Deepen shadow on hover */
}

.close-btn1:active {
    transform: scale(0.9); /* Slightly shrink when clicked */
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2); /* Soften shadow when active */
}



    
/* Table Styling */
#dataTable1, #dataTable2 {
    width: 100%;
    table-layout: fixed; /* Prevents table from expanding beyond container */
    border-collapse: collapse;
    margin-top: 20px;
    border: 2px solid black; /* Static outer border */
    margin-bottom: 20px;
}




.thead th, .tbod td {
   
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis; /* Ellipsis for overflowed content */
    white-space: nowrap; /* Prevent wrapping */
}
.tbod td {
    padding: 7px;
    font-size: 0.7em;
    border: 1px solid #ccc; /* Inner cell borders */
}
.thead th {
    padding: 7.5px;
    border: 1px solid black;
    font-size: 0.85em;
    background-color: transparent;
    font-weight: bold;
}

/* Additional CSS styling */
body {
    font-family: Arial, Helvetica, sans-serif;
    
    padding: 15px;
    background-color: transparent;
}

#h1 , #h2  {
    color: #333;
}

#dataEntryForm {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.form-group {
    display: inline-block;
    margin: 10px 20px;
    vertical-align: top;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input,
.form-group select {
    width: 200px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
}


/* General Button Styling */
.saveButton, #editStartingLot, #saveStartingLot, button {
    padding: 12px 18px;
    background-color: #007bff;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s ease-in-out;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    display: inline-block;
}

/* Hover Animation */
button:hover {
    background-color: #0056b3;
    transform: translateY(-5px); /* Lift the button */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Add a deeper shadow */
}

/* Active Button Effect */
button:active {
    transform: translateY(2px); /* Slightly press down */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Reduce shadow */
}

/* Save Button Specific Styling */
#saveStartingLot {
    background-color: #28a745;
}
#saveStartingLot:hover {
    background-color: #218838;
}

/* Edit Button Specific Styling */
#editStartingLot {
    background-color: #ffc107;
}
#editStartingLot:hover {
    background-color: #e0a800;
}

/* Save Lots Button Specific Styling */
.saveButton {
    background-color: #17a2b8;
}
.saveButton:hover {
    background-color: #138496;
}

/* Animation for Fade-In Effect */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Apply Animation */
button {
    animation: fadeIn 1s ease-in-out;
}

/* Button Group Styling */
#startinglot button {
    margin-right: 10px; /* Add space between buttons */
}



.close:hover,
.close:focus {
    color: black;
    cursor: pointer;
}

/* Responsive Styling */
@media (max-width: 1200px) {
    body {
        margin: 15px;
        padding: 10px;
    }
    .thead th, .tbod td {
        padding: 5px;
        font-size: 0.9em;
    }
    .tbod td {
        padding: 5px;
        font-size: 0.7em;
    }
}

@media (max-width: 992px) {
    body {
        margin: 10px;
        padding: 10px;
    }
    .thead th, .tbod td {
        padding: 6px;
        font-size: 0.85em;
    }
    .tbod td {
        padding: 5px;
        font-size: 0.7em;
    }
}

@media (max-width: 768px) {
    .thead th, .tbod td {
        padding: 5px;
        font-size: 0.8em;
    }
}

@media (max-width: 576px) {
    body {
        margin: 5px;
        padding: 5px;
    }
    #dataTable1, #dataTable2, .thead th, .tbod td  {
        font-size: 0.7em;
        padding: 3px;
    }



    .form-group input, .form-group select {
        width: 100%; /* Make form fields full-width on smaller screens */
    }
    .form-group {
        margin: 5px 0;
        width: 100%;
    }
    #h1, #h2 {
        font-size: 1.25em;
    }
}






/* Basic Styling */
#defaultMessage {
  font-weight: bold;
  font-style: italic;
  color: #ffffff; /* White text for contrast */
  font-size: 22px; /* Slightly larger text for readability */
  text-align: center;
  margin: 20px auto;
  padding: 15px;
  background-color: green; /* Dark blue background for better contrast */
  border-radius: 10px;
  max-width: 80%;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15); /* Slight shadow for depth */
  display: none; /* Hidden initially */
}

/* Smooth animation for moving and fading */
@keyframes slideAndFade {
  0% {
    opacity: 0;
    transform: translateX(-10%);
  }
  50% {
    opacity: 1;
    transform: translateX(0);
  }
  100% {
    opacity: 0;
    transform: translateX(0%);
  }
}

.movingMessage {
  animation: slideAndFade 15s ease-in-out infinite; /* Slower speed (10s) */
}

/* Animation Styling for Message */
#defaultMessage.show {
  display: block;
  animation: slideAndFade 15s ease-in-out infinite;
}

/* Button Styling */
#proceed {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: darkgray; /* Initial background color */
    color: white; /* Text color */
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15); /* Slight shadow for depth */
    transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transition for hover */
    opacity: 0; /* Start as invisible */
    animation: fadeIn 2s ease-in-out forwards; /* Fade-in effect */
}

/* Animation for fade-in when page loads */
@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateY(10px); /* Start from below */
    }
    100% {
        opacity: 1;
        transform: translateY(0); /* Move to its original position */
    }
}

/* Hover effect for changing background and scaling */
#proceed:hover {
    background-color: green; /* Change to green on hover */
    transform: scale(1.1); /* Slightly enlarge the button on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Darker shadow on hover */
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease; /* Smooth transition */
}

/* Optional: animation for when it leaves */
@keyframes slideOut {
    0% {
        opacity: 1;
        transform: translateX(0);
    }
    100% {
        opacity: 0;
        transform: translateX(100%); /* Move out to the right */
    }
}

#proceed.fadeOut {
    animation: slideOut 2s ease-out forwards;
}




#backButton {
    display:none;
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #3b5998; /* Background color */
    color: #ffffff; /* Text color */
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15); /* Add a slight shadow */
    transition: background-color 0.3s ease; /* Smooth transition for hover */
    
}

#backButton:hover {
    background-color: black; /* Darker color on hover */
    cursor: pointer;
}

/* General styling for the icon cell */
.icon-cell {
    padding: 8px;
    text-align: center;
}

/* Styling for the delete and edit buttons */
.delete-btn, .edit-btn {
    padding: 4px;
    font-size: 1.5em;
    color: #333; /* Default color */
    transition: color 0.3s ease, transform 0.3s ease; /* Smooth color and transform transitions */
    cursor: pointer;
}

/* Hover effect for both delete and edit buttons */
.delete-btn:hover {
    color: red; /* Change color on hover */
    transform: scale(1.2); /* Slightly scale up on hover */
    animation: pulse 0.5s infinite; /* Pulse animation on hover */
}

.edit-btn:hover {
    color: #007bff; /* Change color on hover */
    transform: scale(1.2); /* Slightly scale up on hover */
    animation: pulse 0.5s infinite; /* Pulse animation on hover */
}

/* Active effect for both delete and edit buttons */
.delete-btn:active, .edit-btn:active {
    color: #0056b3; /* Darker shade on active */
    transform: scale(1.1); /* Slightly smaller scale on active */
}

/* Optional animation to pulse the icons in and out */
@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.15);
    }
}


 /* Style for the scroll buttons */
 .scroll-button {
      position: fixed;
      bottom: 20px;
      width: 50px;
      height: 50px;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #007bff; /* Arrow color */
      font-size: 24px;
      cursor: pointer;
      z-index: 9999;
      animation: pulse 2s infinite; /* Apply animation */
  }

  /* Page Up arrow positioned on the left */
  #pageUp {
      left: calc(50% - 60px); /* Adjust left position for centered spacing */
  }

  /* Page Down arrow positioned on the right */
  #pageDown {
      left: calc(50% + 10px); /* Adjust left position for centered spacing */
  }

  /* Hover effect for scroll buttons */
  .scroll-button:hover {
      color: #0056b3; /* Darker blue on hover */
  }

  /* Keyframes for pulse animation */
  @keyframes pulse {
      0% {
          transform: scale(1);
      }
      50% {
          transform: scale(1.1); /* Slightly enlarge */
      }
      100% {
          transform: scale(1);
      }
  }

  /* Bounce animation for hover */
  .scroll-button:hover {
      animation: bounce 1s infinite; /* Change animation on hover */
  }

  @keyframes bounce {
      0%, 100% {
          transform: translateY(0);
      }
      50% {
          transform: translateY(-10px); /* Move up slightly */
      }
  }


#exportButtons {
    display: flex;
    gap: 15px;
    margin: 20px 0;
    opacity: 0; /* Initially hidden */
    pointer-events: none; /* Prevent interaction when hidden */
    transition: opacity 0.5s ease;
}

#exportButtons.visible {
    opacity: 1; /* Become visible */
    pointer-events: auto; /* Enable interaction */
}

/* Button Styling */
.exportButton {
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    opacity: 0;
    transform: scale(0.9) rotate(-10deg);
    animation: slideFadeIn 0.5s ease-out forwards;
    transition: transform 0.3s, box-shadow 0.3s;
}

/* Hover effect */
.exportButton:hover {
    transform: scale(1.1) rotate(0deg);
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

/* Animation Keyframes */
@keyframes slideFadeIn {
    0% {
        opacity: 0;
        transform: translateY(30px) scale(0.9) rotate(-10deg);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1) rotate(0deg);
    }
}



.file-option {
    border: 1px solid #4CAF50; /* Green border */
    padding: 15px; /* More space */
    width: 200px; /* Set a fixed width */
    text-align: center; /* Center text */
    border-radius: 8px; /* Rounded corners */
    background-color: #f9f9f9; /* Light gray background */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow */
    cursor: pointer; /* Pointer cursor on hover */
    transition: all 0.3s ease; /* Smooth transition for hover effect */
    position: relative; /* Ensure animations align properly */
}

.file-option:hover {
    background-color: #e8f5e9; /* Slightly darker background on hover */
    transform: scale(1.05); /* Scale up on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Deepen shadow on hover */
}

.file-option h4 {
    margin: 0; /* Remove default margin */
    color: #2e7d32; /* Dark green text */
    font-family: 'Arial', sans-serif; /* Clean font style */
}

/* Ensure .col16 is centered and bold in the table */
.col16 {
    text-align: center;   /* Center the text */
    font-weight: bold;    /* Make the text bold */
}



    </style>
</head>
<body id="user_body">
<div id="direct" style="display:none;">

<h1>Upload and Submit File</h1>

    <!-- File Upload Form -->
    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="uploaded_file" id="uploaded_file" required>
        <button type="submit">Upload</button>
    </form>

    <!-- Alert Section -->
    <div id="alert" style="margin-top: 20px;"></div>
    <button style="display:;" class="close-btn1" >X</button>

    <!-- Data Submission Form -->
    <form id="submitForm">
        <table id="dataTable" border="1" style="margin-top: 20px; display: none;">
            <thead>
                <tr>
                    <th>Auction No</th>
                    <th>Warehouse</th>
                    <th>Mark</th>
                    <th>Grade</th>
                    <th>Manufacturing Date</th>
                    <th>Certification</th>
                    <th>Invoice</th>
                    <th>No of Packages</th>
                    <th>Type</th>
                    <th>Net Weight</th>
                    <th>Nature</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <button type="button" id="submit_edit" style="margin-top: 20px; display: none;">Submit Changes</button>
    </form>
</div>



    <h1 style="color:green;" id="h1">Catalogue Data Entry</h1>
    
    <form id="dataEntryForm"  id="mainform">
    <span style="display:none;" class="close">&times;</span>
        <!-- Auction form fields -->
        <div class="form-group">
    <label for="year">Select Year:</label>
    <select id="year" class="year" name="year" required>
        <option value="">Select Year</option>
        <?php
        // Fetch unique years from closing_date
        $conn = new mysqli("localhost", "root", "", "vtbl_db");
        $result = $conn->query("SELECT DISTINCT YEAR(closing_date) AS year FROM auction_dates ORDER BY year");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['year']}'>{$row['year']}</option>";
        }
        $conn->close();
        ?>
    </select>
</div>
<div class="form-group">
    <label for="auction_no">Auction No:</label>
    <select id="auction_no" class="auction_no" name="auction_no" required>
        <option value="">Select Auction No</option>
        <!-- Auction numbers will be populated dynamically based on selected year -->
    </select>
</div>

        <div class="form-group" >
            <label for="closingDate">Closing Date:</label>
            <input type="text" id="closingDate" readonly>
        </div>
        <div class="form-group">
            <label for="auctionDate">Auction Date:</label>
            <input type="text" id="auctionDate" readonly>
        </div>
        <div class="form-group">
            <label for="promptDate">Prompt Date:</label>
            <input type="text" id="promptDate" readonly>
        </div>

  <div class="form-group" id="startinglot">
    <label for="starting_lot">Starting Lot:</label>
    <input type="number" id="starting_lot" name="starting_lot" required>
    <button type="button" id="saveStartingLot" class="btn btn-primary">Save start lot</button>
    <button type="button"  id="editStartingLot" class="btn btn-secondary" style="display: none;">Edit start lot</button>
    <button type="button" class="saveButton" style="display: none;">Save lots </button>
</div>

<div id="file" class="form-group file-option">
    <h4>File Option</h4>
</div>

    
        <div id="dynamicFields" style="display: none;">

        <div class="form-group" style="display: none;" >
            <label for="comments">Comments:</label>
            <input type="text" id="comments" name="comments">
        </div>
        <div class="form-group" style="display: none;">
            <label for="value">Value:</label>
            <input type="number" id="value" name="value">
        </div>

        <div class="form-group">
            <label for="warehouse">Warehouse:</label>
            <select id="warehouse" name="warehouse" required>
                <option value="Bravo">Bravo</option>
                <option value="EUTECO">EUTEACO</option>
            </select>
        </div>

        <div class="form-group">
            <label for="mark">Mark:</label>
            <select id="mark" name="mark" required>
                <option value="Arc Mountain">Arc Mountain</option>
                <option value="Chivanjee">Chivanjee</option>
                <option value="Dindira">Dindira</option>
                <option value="Kibena">Kibena</option>
                <option value="Ikanga">Ikanga</option>
                <option value="Itona">Itona</option>
                <option value="Livingstonia">Livingstonia</option>
                <option value="Bulwa">Bulwa</option>
                <option value="Kwamkoro">Kwamkoro</option>
                <option value="Mponde">Mponde</option>
                <option value="Kiganga">Kiganga</option>
                <option value="Kagera">Kagera</option>
                <option value="Kibwele">Kibwere</option>
                <option value="Kabambe">Kabambe</option>
                <option value="Lugoda">Lugoda</option>
                <option value="Kilima">Kilima</option>
                <option value="Lupembe">Lupembe</option>
                <option value="Luponde">Luponde</option>
                <option value="Katumba">Katumba</option>
                <option value="Mwakaleli">Mwakaleli</option>
            </select>
        </div>

      

        <div class="form-group">
            <label for="grade">Grade:</label>
            <select id="grade" name="grade" required>
                <option value="BP1">BP1</option>
                <option value="BP">BP</option>
                <option value="PF1">PF1</option>
                <option value="PF">PF</option>
                <option value="PD">PD</option>
                <option value="D1">D1</option>
                <option value="FNGS">FNGS</option>
                <option value="DUST">DUST</option>
                <option value="D2">D2</option>
                <option value="BMF">BMF</option>
                <option value="Orthodox">Orthodox</option>
            </select>
        </div>

        <div class="form-group">
            <label for="manf_date">Manf Date:</label>
            <input type="date" id="manf_date" name="manf_date" required>
        </div>

        <div class="form-group">
            <label for="invoice">Invoice:</label>
            <input type="text, number" id="invoice" name="invoice" required>
        </div>

        <div class="form-group">
            <label for="no_of_pkgs">No of Pkgs:</label>
            <input type="number" id="no_of_pkgs" name="no_of_pkgs" required>
        </div>

        <div class="form-group">
            <label for="type">Type:</label>
            <select id="type" name="type" required>
                <option value="TPP">TPP</option>
                <option value="Paper">PB</option>
            </select>
        </div>

        <div class="form-group">
            <label for="net_weight">Net weight (kg):</label>
            <input type="number" id="net_weight" name="net_weight" required>
        </div>

        <div class="form-group">
            <label for="nature">Nature:</label>
            <select id="nature" name="nature" required>
                <option value="Fresh">Fresh</option>
                <option value="Reprint">Reprint</option>
            </select>
        </div>

        <div class="form-group">
            <label for="certification">Certification:</label>
            <select id="certification" name="certification" required>
                <option value="RNA">RA</option>
                <option value="Non RNA "> Non RA</option>
            </select>
        </div>
        <div class="form-group" style="display:none;">
            <label for="kg">Kg:</label>
            <input type="number" id="kg" name="kg">
        </div>

        <div class="form-group" style="display: none;">
            <label for="sale_price">Sale Price:</label>
            <input type="number" id="sale_price" name="sale_price">
        </div>

        <div class="form-group" style="display: none;">
            <label for="buyer_packages">Buyer Packages:</label>
            <input type="text" id="buyer_packages" name="buyer_packages">
        </div>
       
        <button id="submit1" type="submit">Submit</button>


        <button id="submit2" style="display:none;">update</button>
        
        </div>
        <span style="display:none;" class="close">&times;</span>
        
    </form>

   <div id="cover1" style="display:none;">
<?php require 'coverpage1.php' ?>;
</div>

<div id="cover2" style="display:none;">
<?php include 'coverpage2.php' ?>;
</div>
    <h2 id="h2" style="color:green">Auction Details</h2>
    <div id="dataContainer">
        <p id="defaultMessage" class="movingMessage">No auction number selected. Please select an auction number.</p>

        <!-- Table 1 for Grades BP1, PF1, PD, D1 -->
        <h3 style="color:blue; text-align:center;" id="h3" class="h3">Main Catalogue</h3>
        <table id="dataTable1">
        
            <thead class="thead">
            <tr class="col16">
                    <th style="text-align: center; color:green; font-weight:bold;" colspan="16">VISION TEA BROKERS LTD</th>
                </tr>
                <tr class="col16">
            <th style="text-align: center;" colspan="16">Main Auction No: <span id="AuctionNos" style="word-spacing: 0.2em; padding-left: 5px;"></span>  of <spans  type="text" id="auctionDates1" style="word-spacing: 0.2em; padding-left: 5px;"> </spans></th>
            </tr>
                <tr>
                <th>Comme <br>nts</th>
                    <th>Ware<br> Hse</th>
                    <th>Value</th>
                    <th>Mark</th>
                    <th>Lot No</th>
                    <th>Grade</th>
                    <th>Manf<br> Date</th>
                    <th>Certifi <br>cation</th>
                    <th>Invoice</th>
                    <th>Pkgs</th>
                    <th>Type</th>
                    <th>Net</th>
                    <th>Kg</th>
                    <th>Nature</th>
                    <th>Sale <br>Price</th>
                    <th> Buyers & <br>Pkgs</th>
                </tr>
            </thead>
            <tbody class="tbod">
                <!-- Data rows populated here for Table 1 -->
            </tbody>
        </table>

        <!-- Table 2 for Grades BP, PF, FNGS, D2, DUST, BMF -->
        <h3 style="color:blue; text-align:center; " id="h4" class="h3">Secondary Catalogue</h3>
        <table id="dataTable2">
            <thead class="thead">
                <tr class="col16">
                    <th style="text-align: center; color:green; font-weight:bold;" colspan="16">VISION TEA BROKERS LTD</th>
                </tr class="col16">
            <tr>
                    <th style="text-align: center;" colspan="16">Secondary Auction No: <span id="secondaryAuctionNo" style="word-spacing: 0.2em; padding-right: 5px;"></span>  of <span  type="text" id="auctionDates2" style="word-spacing: 0.2em; padding-left: 5px;"> </span></th>
                </tr>
                <tr>
                <th>Comme <br>nts</th>
                    <th>Ware<br> Hse</th>
                    <th>Value</th>
                    <th>Mark</th>
                    <th>Lot No</th>
                    <th>Grade</th>
                    <th>Manf<br> Date</th>
                    <th>Certifi <br>cation</th>
                    <th>Invoice</th>
                    <th>Pkgs</th>
                    <th>Type</th>
                    <th>Net</th>
                    <th>Kg</th>
                    <th>Nature</th>
                    <th>Sale <br>Price</th>
                    <th> Buyers & <br>Pkgs</th>
                </tr>
            </thead>
            <tbody class="tbod">
                <!-- Data rows populated here for Table 2 -->
            </tbody>
        </table>
         <button id="proceed" >Proceed <i class="fas fa-arrow-right"></i></button>
<button class="exportButton" style="background-color: #007BFF; display:none; animation-delay: 0s;">Print</button>
    <button class="exportButton" style="background-color: #28a745;display:none;  animation-delay: 0.2s;">PDF</button>
    <button class="exportButton" style="background-color: #FFC107; display:none; animation-delay: 0.4s;">Excel</button>
    <button class="exportButton" style="background-color: #DC3545; display:none; animation-delay: 0.6s;">Word</button>
<a  id="backButton" onclick="goBack()">
    ⬅ Back
</a>
    </div>
   
    <script>
      $(document).ready(function() { 


        $(window).resize(function () {
    // Adjust columns for both tables on window resize
    $('#dataTable1').DataTable().columns.adjust();
    $('#dataTable2').DataTable().columns.adjust();
});


       // Retrieve processed data from localStorage if available
    let processedData = JSON.parse(localStorage.getItem("processedData")) || [];

// If there is data stored in localStorage, show the table
if (processedData.length > 0) {
    $('#dataTable').show();
    $('#submit_edit, .close-btn1').show();
    populateTable(processedData);
}

// Handle file upload
$('#uploadForm').on('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: 'process_file.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#alert').html('<p>Uploading and processing file...</p>').show();
            $('#dataTable tbody').empty();
            $('#submit_edit, .movingMessage').hide();
            $('.close-btn1').show();
         
        },
        success: function (response) {
            try {
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    $('#alert').html('<p style="color: green;">File processed successfully!</p>');
                    processedData = data.data;
                    localStorage.setItem("processedData", JSON.stringify(processedData)); // Store in localStorage
                    populateTable(processedData);
                } else {
                    $('#alert').html('<p style="color: red;">' + data.message + '</p>');
                }
            } catch (error) {
                $('#alert').html('<p style="color: red;">Error: Invalid server response.</p>');
            }
            // Automatically hide the alert after 5 seconds
            setTimeout(function() {
                $('#alert').fadeOut();
            }, 5000);
        },
        error: function () {
            $('#alert').html('<p style="color: red;">Error uploading the file. Please try again.</p>');
            // Automatically hide the alert after 5 seconds
            setTimeout(function() {
                $('#alert').fadeOut();
            }, 5000);
        }
    });
});

// Populate table with editable fields
function populateTable(data) {
    let tbody = $('#dataTable tbody');
    tbody.empty();
    data.forEach(function (row) {
        tbody.append('<tr>' +
            '<td><input type="text" name="auction_no" value="' + row.auction_no + '"></td>' +
            '<td><input type="text" name="warehouse" value="' + row.warehouse + '"></td>' +
            '<td><input type="text" name="mark" value="' + row.mark + '"></td>' +
            '<td><input type="text" name="grade" value="' + row.grade + '"></td>' +
            '<td><input type="date" name="manf_date" value="' + row.manf_date + '"></td>' +
            '<td><input type="text" name="certification" value="' + row.certification + '"></td>' +
            '<td><input type="text" name="invoice" value="' + row.invoice + '"></td>' +
            '<td><input type="number" name="no_of_pkgs" value="' + row.no_of_pkgs + '"></td>' +
            '<td><input type="text" name="type" value="' + row.type + '"></td>' +
            '<td><input type="number" name="net_weight" value="' + row.net_weight + '"></td>' +
            '<td><input type="text" name="nature" value="' + row.nature + '"></td>' +
            '</tr>');
    });
    $('#dataTable').show();
    $('#submit_edit, .close-btn1').show();
}

// Handle submission of edited data
$('#submit_edit').on('click', function (e) {
    e.preventDefault();

    // Check if there is any data to submit
    if (processedData.length === 0) {
        alert('No data to submit. Please upload and process a file first.');
        return;
    }

    let updatedData = [];
    $('#dataTable tbody tr').each(function () {
        let row = {};
        $(this).find('input').each(function () {
            row[$(this).attr('name')] = $(this).val();
        });
        updatedData.push(row);
    });

    $.ajax({
        url: 'insert_data2.php',
        type: 'POST',
        data: { submit_edit: true, data: updatedData },
        dataType: 'json',
        success: function (response) {
            if (response.success && response.success.length > 0) {
                alert('Success:\n' + response.success.join('\n'));
            }

            if (response.errors && response.errors.length > 0) {
                alert('Errors:\n' + response.errors.join('\n'));
            }

            if (response.emptyRowFound) {
                alert('One or more fields are empty. Please fill all the required fields.');
            }

            // After submission, reset the data in localStorage
            localStorage.removeItem("processedData");

           
        },
        error: function (xhr, status, error) {
            alert('An error occurred: ' + error);
        }
    });
});





        
 


    // Check localStorage for visibility state
    if (localStorage.getItem('state') === 'direct') {
        $('#h1,#defaultMessage, #h2, #dataEntryForm').hide();
        $('#direct').show();
    } else {
        $('#h1,#defaultMessage, #h2, #dataEntryForm').show();
        $('#direct').hide();
    }

    // Bind save function to the #file button click
    $('#file').on('click', function () {
        // Update visibility
        $('#h1, #defaultMessage, #h2, #dataEntryForm').hide();
        $('#direct').show();

        // Unselect the year
        $('#year').val(''); // Clear the dropdown selection
        localStorage.removeItem('selectedYear'); // Remove stored year

        // Clear auction numbers when year is deselected
        $('#auction_no').empty().append('<option value="">Select Auction No</option>');
        localStorage.removeItem('selectedAuctionNo'); // Remove stored auction number

        // Save state to localStorage
        localStorage.setItem('state', 'direct');

        // Optional reload if needed (though not recommended unless critical)
        location.reload();
    });

    // Bind save function to the .close-btn1 click
    $('.close-btn1').on('click', function () {
        // Update visibility
        $('#h1,#defaultMessage, #h2, #dataEntryForm').show();
        $('#direct').hide();

        // Save state to localStorage
        localStorage.setItem('state', 'h1', 'h2', 'defaultMessage');
    });

    





 // On page load, restore selected year and auction number
 var selectedYear = localStorage.getItem('selectedYear');
    var selectedAuctionNo = localStorage.getItem('selectedAuctionNo');
    
    if (selectedYear) {

        $('#year').val(selectedYear);
        fetchAuctionNos(selectedYear, selectedAuctionNo);
    }

    // When the year is selected or deselected
    $('#year').change(function() {
        var year = $(this).val();
        localStorage.setItem('selectedYear', year); // Store the selected year
        location.reload('#auction_no');
            // Clear auction numbers when year is deselected
            $('#auction_no').empty().append('<option value="">Select Auction No</option>');
            localStorage.removeItem('selectedAuctionNo'); // Remove the auction number when year is cleared
     

        if (year) {
            fetchAuctionNos(year);
        } else {
            location.reload('#auction_no');
            // Clear auction numbers when year is deselected
            $('#auction_no').empty().append('<option value="">Select Auction No</option>');
            localStorage.removeItem('selectedAuctionNo'); // Remove the auction number when year is cleared
        }
    });

    // Fetch auction numbers for the selected year
    function fetchAuctionNos(year, selectedAuctionNo = '') {
        var $auctionNoSelect = $('#auction_no');
        $auctionNoSelect.empty().append('<option value="">Select Auction No</option>');

        if (year) {
            $.ajax({
                url: 'get_auction_nos.php',
                type: 'GET',
                data: { year: year },
                success: function(response) {
                    var auctionNos = JSON.parse(response);
                    $.each(auctionNos, function(index, auction_no) {
                        $auctionNoSelect.append('<option value="' + auction_no + '">' + auction_no + '</option>');
                    });
                    // Restore the previously selected auction number
                    if (selectedAuctionNo) {
                        $auctionNoSelect.val(selectedAuctionNo);
                    }
                },
                error: function() {
                    alert('Error fetching auction numbers.');
                }
            });
        }
    }

    // When the auction number is selected
    $('#auction_no').change(function() {
        var auctionNo = $(this).val();
        localStorage.setItem('selectedAuctionNo', auctionNo); // Store the selected auction number
    });



    
    // Save updated lot numbers to the database
    function saveLotNoFromTable() {
        $('#dataTable1 tbody tr, #dataTable2 tbody tr').each(function () {
            const row = $(this);
            const id = row.find('.icon-cell .edit-btn').data('id'); // Get ID from the edit button
            const lotNo = row.find('.lot_no').text().trim(); // Get lot number from the editable cell

            if (id && lotNo) {
                $.ajax({
                    url: 'update_lot_no.php',
                    type: 'POST',
                    data: { id: id, lot_no: lotNo },
                    success: function (response) {
                        console.log(`Lot No. updated for ID ${id}: ${response}`);
                    },
                    error: function () {
                        console.error(`Error updating lot_no for ID ${id}.`);
                    }
                });
            }
        });
    }

    // Bind save function to a button click
    $('.saveButton').on('click', function () {
        saveLotNoFromTable();
        location.reload('#cover2');
        $('.saveButton').hide();
        
   
    });

    

   
    


       
    // Check sessionStorage on page load for form visibility
    if (sessionStorage.getItem('formOpen') === 'true') {
        $('#dataEntryForm').show();
        $('#form-overlay').show();
    }

    // When an edit button is clicked, open the form and save the state
    $(document).on('click', '.edit-btn', function() {
        const rowId = $(this).data('id');
$('.close').show()
        // Store form open state in sessionStorage
        sessionStorage.setItem('formOpen', 'true');

        const styles = `
            #form-overlay {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 9999;
            }
            #dataEntryForm {
                display: block;
                position: absolute;
                top: 70%;
                left: 35%;
                transform: translate(-50%, -50%);
                background-color: #fff;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                width: 80%;
                height: 550px;
                max-width: 800px;
                z-index: 10000;
            }

                .close {
                display:block;
                color: #aaa;
                font-size: 40px;
                font-weight: bold;
                cursor: pointer;
                position: absolute;
                top: 10px;
                right: 10px;
            }
            .close:hover {
             color: red;}
            .close:focus {
                color: red;
                cursor: pointer;
            }
        `;

        $('<style>').prop('type', 'text/css').html(styles).appendTo('head');

        // AJAX request to fetch data and populate the form
        $.ajax({
            url: 'get_row_data.php',
            type: 'GET',
            data: { id: rowId },
            dataType: 'json',
            success: function(data) {
                if (data) {
                    $('#warehouse').val(data.warehouse);
                    $('#mark').val(data.mark);
                    $('#grade').val(data.grade);
                    $('#manf_date').val(data.manf_date);
                    $('#certification').val(data.certification);
                    $('#invoice').val(data.invoice);
                    $('#no_of_pkgs').val(data.no_of_pkgs);
                    $('#type').val(data.type);
                    $('#net_weight').val(data.net_weight);
                    $('#nature').val(data.nature);
                    $('#submit2').show();
                    $('#submit1').hide();
                }
            }
        });

        $('#submit2').off('click').on('click', function() {
            updateRow(rowId);
            $('#invoice')[0].reset();
            location.reload();
        });
    });

    function updateRow(rowId) {
        const formData = {
            id: rowId,
            warehouse: $('#warehouse').val(),
            mark: $('#mark').val(),
            grade: $('#grade').val(),
            manf_date: $('#manf_date').val(),
            certification: $('#certification').val(),
            invoice: $('#invoice').val(),
            no_of_pkgs: $('#no_of_pkgs').val(),
            type: $('#type').val(),
            net_weight: $('#net_weight').val(),
            nature: $('#nature').val()
        };

        $.ajax({
            url: 'update_row.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response === 'success') {
                    alert('Data updated successfully.');
                    const auctionNo = $('#auction_no').val();
                    fetchData(auctionNo);
                }
            },
            error: function() {
                // Handle error
            }
        });
    }

    // Close the form overlay and reset the state only when the close button is clicked
    $(document).on('click', '.close', function() {
        $('#dataEntryForm').fadeOut(200);
        $('#form-overlay').fadeOut();
        location.reload('#dynamicsForm');
        // Clear form open state
        sessionStorage.removeItem('formOpen');
    });




$(document).on('click', '.delete-btn', function() {
    var rowId = $(this).data('id');
    if (confirm('Are you sure you want to delete this invoice?')) {
        $.ajax({
            url: 'delete_row.php',  // PHP script to delete the row
            type: 'POST',
            data: { id: rowId },
            success: function(response) {
                if (response === 'success') {
                  
                    
                    // Reload just the tbody for the current auction number
                    const auctionNo = $('#auction_no').val();
                    fetchData(auctionNo); // Reload data for selected auction number
                    
                } else {
                    alert('Error deleting row');
                }
            },
            error: function() {
                alert('Error deleting row');
            }
        });
    }
});



    // Proceed button click event
    $('#proceed').click(function () {
        const table1HasRows = $('#dataTable1 tbody tr').length > 0;
        const table2HasRows = $('#dataTable2 tbody tr').length > 0;

        // Handle the case where both tables have rows
        if (table1HasRows && table2HasRows) {
            $('#dataTable1, #dataTable2, #cover1, #cover2, #pageUp, #pageDown, #backButton').show();
           
            $('#defaultMessage, #h2, #h4, #h3, #h1, #dataEntryForm, .edit-btn, .delete-btn').hide();
            $(this).hide(); // Hide Proceed button
            $('button:contains("Print"), button:contains("PDF"), button:contains("Excel"), button:contains("Word")').show();
        } else if (table1HasRows) {
            $('#dataTable1, #cover1, #cover2, #pageUp, #pageDown, #backButton').show();
            $('#dataTable2').hide();
           
            $('#defaultMessage, #h2, #h4, #h3, #h1, #dataEntryForm, .edit-btn, .delete-btn').hide();
            $(this).hide(); // Hide Proceed button
            $('button:contains("Print"), button:contains("PDF"), button:contains("Excel"), button:contains("Word")').show();
        } else if (table2HasRows) {
            $('#dataTable2, #cover1, #cover2, #pageUp, #pageDown, #backButton').show();
            $('#dataTable1').hide();
           
            $('#defaultMessage, #h2, #h4, #h3, #h1, #dataEntryForm, .edit-btn, .delete-btn').hide();
            $(this).hide(); // Hide Proceed button
            $('button:contains("Print"), button:contains("PDF"), button:contains("Excel"), button:contains("Word")').show();
        } else {
            $('#dataTable1, #dataTable2').show();
            $('#defaultMessage, #cover1, #cover2, #pageUp, #pageDown').hide();
            $('#h2, #h3, #h4, #h1').show();
            $('.edit-btn, .delete-btn, #dataEntryForm').show();
            $('button:contains("Print"), #backButton, button:contains("PDF"), button:contains("Excel"), button:contains("Word")').hide();
            alert('OOPS! No catalogue has been prepared for this auction number. Please enter new invoice records or select a different auction number.');
        }

      

    
    // Function to enable Page Up and Page Down functionality
   
    if ($('#pageUp').length === 0) {
            $('body').append('<div id="pageUp" class="scroll-button">&#9650;</div>'); 
            $('body').append('<div id="pageDown" class="scroll-button">&#9660;</div>');
        }

        $('#pageUp').click(function () {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        });

        $('#pageDown').click(function () {
            $('html, body').animate({ scrollTop: $(document).height() }, 'slow');
        });
    });

   



     
 // Back button click event
 $('#backButton').click(function () {
location.reload('#cover1, cover2')
        $('#pageUp, #defaultMessage, #pageDown').hide();
        $(' cover1, cover2').hide();
        $(' #dataTable1, #dataTable2, #h2, #h3, #h4, #h1').show();
        $('.edit-btn, .delete-btn, #dataEntryForm').show();
        $('#proceed').show();
        $('button:contains("Print"), #backButton, button:contains("PDF"), button:contains("Excel"), button:contains("Word")').hide();
    });




       
        // Function to get selected auction number
function getSelectedAuctionNo() {
    return $('#auction_no').val();
}
// Utility function to wrap table content with border and page break after each table
function wrapWithBorderAndPageBreak(htmlContent) {
    return '<div style="border: 1px solid #ddd; padding: 8px; text-align: center; page-break-after: always;">' + htmlContent + '</div>';
}

// Print button click event with no background colors in tables
$('button:contains("Print")').click(function() {

    
    var printContents = '';
    
    // Check which tables are visible and add them to print content with page breaks
    if ($('#cover1').is(':visible')) printContents += wrapWithBorderAndPageBreak($('#cover1').prop('outerHTML'));
    if ($('#cover2').is(':visible')) printContents += wrapWithBorderAndPageBreak($('#cover2').prop('outerHTML'));

    if ($('#dataTable1').is(':visible')) printContents += wrapWithBorderAndPageBreak($('#dataTable1').prop('outerHTML'));
    if ($('#dataTable2').is(':visible')) printContents += wrapWithBorderAndPageBreak($('#dataTable2').prop('outerHTML'));

    // Open a new print window and apply CSS for print-only styling
    var printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write(`
        <html>
        <head>
            <style>
                /* Basic table styling */
                table, th, td {
                    border: 1px solid #ddd;
                    border-collapse: collapse;
                    padding: 8px;
                    text-align: center;
                }
                /* Remove background colors */
                th, td, table {
                    background-color: transparent !important;
                }
                /* Page break after each table */
                .page-break {
                    page-break-after: always;
                }
            </style>
        </head>
        <body>
            ${printContents}
        </body>
        </html>
    `);

    // Close and print the new window
    printWindow.document.close();
    printWindow.print();
});

// Wraps table content with a page-break div
function wrapWithBorderAndPageBreak(content) {
    return `<div class="page-break">${content}</div>`;
    
}


$('button:contains("Excel")').click(function () {
    var auctionNo = getSelectedAuctionNo() || "Unknown";

    // Initialize the Excel workbook and worksheet
    var wb = XLSX.utils.book_new();
    wb.Props = {
        Title: `VTBL CATALOGUE ${auctionNo}`,
        Author: "VISION TEA BROKERS LTD",
        CreatedDate: new Date()
    };

    // Function to apply center alignment to merged cells
    function applyCenterAlignment(ws) {
        // Define merge ranges for the first and second rows (A1:P1 and A2:P2)
        ws["!merges"] = [
            { s: { r: 0, c: 0 }, e: { r: 0, c: 15 } }, // Merge A1:P1
            { s: { r: 1, c: 0 }, e: { r: 1, c: 15 } }  // Merge A2:P2
        ];

        // Apply center alignment style to A1 (first merged row)
        if (ws["A1"]) {
            ws["A1"].s = {
                alignment: {
                    horizontal: "center",
                    vertical: "center"
                },
                font: {
                    bold: true
                }
            };
        }

        // Apply center alignment style to A2 (second merged row)
        if (ws["A2"]) {
            ws["A2"].s = {
                alignment: {
                    horizontal: "center",
                    vertical: "center"
                },
                font: {
                    bold: false
                }
            };
        }
    }

    // Process DataTable1 if visible
    if ($('#dataTable1').is(':visible')) {
        var table1Data = [];
        $('#dataTable1 tr').each(function () {
            var rowData = [];
            $(this).find('th, td').each(function () {
                rowData.push($(this).text().trim());
            });
            table1Data.push(rowData);
        });

        var ws1 = XLSX.utils.aoa_to_sheet(table1Data);

        // Apply the center alignment to DataTable1
        applyCenterAlignment(ws1);

        // Auto-size columns based on content starting from row 3
        var colWidths = [];
        for (var col = 0; col < 16; col++) { // A to P (16 columns)
            var maxLength = 0;
            for (var row = 2; row < table1Data.length; row++) { // Start from row 3 (index 2)
                if (table1Data[row][col]) {
                    maxLength = Math.max(maxLength, table1Data[row][col].length);
                }
            }
            colWidths[col] = { wch: maxLength };
        }
        ws1["!cols"] = colWidths;

        XLSX.utils.book_append_sheet(wb, ws1, "Main Catalogue");
    }

    // Process DataTable2 if visible
    if ($('#dataTable2').is(':visible')) {
        var table2Data = [];
        $('#dataTable2 tr').each(function () {
            var rowData = [];
            $(this).find('th, td').each(function () {
                rowData.push($(this).text().trim());
            });
            table2Data.push(rowData);
        });

        var ws2 = XLSX.utils.aoa_to_sheet(table2Data);

        // Apply the center alignment to DataTable2
        applyCenterAlignment(ws2);

        // Auto-size columns based on content starting from row 3
        var colWidths2 = [];
        for (var col = 0; col < 16; col++) { // A to P (16 columns)
            var maxLength = 0;
            for (var row = 2; row < table2Data.length; row++) { // Start from row 3 (index 2)
                if (table2Data[row][col]) {
                    maxLength = Math.max(maxLength, table2Data[row][col].length);
                }
            }
            colWidths2[col] = { wch: maxLength };
        }
        ws2["!cols"] = colWidths2;

        XLSX.utils.book_append_sheet(wb, ws2, "Secondary Catalogue");
    }

    // Generate the Excel file and trigger the download
    var excelFileName = `VTBL_EXCEL_CATALOGUE_${auctionNo}.xlsx`;
    XLSX.writeFile(wb, excelFileName);
});








// PDF button click event to generate PDF with landscape fit and effective page breaks
$('button:contains("PDF")').click(function () {

$(window).resize(function () {
    // Adjust columns for both tables on window resize
    $('#dataTable1').DataTable().columns.adjust();
    $('#dataTable2').DataTable().columns.adjust();
});

var auctionNo = getSelectedAuctionNo() || "Unknown";

// Create container div for tables with page breaks
var element = document.createElement('div');
var hasVisibleContent = false; // Flag to track if any table content is added

// Check visibility and add content accordingly
if ($('#cover1').is(':visible')) {
    element.innerHTML += wrapWithPageBreak($('#cover1')[0].outerHTML);
    hasVisibleContent = true;
}
if ($('#cover2').is(':visible')) {
    element.innerHTML += wrapWithPageBreak($('#cover2')[0].outerHTML);  // Include cover2 with placeholders intact
    hasVisibleContent = true;
}

// Check visibility of data tables
var isDataTable1Visible = $('#dataTable1').is(':visible');
var isDataTable2Visible = $('#dataTable2').is(':visible');

// If both dataTable1 and dataTable2 are visible, break page after dataTable1 only
if (isDataTable1Visible) {
    element.innerHTML += $('#dataTable1')[0].outerHTML;
    hasVisibleContent = true;
    if (isDataTable2Visible) {
        // Add page break after dataTable1 if both tables are visible
        element.innerHTML += wrapWithPageBreak('');
    }
}

if (isDataTable2Visible && !isDataTable1Visible) {
    element.innerHTML += $('#dataTable2')[0].outerHTML;
    hasVisibleContent = true;
} else if (isDataTable2Visible && isDataTable1Visible) {
    element.innerHTML += $('#dataTable2')[0].outerHTML;
    hasVisibleContent = true;
}

// If no content is visible, skip PDF generation entirely (avoid creating a blank page)
if (!hasVisibleContent) {
    console.log('No visible content to generate PDF.');
    return; // Skip PDF generation
}

// PDF generation options
var options = {
    margin: 0.3, // Small margin to use max page width
    filename: `VTBL_CATALOGUE_${auctionNo}.pdf`,
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2, backgroundColor: null }, // High scale for clarity and no background
    jsPDF: { unit: 'in', format: 'a4', orientation: 'landscape' },
};

// Style settings for precise table fitting and page breaks
var style = `
    <style>
        #pdfContentWrapper {
            width: 100%;
            max-width: 100%;
            transform: scale(1); /* Slight scaling for full-width fit */
            transform-origin: top left;
        }

        .page-break {
            display: block;
            page-break-after: always;
        }
        /* Ensuring table in cover2 spans a full page in landscape */
        .landscape-table {
            page-break-before: always;
            page-break-after: always;
            width: 100%;
            transform: rotate(90deg);
            margin: 0;
            padding: 0;
        }
    </style>
`;

// Wrap content with custom styles only if there's content
if (hasVisibleContent) {
    element.innerHTML = style + `<div id="pdfContentWrapper">${element.innerHTML}</div>`;

    // Generate the PDF
    html2pdf().set(options).from(element).save();
}
});

// Function to add page breaks between tables
function wrapWithPageBreak(content) {
return `<div class="page-break">${content}</div>`;

}

$('button:contains("Word")').click(function () {
    var auctionNo = getSelectedAuctionNo() || "Unknown";

    // Start building the Word document content
    var content = `
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
        <head>
            <style>
                /* General styling */
                body {
                    font-family: Arial, sans-serif;
                    font-size: 10px;
                    line-height: 1.5;
                    margin: 0;
                    text-align: center;
                }

                @page {
                    size: A4 portrait;
                    margin: 1in;
                }

                .page-break {
                    page-break-before: always;
                    display: block;
                    height: 0;
                }

                /* Common styles for cover1 and cover2 */
                .cover-border {
                    border: 2px solid #000; /* Strong outer border */
                    padding: 20px;
                    margin: 0 auto;
                    width: 100%;
                    box-sizing: border-box;
                    display: block;
                }

                /* Cover1 specific styling */
                .cover1-page {
                    font-size: 8px;
                }

                /* Cover2 specific styling */
                .cover2-page {
                    font-size: 7px;
                }

                /* Table styling */
                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                table, th, td {
                    border: 1px solid #000;
                    padding: 5px;
                    text-align: center;
                }

                th {
                    font-weight: bold;
                }

                /* Green text for VISION TEA BROKERS */
                .green-text {
                    color: green;
                }
            </style>
        </head>
        <body>`;

   

    // Add DataTable1 content
    if ($('#dataTable1').is(':visible')) {
        var table1Html = $('#dataTable1').prop('outerHTML');
        // Apply green color to VISION TEA BROKERS
        table1Html = table1Html.replace(/VISION TEA BROKERS LTD/g, '<span class="green-text">VISION TEA BROKERS</span>');
        // Add the table with a page break
        content += `<div class="table-page page-break">${table1Html}</div>`;
    }

    // Add DataTable2 content
    if ($('#dataTable2').is(':visible')) {
        var table2Html = $('#dataTable2').prop('outerHTML');
        // Apply green color to VISION TEA BROKERS
        table2Html = table2Html.replace(/VISION TEA BROKERS LTD/g, '<span class="green-text">VISION TEA BROKERS</span>');
        // Add the table with a page break
        content += `<div class="table-page page-break">${table2Html}</div>`;
    }

    content += `</body></html>`;

    // Create a Blob with the content and trigger download
    var blob = new Blob([content], { type: 'application/msword' });
    var link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `Auction_Report_${auctionNo}.doc`;
    link.click();
});





     

    
          // Check if auction is selected when the page loads
    const auctionNoFromStorage = localStorage.getItem('selectedAuctionNo');

if (!auctionNoFromStorage) {
   
    // Display the default message if no auction is selected
    $('#defaultMessage').show();
    $('#dataTable1, #dataTable2').hide();
    $('.h3').hide();
    $('#proceed').hide();
    $('#dynamicFields').hide();
    $('#startinglot').hide();
    $('#starting_lot').hide();
}else{
    $('#proceed').show();
}
        let startingLot = 0;
    let currentLot = 0;

    // Update Lot No column sequentially from starting lot
    function updateLotNumbers() {
        currentLot = startingLot;
        $('#dataTable1 tbody tr, #dataTable2 tbody tr').each(function() {
            $(this).find('td:nth-child(5)').text(currentLot);
            currentLot++;
        });
    }

    // Function to refresh Lot No sequence on row addition, deletion, or starting lot change
    function refreshLotNumbers() {
        currentLot = startingLot;
        updateLotNumbers();
    }

    // Handle starting lot changes
    $('#saveStartingLot, #editStartingLot').click(function() {
        $('.saveButton').show()
        const auctionNo = $('#auction_no').val();
        const startingLotValue = $('#starting_lot').val();
        const action = $(this).attr('id') === 'saveStartingLot' ? 'save' : 'edit';

        if (action === 'save' && !startingLotValue) {
            alert('Please enter a starting lot value.');
            return;
        }

        $.ajax({
            url: 'process_starting_lot.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ auction_no: auctionNo, starting_lot: startingLotValue }),
            dataType: 'json',
            success: function(data) {
                startingLot = parseInt(startingLotValue);
                localStorage.setItem('startingLot', startingLot);
                refreshLotNumbers();

                $('#starting_lot').prop('disabled', action === 'save');
                $('#saveStartingLot').toggle(action !== 'save');
                $('#editStartingLot').toggle(action === 'save');
            },
            error: function() {
                alert('Error submitting starting lot');
            }
        });
    });

    // Refresh Lot No on row addition or deletion
    $('#dataTable1, #dataTable2').on('DOMNodeInserted DOMNodeRemoved', 'tbody tr', function() {
        refreshLotNumbers();
    });

    // Fetch data on auction number change and update Lot No sequence
    $('#auction_no').change(function() {
        const auctionNo = $(this).val();
            fetchStartingLot(auctionNo);
            $('#startinglot').show();
            $('#starting_lot').show();
            $('#proceed').show();
    });

    // Initial load from localStorage for auction number and starting lot
    const savedAuctionNo = localStorage.getItem('selectedAuctionNo');
    if (savedAuctionNo) {
        $('#auction_no').val(savedAuctionNo);
        fetchData(savedAuctionNo);
        fetchStartingLot(savedAuctionNo);
        fetchAuctionDates(savedAuctionNo);
    }

    // Fetch starting lot for selected auction number
    function fetchStartingLot(auctionNo) {
        $.ajax({
            url: 'process_starting_lot.php',
            type: 'GET',
            data: { auction_no: auctionNo },
            dataType: 'json',
            success: function(data) {
                startingLot = parseInt(data.starting_lot) || 0;
                currentLot = startingLot;
                localStorage.setItem('startingLot', startingLot);

                $('#starting_lot').val(startingLot).prop('disabled', !!startingLot);
                $('#saveStartingLot').toggle(!startingLot);
                $('#editStartingLot').toggle(!!startingLot);

                updateLotNumbers();
            },
            error: function() {
                alert('Error fetching starting lot');
            }
        });
    }


    // Save auction data on form submission
    $('#dataEntryForm').submit(function(event) {
        event.preventDefault(); // Prevent form default submission
        const auctionNo = $('#auction_no').val();
        localStorage.setItem('selectedAuctionNo', auctionNo); // Save auction number

        // AJAX request to insert data
        $.ajax({
            type: 'POST',
            url: 'insert_data.php',
            data: $(this).serialize(),
            success: function(response) {
                alert(response); // Alert on success
                fetchData(auctionNo); // Reload data for selected auction number
                $(' #invoice').val(''); // Clear form except auction no
            },
            error: function() {
                alert('Error inserting data');
            }
        });
    });

    // Update data when a new auction number is selected
    $('#auction_no').change(function() {
        const selectedAuctionNo = $(this).val();
        localStorage.setItem('selectedAuctionNo', selectedAuctionNo); // Update localStorage
        fetchData(selectedAuctionNo); // Fetch data for new auction number
        fetchAuctionDates(selectedAuctionNo); // Fetch associated dates
    });

    // Fetch auction dates based on the selected auction number
    function fetchAuctionDates(auctionNo) {
        if (!auctionNo) {
            $('#closingDate, #auctionDate, #promptDate').val('');
            $('#auction-header').show(); // Show the header again if no auction is selected
            return;
        }

        $.ajax({
            url: 'fetch_auction_dates.php',
            type: 'GET',
            data: { auction_no: auctionNo },
            dataType: 'json',
            success: function(data) {
                if (data) {
                    $('#closingDate').val(data.closing_date);
                    $('#auctionDate').val(data.auction_date);
                    $('#auctionDates1').text(data.auction_date);
                    $('#auctionDates2').text(data.auction_date);
                    $('#auctionDateValue2').text(data.auction_date); 
                    $('#promptDate').val(data.prompt_date);
                } else {
                    alert('No data found for this auction number');
                }
            },
            error: function() {
                alert('Error fetching auction dates');
            }
        });
    }
    //Fetch table data when auction number is selected
    function fetchData(auction_no) { 
         // Function to remove the dash and the number following it from the auction_no
      function sanitizeAuctionNo(auctionNo) {
        // Check if there is a dash in the auction_no and remove it along with the part after the dash
        return auctionNo.includes('-') ? auctionNo.split('-')[0] : auctionNo;
    }      

        const tableBody1 = $('#dataTable1 tbody');
        const tableBody2 = $('#dataTable2 tbody');
        tableBody1.empty();
        tableBody2.empty();

        if (!auction_no) {
            $('#defaultMessage').show();
            $('#dataTable1, #dataTable2').hide();
            $('h3').hide();
            $('#dynamicFields').hide();
            $('#startinglot').hide();
            $('#proceed').hide();
            return;
        }
        $('#dynamicFields').show();
        $('#startinglot').show();
        $('#starting_lot').show();
        $('#AuctionNos').text(sanitizeAuctionNo(auction_no));
        $('#secondaryAuctionNo').text(sanitizeAuctionNo(auction_no));



        

        $.ajax({
            url: 'fetch_data.php',
            type: 'GET',
            data: { auction_no: auction_no },
            success: function(data) {
               const startingLot = parseInt($('#starting_lot').val()) || '';
                updateLotNumbers();
                $('#defaultMessage').hide();
                $('#dataTable1, #dataTable2').show();
                $('#starting_lot').show();
                $('.h3').show();

                const gradesTable1 = ['BP1', 'PF1', 'PD', 'D1','Orthodox'];
                const gradesTable2 = ['BP', 'PF', 'D2', 'DUST', 'FNGS', 'BMF'];

            // Check if data is empty and display no-data message if necessary
            if (!data || data.length === 0) {
                const colspan = 16; // Adjust based on the number of columns

                tableBody1.append(`<tr><td colspan="${entry.colspan}" style="text-align: center;">No data recorded for this auction number.</td></tr>`);
                tableBody2.append(`<tr><td colspan="${entry.colspan}" style="text-align: center;">No data recorded for this auction number.</td></tr>`);
                return;
            }

                const groupedData1 = {};
                const groupedData2 = {};

                data.forEach(row => {
                    const rowData = {
                        comments: row.comments ?? '',
                        warehouse: row.warehouse ?? '',
                        value: row.valu ?? '',
                        mark: row.mark ?? '',
                        lot_no: currentLot++ ?? '',
                        grade: row.grade ?? '',
                        manf_date: row.manf_date ?? '',
                        certification: row.certification ?? '',
                        invoice: row.invoice ?? '',
                        no_of_pkgs: row.no_of_pkgs ?? '',
                        type: row.type ?? '',
                        net_weight: row.net_weight ?? '',
                        kg: row.kg ?? '',
                        nature: row.nature ?? '',
                        sale_price: row.sale ?? '',
                        id: row.id ?? ''
                    };

                    if (gradesTable1.includes(row.grade)) {
                        if (!groupedData1[row.mark]) {
                            groupedData1[row.mark] = [];
                        }
                        groupedData1[row.mark].push(rowData);
                    } else if (gradesTable2.includes(row.grade)) {
                        if (!groupedData2[row.mark]) {
                            groupedData2[row.mark] = [];
                        }
                        groupedData2[row.mark].push(rowData);
                    }
                });

                // Sort the marks alphabetically
                const sortedMarks1 = Object.keys(groupedData1).sort();
                const sortedMarks2 = Object.keys(groupedData2).sort();

                // Append grouped data to Table 1
                sortedMarks1.forEach(mark => {
                    const entries = groupedData1[mark];
                    entries.sort((a, b) => gradesTable1.indexOf(a.grade) - gradesTable1.indexOf(b.grade));
                    entries.forEach(entry => {
                        tableBody1.append(`
                            <tr>
                                <td>${entry.comments}</td>
                                <td>${entry.warehouse}</td>
                                <td>${entry.value}</td>
                                <td>${entry.mark}</td>
                                <td class="lot_no">${entry.lot_no}</td>
                                <td>${entry.grade}</td>
                                <td>${entry.manf_date}</td>
                                <td>${entry.certification}</td>
                                <td class="invoice">${entry.invoice}</td>
                                <td>${entry.no_of_pkgs}</td>
                                <td>${entry.type}</td>
                                <td>${entry.net_weight}</td>
                                <td>${entry.kg}</td>
                                <td>${entry.nature}</td>
                                <td>${entry.sale_price}</td>
                                <td class="icon-cell">  <i class="fas fa-pencil-alt edit-btn" data-id="${entry.id}" ></i>
            <i class="fas fa-minus delete-btn" data-id="${entry.id}" ></i>
                                
                               </td>
                            </tr>
                        `);
                    });
                });

                // Append grouped data to Table 2
                sortedMarks2.forEach(mark => {
                    const entries = groupedData2[mark];
                    entries.sort((a, b) => gradesTable2.indexOf(a.grade) - gradesTable2.indexOf(b.grade));
                    entries.forEach(entry => {
                        tableBody2.append(`
                            <tr>
                                <td>${entry.comments}</td>
                                <td>${entry.warehouse}</td>
                                <td>${entry.value}</td>
                                <td>${entry.mark}</td>
                                <td class="lot_no">${entry.lot_no}</td>
                                <td>${entry.grade}</td>
                                <td>${entry.manf_date}</td>
                                <td>${entry.certification}</td>
                                <td class="invoice">${entry.invoice}</td>
                                <td>${entry.no_of_pkgs}</td>
                                <td>${entry.type}</td>
                                <td>${entry.net_weight}</td>
                                <td>${entry.kg}</td>
                                <td>${entry.nature}</td>
                                <td>${entry.sale_price}</td>
                                <td class="icon-cell">  <i class="fas fa-pencil-alt edit-btn" data-id="${entry.id}"></i>
            <i class="fas fa-minus delete-btn" data-id="${entry.id}" ></i>
                      
                              
                               </td>
                            </tr>
                        `);
                    });
                });

            },
            error: function() {
                alert('Error fetching data');
            }

      
        });
    }
});
</script>
</body> 
</html>