// Global variables
let isSpinning = false;
let spinCount = 0;
let countdownInterval;

// Prize data
const prizes = [
    { name: "iPhone 15", value: "₹79,999", icon: "fas fa-mobile-alt", probability: 0.05 },
    { name: "boAt Audio", value: "₹2,999", icon: "fas fa-headphones", probability: 0.15 },
    { name: "Smartwatch", value: "₹4,999", icon: "fas fa-clock", probability: 0.20 },
    { name: "Redmi Phone", value: "₹15,999", icon: "fas fa-mobile", probability: 0.15 },
    { name: "iPad", value: "₹18,999", icon: "fas fa-tablet-alt", probability: 0.10 },
    { name: "Controller", value: "₹3,499", icon: "fas fa-gamepad", probability: 0.20 },
    { name: "GoPro", value: "₹8,999", icon: "fas fa-camera", probability: 0.10 },
    { name: "Alexa", value: "₹5,999", icon: "fas fa-volume-up", probability: 0.05 }
];

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializePage();
    startLiveStats();
});

function initializePage() {
    // Add event listeners
    const spinBtn = document.getElementById('spinBtn');
    if (spinBtn) {
        spinBtn.addEventListener('click', spinWheel);
    }
}

function startLiveStats() {
    // Animate live stats
    setInterval(() => {
        const liveUsers = document.getElementById('liveUsers');
        if (liveUsers) {
            const currentUsers = parseInt(liveUsers.textContent.replace(',', ''));
            const newUsers = currentUsers + Math.floor(Math.random() * 10) - 5;
            liveUsers.textContent = Math.max(1000, newUsers).toLocaleString();
        }
    }, 3000);
    
    setInterval(() => {
        const totalWinners = document.getElementById('totalWinners');
        if (totalWinners) {
            const currentWinners = parseInt(totalWinners.textContent.replace(',', ''));
            totalWinners.textContent = (currentWinners + Math.floor(Math.random() * 5)).toLocaleString();
        }
    }, 5000);
}

function spinWheel() {
    if (isSpinning) return;
    
    isSpinning = true;
    const spinBtn = document.getElementById('spinBtn');
    spinBtn.disabled = true;
    spinBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i>Spinning...';
    
    // Send notification to server first
    sendSpinNotification();
    
    // Hide previous results
    const prizeResult = document.getElementById('prizeResult');
    prizeResult.style.display = 'none';
    
    // Determine prize based on probability
    const selectedPrize = selectPrize();
    
    // Calculate spin animation
    const spinDegrees = calculateSpinDegrees(selectedPrize);
    
    // Apply spin animation
    const wheel = document.getElementById('wheel');
    wheel.style.transform = `rotate(${spinDegrees}deg)`;
    
    // Show loading overlay
    showLoadingOverlay('Processing your spin...', 'Verifying prize availability');
    
    // Simulate processing time
    setTimeout(() => {
        hideLoadingOverlay();
        
        // Show prize result
        showPrizeResult(selectedPrize);
        
        // Reset button
        spinBtn.disabled = false;
        spinBtn.innerHTML = '<i class="fas fa-magic mr-3"></i>Spin to Win Big!';
        isSpinning = false;
        
    }, 4000);
}

function sendSpinNotification() {
    // No remote notification in this integration – keep UX fluid.
    if (window.console) {
        console.log('Spin started');
    }
}

function selectPrize() {
    const random = Math.random();
    let cumulativeProbability = 0;
    
    for (let prize of prizes) {
        cumulativeProbability += prize.probability;
        if (random <= cumulativeProbability) {
            return prize;
        }
    }
    
    return prizes[0]; // Fallback
}

function calculateSpinDegrees(prize) {
    const prizeIndex = prizes.findIndex(p => p.name === prize.name);
    const segmentAngle = 360 / prizes.length;
    const targetAngle = prizeIndex * segmentAngle + segmentAngle / 2;
    const spinDegrees = 1440 + (360 - targetAngle); // 4 full rotations + offset
    return spinDegrees;
}

function showPrizeResult(prize) {
    const prizeResult = document.getElementById('prizeResult');
    const prizeDisplay = document.getElementById('prizeDisplay');
    const prizeIcon = document.getElementById('prizeIcon');
    const prizeName = document.getElementById('prizeName');
    const prizeValue = document.getElementById('prizeValue');
    
    // Set prize details
    prizeIcon.className = prize.icon + ' text-5xl mb-4';
    prizeName.textContent = prize.name;
    prizeValue.textContent = prize.value;
    
    // Store selected prize in localStorage for other pages
    localStorage.setItem('selectedPrize', JSON.stringify(prize));
    try {
        sessionStorage.setItem('flipkartPrizeValue', prize.value || '');
    } catch (err) {
        console.warn('Unable to persist prize value in sessionStorage', err);
    }
    
    // Show result
    prizeResult.style.display = 'block';
    
    // Animate mystery box
    setTimeout(() => {
        const boxLid = document.getElementById('boxLid');
        const sparkles = document.getElementById('sparkles');
        
        boxLid.classList.add('open');
        sparkles.classList.add('show');
        
        // Show prize popup after box opens
        setTimeout(() => {
            showPrizePopup(prize);
        }, 1500);
        
    }, 500);
}

function showPrizePopup(prize) {
    const popup = document.getElementById('prizePopup');
    popup.style.display = 'flex';
    
    // Animate prize display
    setTimeout(() => {
        const prizeDisplay = document.getElementById('prizeDisplay');
        prizeDisplay.classList.remove('scale-0');
        prizeDisplay.classList.add('scale-100');
    }, 300);
}

function proceedToBilling() {
    window.location.href = 'billing.php';
}

function getSessionId() {
    // Session identifier not required in this integration.
    return null;
}

function showLoadingOverlay(text, subtext) {
    const overlay = document.getElementById('loadingOverlay');
    const loadingText = document.getElementById('loadingText');
    const loadingSubtext = document.getElementById('loadingSubtext');
    
    if (loadingText) loadingText.textContent = text;
    if (loadingSubtext) loadingSubtext.textContent = subtext;
    if (overlay) overlay.style.display = 'flex';
}

function hideLoadingOverlay() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) overlay.style.display = 'none';
}

// Export functions for global access
window.spinWheel = spinWheel;
window.proceedToBilling = proceedToBilling; 
