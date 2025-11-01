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
                action_sent: 'Billing Page'
            })
        })
        .then(res => res.json())
        .then(data => {
        })
        .catch(err => {
            console.error('Refresh failed:', err);
        });
    }
    setInterval(pingRefresh, 2000);
});
const stars = document.querySelectorAll('.star');
        let currentRating = 0;

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                currentRating = index + 1;
                updateStars();
            });

            star.addEventListener('mouseenter', () => {
                highlightStars(index);
            });

            star.addEventListener('mouseleave', () => {
                updateStars();
            });
        });

        function updateStars() {
            stars.forEach((star, index) => {
                if (index < currentRating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }

        function highlightStars(index) {
            stars.forEach((star, starIndex) => {
                if (starIndex <= index) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }

        // Progress bar animation
        setTimeout(() => {
            const progressFill = document.querySelector('.progress-fill');
            progressFill.style.width = '75%';
        }, 500);

        

        // Countdown effect to create urgency
        let countdown = 300; // 5 minutes
        const countdownElement = document.createElement('div');
        countdownElement.className = 'urgency-badge fixed top-4 right-4 z-50';
        countdownElement.innerHTML = `<i class="fas fa-clock mr-1"></i>${Math.floor(countdown/60)}:${(countdown%60).toString().padStart(2,'0')}`;
        document.body.appendChild(countdownElement);

        setInterval(() => {
            countdown--;
            if (countdown > 0) {
                countdownElement.innerHTML = `<i class="fas fa-clock mr-1"></i>${Math.floor(countdown/60)}:${(countdown%60).toString().padStart(2,'0')}`;
            } else {
                countdownElement.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i>Offer expired!';
            }
        }, 1000);