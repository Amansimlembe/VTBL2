<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include 'db_conn.php'; // Ensure this file contains the correct DB connection using mysqli

// Function to sanitize input
function v($d) {
    return htmlspecialchars(stripslashes(trim($d)));
}

// Check if the form is submitted
if (isset($_POST['user_name'], $_POST['password'])) {
    // Sanitize user inputs
    $u = v($_POST['user_name']);
    $p = v($_POST['password']);

    // Validate input
    if (empty($u)) {
        die("User Name is required"); // Debugging message
    }
    if (empty($p)) {
        die("Password is required"); // Debugging message
    }

    // Create the SQL query without using prepared statements
    $query = "SELECT * FROM login_table WHERE user_name = '$u'";
    
    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        // Fetch the user data
        $row = mysqli_fetch_assoc($result);

        // Check if user exists
        if ($row) {
            // Debugging: Show found user and password
            echo "User found: " . htmlspecialchars($row['user_name']) . "<br>";

            // Compare the entered password with the one stored in the database
            if ($p === $row['password']) {
                // Password matches, redirect to the next page
                header("Location: VTBL-NavBar3.php?user_name=" . urlencode($row['user_name']));
                exit();
            } else {
                echo "Password is incorrect."; // Debugging message
            }
        } else {
            echo "No user found."; // Debugging message
        }
    } else {
        echo "Error in query: " . mysqli_error($conn); // Debugging message for query errors
    }
} else {
    die("Invalid request."); // Handle case where form is not submitted correctly
}

// Close the database connection
mysqli_close($conn); // Close the connection
?>
