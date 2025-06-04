<?php
// Display all errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Allow access from other origins if needed
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Block non-POST access
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['message' => 'Invalid request.']);
    exit;
}

// Load AWS SDK and config
if (!file_exists('../vendor/autoload.php') || !file_exists('../vendor/config.php')) {
    echo json_encode(['message' => 'Configuration error. Required files missing.']);
    exit;
}

require '../vendor/autoload.php';
$config = require '../vendor/config.php';

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

// Extract AWS credentials
$awsKey = $config['aws']['key'];
$awsSecret = $config['aws']['secret'];
$awsRegion = $config['aws']['region'];

// Initialize AWS SES client
$sesClient = new SesClient([
    'version' => 'latest',
    'region'  => $awsRegion,
    'credentials' => [
        'key'    => $awsKey,
        'secret' => $awsSecret,
    ],
]);

// Collect form data
$fields = [
    'name', 'dob', 'f_name', 'm_name', 'religion', 'community', 'caste', 'degree',
    'sslc_total', 'sslc_passing', 'hsc_obtained', 'hsc_total', 'hsc_passing',
    'address', 'phone', 'email', 'achievement'
];

$formData = [];
foreach ($fields as $field) {
    $formData[$field] = isset($_POST[$field]) ? trim($_POST[$field]) : '';
}

// Validate required fields
if (empty($formData['name']) || empty($formData['email']) || empty($formData['phone'])) {
    echo json_encode(['message' => 'Name, Email, and Phone are required.']);
    exit;
}

// Compose email
$subject = 'New Application from ' . $formData['name'];
$message = "New B.P.E.S Application Received:\n\n";
foreach ($formData as $key => $value) {
    $label = ucfirst(str_replace('_', ' ', $key));
    $message .= "$label: $value\n";
}

// Define sender and receiver
$senderEmail = 'asquaremailer@gmail.com'; // Must be verified in AWS SES
$recipientEmail = 'elavarasan5193@gmail.com'; // Also must be verified if SES is in sandbox

try {
    $result = $sesClient->sendEmail([
        'Destination' => [
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
        'ReplyToAddresses' => [$formData['email']],
    ]);

    echo json_encode([
        'message' => 'Application details sent successfully!',
        'messageId' => $result['MessageId']
    ]);
} catch (AwsException $e) {
    echo json_encode([
        'message' => 'Failed to send application details.',
        'error' => $e->getAwsErrorMessage()
    ]);
}
?>
