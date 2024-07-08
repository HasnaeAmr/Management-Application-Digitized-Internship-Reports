<?php
include "../include/database.php"; // Include your database connection file

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Insert data into the database
    $stmt = $database->prepare("INSERT INTO contactus (fullName, email, subject, message) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$fullname, $email, $subject, $message])) {
        // Data inserted successfully
        echo "<script>alert('Your message has been sent.'); window.location.href = 'landing.html';</script>";
    } else {
        // Error occurred
        echo "<script>alert('Error: Unable to send message.');</script>";
    }
}
?>
