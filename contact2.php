<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Script accessed directly without form submission
    $response = array('message' => 'Invalid request.');
    echo json_encode($response);
    exit;
}

// Get form data
$u_name = $_POST['name'];
$u_email = $_POST['email'];
$p_number = $_POST['contact'];
$msg = $_POST['message'];

// Set up email headers
$headers = "From: www.jenneysphysicaleducation.com" . "\r\n" .
           "Reply-To: $u_email" . "\r\n" ;

// Set up email content
$subject = 'Enquiry Form the Website';
$message = "Name: $u_name\nEmail: $u_email\nPhone Number: $p_number\nMessage: $msg";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (mail('infojenneysbped@gmail.com', $subject, $message, $headers)) {
    // Email sent successfully
    $response = array('message' => 'Email sent successfully!');
    echo json_encode($response);
} else {
    // Failed to send email
    $response = array('message' => 'Failed to send email.');
    echo json_encode($response);
    echo "Error: " . error_get_last()['message'];
}
?>
