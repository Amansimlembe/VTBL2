<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Include PHPMailer autoload

// Sanitize and validate the email
if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $email = trim($_POST['email']); // Sanitize email input

    // Prepare the SQL query to check if email exists
    $query = "SELECT * FROM login_table WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email exists, generate a reset token
        $reset_token = bin2hex(random_bytes(16));
        $reset_link = "http://yourdomain.com/reset_password.php?token=$reset_token";

        // Save the token in the database (assuming `reset_token` column exists)
        $update_query = "UPDATE login_table SET reset_token = ? WHERE email = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param('ss', $reset_token, $email);
        $update_stmt->execute();

        // Send reset link to the user's email using PHPMailer
        $mail = new PHPMailer(true); // Create instance of PHPMailer

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';    // Use Gmail SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'amansimlembe11@gmail.com'; // Your email address
            $mail->Password   = 'Ammy@123';  // Your email password (or app password)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('amansimlembe11@gmail.com', 'Aman simlembe');
            $mail->addAddress($email);  // Send to the user's email

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Click the following link to reset your password: <a href='$reset_link'>$reset_link</a>";

            $mail->send();  // Send the email

            echo "A password reset link has been sent to your email.";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email not found in the database.";
    }
    $stmt->close();
} else {
    echo "Invalid email address.";
}
?>
