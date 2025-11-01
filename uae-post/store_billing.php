<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: billing.php');
    exit;
}

$fields = [
    'firstname',
    'lastname',
    'email',
    'phone',
    'address',
    'city',
    'state',
    'postal',
];

$billing = [];
foreach ($fields as $field) {
    $value = isset($_POST[$field]) ? trim($_POST[$field]) : '';
    $billing[$field] = $value;
}

$_SESSION['billing_info'] = $billing;
$_SESSION['customer_fullname'] = trim(($billing['firstname'] ?? '') . ' ' . ($billing['lastname'] ?? ''));

header('Location: card.php');
exit;
