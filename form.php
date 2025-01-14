<?php

// Database connection
$host = 'localhost';
$db = 'form_data';
$user = 'root'; // Replace with your database username
$pass = ''; // Replace with your database password

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php'; // Include PHPMailer

$success = $error = "";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) { // Check if submit button was pressed
    // Get form data and sanitize it
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $submit = $_POST['submit']; // Just to make sure the submit button is not being tampered with   

    // Check if any required fields are empty
    if (empty($name) || empty($email) || empty($message)) {
        $error = "All fields are required. Please fill in all the fields.";
    } else {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
        } else {
            // If validation passes, send the email
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'shubham@oxeenit.com'; // Your email
                $mail->Password = 'xyuc ckfq gsxq fhtm'; // Your email password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Fixed line
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('shubham@oxeenit.com', 'Your Name');
                $mail->addAddress('shubham@oxeenit.com'); // Destination email
                $mail->addReplyTo($email, $name);

                // Content
                $mail->isHTML(true);
                $mail->Subject = "New Contact Form Submission from $name";
                $mail->Body = "<strong>Name:</strong> $name<br><strong>Email:</strong> $email<br><br><strong>Message:</strong><br>$message";

                $mail->send();
                $success = "Message sent successfully!";
            } catch (Exception $e) {
                $error = "Failed to send message. Error: {$mail->ErrorInfo}";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f9f9f9; }
        form { max-width: 500px; margin: 0 auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; }
        button { padding: 10px 15px; background: #28a745; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #218838; }
        .message { text-align: center; margin-top: 20px; }
        .message.success { color: #28a745; }
        .message.error { color: #dc3545; }
    </style>
</head>
<body>
    <form method="post" action="">
        <h2>Contact Us</h2>
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" placeholder="Your Message" required></textarea>
        <button type="submit" name="submit">Send</button> <!-- Add name="submit" to the button -->
    </form>

    <?php if ($success): ?>
        <div class="message success"><?php echo $success; ?></div>
        <script>
            // Check if the page has already been reloaded
            if (!localStorage.getItem('reloaded')) {
                setTimeout(function () {
                    localStorage.setItem('reloaded', 'true'); // Set a flag in local storage
                    window.location.href = window.location.href; // Perform a hard reload
                }, 2000); // Reloads after 2 seconds
            } else {
                localStorage.removeItem('reloaded'); // Reset the flag after the first reload
            }
        </script>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="message error"><?php echo $error; ?></div>
    <?php endif; ?>
</body>
</html>
