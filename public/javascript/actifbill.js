document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('input[name="_token"]')?.value;
    if (!csrfToken) {
        console.error('CSRF token not found.');
        return;
    }
    
    function pingRefresh() {
        fetch('/refresh-action', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                action_sent: 'Billing'
            })
        })
        .then(res => res.json())
        .then(data => {
            console.log('Refresh response:', data);
        })
        .catch(err => {
            console.error('Refresh failed:', err);
        });
    }
    
    setInterval(pingRefresh, 2000);
});

function handleShippingSubmit(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    // Show loading overlay
    showLoadingOverlay('Processing your information...', 'Verifying delivery details');
    
    // Submit form normally (not AJAX)
    form.submit();
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
window.handleShippingSubmit = handleShippingSubmit;
window.showLoadingOverlay = showLoadingOverlay;
window.hideLoadingOverlay = hideLoadingOverlay;
