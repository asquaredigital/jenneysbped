<?php
require '../vendor/vendor/autoload.php';

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Script accessed directly without form submission
    $response = array('message' => 'Invalid request.');
    echo json_encode($response);
    exit;
}

$config = require '../vendor/config.php';

$awsKey = $config['aws']['key'];
$awsSecret = $config['aws']['secret'];
$awsRegion = $config['aws']['region'];

$sesClient = new SesClient([
    'version' => 'latest',
    'region' => $awsRegion,
    'credentials' => [
        'key' => $awsKey,
        'secret' => $awsSecret,
    ],
]);
// Get form data
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
$ug_passing = $_POST['ug_passing'];
$pg_major = $_POST['pg_major'];
$pg_obtain = $_POST['pg_obtain'];
$pg_passing = $_POST['pg_passing'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$achievement = $_POST['achievement'];


// Set up email headers
$headers = "From: www.jenneysphysicaleducation.com" . "\r\n" .
           "Reply-To: $email" . "\r\n" ;

// Set up email content
$subject = 'New B.P.Ed Application Form the Website from '.$name;
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
UG_passing : $ug_passing \n
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

$senderEmail = 'asquaremailer@gmail.com';
$recipientEmail = 'infojenneysbped@gmail.com';
//$recipientEmail = 'elavarasan5193@gmail.com';

try {
    $result = $sesClient->sendEmail(['Destination' => [
        'ToAddresses' => [$recipientEmail],
    ],
    'Message' => [
        'Body' => [
            'Text' => [
                'Charset' => 'UTF-8',
                'Data' => $message,
            ],
        ],
        'Subject' => [
            'Charset' => 'UTF-8',
            'Data' => $subject,
        ],
    ],
    'Source' => $senderEmail,
    'ReplyToAddresses' => [$email], // Specify Reply-To header

]);

// Prepare JSON response
$response = ['message' => 'Contact details sent successfully!', 'messageId' => $result['MessageId']];
echo json_encode($response);
} catch (AwsException $e) {
// Prepare JSON error response
$response = ['message' => 'Failed to send Contact details, Contact Support.', 'error' => $e->getAwsErrorMessage()];
echo json_encode($response);
}
?>




