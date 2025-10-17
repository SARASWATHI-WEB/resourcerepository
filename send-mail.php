<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "vendor/autoload.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $emailInput = $_POST['email']; // Get the input of email addresses
    $message = $_POST['message'];

    // Split the email addresses by comma and trim whitespace
    $emailArray = array_map('trim', explode(',', $emailInput));

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "sarasuji03@gmail.com"; // Your email address
        $mail->Password = "rqbt svmq dczx ltgc "; // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($emailInput); // Sender's email

        // Loop through the email array and add each address
        foreach ($emailArray as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // Validate email format
                $mail->addAddress($email); // Add each email address
            } else {
                echo "Invalid email format: $email<br>";
            }
        }

        $mail->Subject = "New Contact Form Submission";
        $mail->Body = "Name: $name\n".
                      "Email: $emailInput\n". // Original input for reference
                      "Message: $message";

        if ($mail->send()) {
            echo "Message sent successfully.";
        } else {
            echo "Message could not be sent, Error: " . $mail->ErrorInfo; 
        }

    } catch (Exception $e) {
        echo "Message could not be sent, Error: " . $mail->ErrorInfo; 
    }
}
?>