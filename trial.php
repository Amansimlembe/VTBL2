<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload with Validation</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

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
        position: absolute;
        top: 90px;
        right: 20px;
        color: grey;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        font-size: 16px;
        cursor: pointer;
        text-align: center;
    }

    .close-btn1:hover {
        background-color: darkred;
    }
</style>

<body>
    <h1>Upload and Submit File</h1>

    <!-- File Upload Form -->
    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="uploaded_file" id="uploaded_file" required>
        <button type="submit">Upload</button>
    </form>

    <!-- Alert Section -->
    <div id="alert" style="margin-top: 20px;"></div>
    <button class="close-btn1">X</button>

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

    <script>
       $(document).ready(function () {
    // Retrieve processed data from localStorage if available
    let processedData = JSON.parse(localStorage.getItem("processedData")) || [];

    // If there is data stored in localStorage, show the table
    if (processedData.length > 0) {
        $('#dataTable').show();
        $('#submit_edit').show();
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
                $('#submit_edit').hide();
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
        $('#submit_edit').show();
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

                // Reload the page after submission
                location.reload();
            },
            error: function (xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });

    // Close button functionality
    $('.close-btn1').on('click', function () {
        $('#dataTable, #alert').hide();
        $('#submit_edit').hide();
        localStorage.removeItem("processedData"); // Remove data from localStorage
    });
});

    </script>
</body>
</html>
