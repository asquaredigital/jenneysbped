<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Script accessed directly without form submission
    $response = array('message' => 'Invalid request.');
    echo json_encode($response);
    exit;
}

// Get form data
$name = $_POST['name'];
$f_name = $_POST['f_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$year = $_POST['year'];
$position = $_POST['position'];

$address = $_POST['address'];




// Set up email headers
$headers = "From: www.jenneysphysicaleducation.com" . "\r\n" .
           "Reply-To: $u_email" . "\r\n" ;

// Set up email content
$subject = 'Alumni Enquiry Form the Website';
$message = "Name: $name\nFather Name: $f_name\nEmail: $email\nPhone Number: $phone\nYear Passed Out: $year\nPosition: $position\nAddress: $address";
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
