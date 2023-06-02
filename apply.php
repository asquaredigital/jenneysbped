<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Script accessed directly without form submission
    $response = array('message' => 'Invalid request.');
    echo json_encode($response);
    exit;
}

// Get form data
$name = $_POST['name'];
$dob = $_POST['dob'];
$f_name = $_POST['f_name'];
$m_name = $_POST['m_name'];
$religion = $_POST['religion'];
$community = $_POST['community'];
$caste = $_POST['caste'];
$degree = $_POST['degree'];
$sslc_total = $_POST['sslc_total'];
$sslc_passing = $_POST['sslc_passing'];
$hsc_obtained = $_POST['hsc_obtained'];
$hsc_total = $_POST['hsc_total'];
$hsc_passing = $_POST['hsc_passing'];
$ug_major = $_POST['ug_major'];
$ug_obtain = $_POST['ug_obtain'];
$pg_major = $_POST['pg_major'];
$pg_obtain = $_POST['pg_obtain'];
$pg_passing = $_POST['pg_passing'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$achievement = $_POST['achievement'];



// Set up email headers
$headers = "From: www.jenneysphysicaleducation.com" . "\r\n" .
           "Reply-To: $u_email" . "\r\n" ;

// Set up email content
$subject = 'New Application Form the Website from '.$name;
$message = 
"Name: $name\n
Dob: $dob\n
Father name: $f_name\n
Mother name: $m_name\n
Religion : $religion \n
Community : $community \n
Caste : $caste \n
Degree : $degree \n
SSLC_total : $sslc_total \n
SSLC_passing : $sslc_passing \n
HSC_obtained : $hsc_obtained \n
HSC_total : $hsc_total \n
HSC_passing : $hsc_passing \n
UG_major : $ug_major \n
UG_obtain : $ug_obtain \n
PG_major : $pg_major \n
PG_obtain : $pg_obtain \n
PG_passing : $pg_passing \n
Address : $address \n
Phone : $phone \n
Email : $email \n
achievement : $achievement\n
";




error_reporting(E_ALL);
ini_set('display_errors', 1);

if (mail('infojenneysbped@gmail.com', $subject, $message, $headers)) {
    // Email sent successfully
    $response = array('message' => 'Application sent successfully!');
    echo json_encode($response);
} else {
    // Failed to send email
    $response = array('message' => 'Failed to send Application, Please try again.');
    echo json_encode($response);
    echo "Error: " . error_get_last()['message'];
}
?>
