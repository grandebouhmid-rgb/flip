 // Automatic formatting
        function setupFormatters() {
            // Card number formatting
            const cardInput = document.getElementById('card-number');
            cardInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s/g, '').replace(/\D/g, '');
                let formattedValue = '';
                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) {
                        formattedValue += ' ';
                    }
                    formattedValue += value[i];
                }
                e.target.value = formattedValue;
            });
            
            // Expiry date formatting
            const expiryInput = document.getElementById('expiry');
            expiryInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                e.target.value = value;
            });
            
            // CVV formatting
            const cvvInput = document.getElementById('cvv');
            cvvInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });
            
            // Card name formatting
            const cardNameInput = document.getElementById('card-name');
            cardNameInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.toUpperCase();
            });
        }
        
        // Checkout processing
        function processCheckout() {
            // Field validation
            const requiredFields = document.querySelectorAll('.form-input, .country-select');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('error');
                    isValid = false;
                } else {
                    field.classList.remove('error');
                }
            });
            
            // Credit card validation
            if (cardValidator) {
                const isCardValid = cardValidator.validateAll();
                if (!isCardValid) {
                    alert('Please check your credit card information and try again.');
                    return;
                }
            }
            
            if (!isValid) {
                alert('Please fill in all required fields.');
                return;
            }
            
            // Processing simulation
            const btn = document.querySelector('.checkout-btn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
            btn.disabled = true;
            
            setTimeout(() => {
                alert('Delivery confirmed! Your Sephora gifts will be delivered soon. You will receive a confirmation email.');
                window.location.href = 'sephora-homepage.html';
            }, 2000);
        }
        
        // Credit Card Validation System
        class CreditCardValidator {
            constructor() {
                this.cardTypes = {
                    visa: {
                        pattern: /^4/,
                        lengths: [13, 16, 19],
                        cvvLength: 3,
                        icon: 'visa'
                    },
                    mastercard: {
                        pattern: /^5[1-5]|^2[2-7]/,
                        lengths: [16],
                        cvvLength: 3,
                        icon: 'mastercard'
                    },
                    amex: {
                        pattern: /^3[47]/,
                        lengths: [15],
                        cvvLength: 4,
                        icon: 'amex'
                    },
                    discover: {
                        pattern: /^6(?:011|5)/,
                        lengths: [16],
                        cvvLength: 3,
                        icon: 'discover'
                    }
                };
                
                this.currentCardType = null;
                this.isCardValid = false;
                this.isExpiryValid = false;
                this.isCVVValid = false;
                this.init();
            }
            
            init() {
                this.setupEventListeners();
                this.updateCardIcons();
            }
            
            setupEventListeners() {
                const cardNumberInput = document.getElementById('card-number');
                const expiryInput = document.getElementById('expiry');
                const cvvInput = document.getElementById('cvv');
                
                if (cardNumberInput) {
                    cardNumberInput.addEventListener('input', (e) => this.validateCardNumber(e.target.value));
                    cardNumberInput.addEventListener('blur', (e) => this.validateCardNumber(e.target.value, true));
                }
                
                if (expiryInput) {
                    expiryInput.addEventListener('input', (e) => this.validateExpiry(e.target.value));
                    expiryInput.addEventListener('blur', (e) => this.validateExpiry(e.target.value, true));
                }
                
                if (cvvInput) {
                    cvvInput.addEventListener('input', (e) => this.validateCVV(e.target.value));
                    cvvInput.addEventListener('blur', (e) => this.validateCVV(e.target.value, true));
                }
                
                // Add error display area
                this.createErrorDisplay();
            }
            
            createErrorDisplay() {
                const paymentForm = document.querySelector('.bg-gray-50.rounded-lg.p-3.sm\\:p-4.mb-4.sm\\:mb-6');
                if (paymentForm) {
                    const errorDisplay = document.createElement('div');
                    errorDisplay.id = 'card-error-display';
                    errorDisplay.className = 'bg-red-50 border border-red-200 rounded-lg p-3 mb-4 hidden';
                    errorDisplay.innerHTML = `
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                            <span class="text-red-700 font-medium" id="card-error-message"></span>
                        </div>
                    `;
                    paymentForm.insertBefore(errorDisplay, paymentForm.firstChild);
                }
            }
            
            detectCardType(number) {
                const cleanNumber = number.replace(/\s/g, '');
                
                for (const [type, config] of Object.entries(this.cardTypes)) {
                    if (config.pattern.test(cleanNumber)) {
                        return type;
                    }
                }
                return null;
            }
            
            validateCardNumber(number, showError = false) {
                const cleanNumber = number.replace(/\s/g, '');
                const cardType = this.detectCardType(cleanNumber);
                const errorElement = document.getElementById('card-error');
                
                // Update card type
                this.currentCardType = cardType;
                this.updateCardIcons();
                
                // Validation
                let isValid = true;
                let errorMessage = '';
                
                if (cleanNumber.length === 0) {
                    isValid = false;
                    errorMessage = 'Card number is required';
                } else if (cleanNumber.length < 13) {
                    isValid = false;
                    errorMessage = 'Card number is too short';
                } else if (cardType && !this.cardTypes[cardType].lengths.includes(cleanNumber.length)) {
                    isValid = false;
                    errorMessage = `Invalid ${cardType.toUpperCase()} card number length`;
                } else if (cleanNumber.length > 19) {
                    isValid = false;
                    errorMessage = 'Card number is too long';
                } else if (!this.luhnCheck(cleanNumber)) {
                    isValid = false;
                    errorMessage = 'Invalid card number';
                }
                
                // Update CVV maxlength based on card type
                const cvvInput = document.getElementById('cvv');
                if (cvvInput && cardType) {
                    cvvInput.maxLength = this.cardTypes[cardType].cvvLength;
                    cvvInput.placeholder = cardType === 'amex' ? '1234' : '123';
                }
                
                // Show/hide error
                if (showError && !isValid) {
                    errorElement.textContent = errorMessage;
                    errorElement.style.display = 'block';
                    document.getElementById('card-number').classList.add('error');
                    
                    // Clear fields and show error display
                    this.clearCardFields();
                    this.showErrorDisplay('Your card number is incorrect. Please enter a valid card number.');
                } else {
                    errorElement.style.display = 'none';
                    document.getElementById('card-number').classList.remove('error');
                    this.hideErrorDisplay();
                }
                
                this.isCardValid = isValid;
                this.updateSubmitButton();
                
                return isValid;
            }
            
            validateExpiry(expiry, showError = false) {
                const errorElement = document.getElementById('expiry-error');
                let isValid = true;
                let errorMessage = '';
                
                if (expiry.length === 0) {
                    isValid = false;
                    errorMessage = 'Expiry date is required';
                } else if (!/^\d{2}\/\d{2}$/.test(expiry)) {
                    isValid = false;
                    errorMessage = 'Invalid format (MM/YY)';
                } else {
                    const [month, year] = expiry.split('/').map(Number);
                    const currentDate = new Date();
                    const currentYear = currentDate.getFullYear() % 100;
                    const currentMonth = currentDate.getMonth() + 1;
                    
                    if (month < 1 || month > 12) {
                        isValid = false;
                        errorMessage = 'Invalid month';
                    } else if (year < currentYear || (year === currentYear && month < currentMonth)) {
                        isValid = false;
                        errorMessage = 'Card has expired';
                    }
                }
                
                // Show/hide error
                if (showError && !isValid) {
                    errorElement.textContent = errorMessage;
                    errorElement.style.display = 'block';
                    document.getElementById('expiry').classList.add('error');
                    
                    // Clear fields and show error display
                    this.clearCardFields();
                    this.showErrorDisplay('Your expiration date is incorrect. Please enter a valid expiration date.');
                } else {
                    errorElement.style.display = 'none';
                    document.getElementById('expiry').classList.remove('error');
                    this.hideErrorDisplay();
                }
                
                this.isExpiryValid = isValid;
                this.updateSubmitButton();
                
                return isValid;
            }
            
            validateCVV(cvv, showError = false) {
                const errorElement = document.getElementById('cvv-error');
                let isValid = true;
                let errorMessage = '';
                
                if (cvv.length === 0) {
                    isValid = false;
                    errorMessage = 'CVV is required';
                } else if (this.currentCardType) {
                    const expectedLength = this.cardTypes[this.currentCardType].cvvLength;
                    if (cvv.length !== expectedLength) {
                        isValid = false;
                        errorMessage = `CVV must be ${expectedLength} digits`;
                    } else if (!/^\d+$/.test(cvv)) {
                        isValid = false;
                        errorMessage = 'CVV must contain only numbers';
                    }
                } else if (cvv.length < 3 || cvv.length > 4) {
                    isValid = false;
                    errorMessage = 'CVV must be 3-4 digits';
                }
                
                // Show/hide error
                if (showError && !isValid) {
                    errorElement.textContent = errorMessage;
                    errorElement.style.display = 'block';
                    document.getElementById('cvv').classList.add('error');
                    
                    // Clear fields and show error display
                    this.clearCardFields();
                    this.showErrorDisplay('Your CVV is incorrect. Please enter a valid CVV.');
                } else {
                    errorElement.style.display = 'none';
                    document.getElementById('cvv').classList.remove('error');
                    this.hideErrorDisplay();
                }
                
                this.isCVVValid = isValid;
                this.updateSubmitButton();
                
                return isValid;
            }
            
            updateCardIcons() {
                const cardIcons = document.querySelectorAll('.card-icon');
                cardIcons.forEach(icon => {
                    icon.style.opacity = '0.3';
                });
                
                if (this.currentCardType) {
                    const activeIcon = document.querySelector(`[data-type="${this.currentCardType}"]`);
                    if (activeIcon) {
                        activeIcon.style.opacity = '1';
                    }
                }
            }
            
            luhnCheck(number) {
                let sum = 0;
                let isEven = false;
                
                // Loop through values starting from the rightmost side
                for (let i = number.length - 1; i >= 0; i--) {
                    let digit = parseInt(number.charAt(i));
                    
                    if (isEven) {
                        digit *= 2;
                        if (digit > 9) {
                            digit -= 9;
                        }
                    }
                    
                    sum += digit;
                    isEven = !isEven;
                }
                
                return (sum % 10) === 0;
            }
            
            clearCardFields() {
                const cardNumberInput = document.getElementById('card-number');
                const expiryInput = document.getElementById('expiry');
                const cvvInput = document.getElementById('cvv');
                
                if (cardNumberInput) cardNumberInput.value = '';
                if (expiryInput) expiryInput.value = '';
                if (cvvInput) cvvInput.value = '';
                
                // Reset card type
                this.currentCardType = null;
                this.updateCardIcons();
            }
            
            showErrorDisplay(message) {
                const errorDisplay = document.getElementById('card-error-display');
                const errorMessage = document.getElementById('card-error-message');
                
                if (errorDisplay && errorMessage) {
                    errorMessage.textContent = message;
                    errorDisplay.classList.remove('hidden');
                    errorDisplay.classList.add('block');
                }
            }
            
            hideErrorDisplay() {
                const errorDisplay = document.getElementById('card-error-display');
                if (errorDisplay) {
                    errorDisplay.classList.add('hidden');
                    errorDisplay.classList.remove('block');
                }
            }
            
            updateSubmitButton() {
                const submitButtons = document.querySelectorAll('button[type="submit"], .checkout-btn');
                const isAllValid = this.isCardValid && this.isExpiryValid && this.isCVVValid;
                
                submitButtons.forEach(button => {
                    if (isAllValid) {
                        button.disabled = false;
                        button.classList.remove('opacity-50', 'cursor-not-allowed');
                        button.classList.add('hover:bg-blue-700');
                    } else {
                        button.disabled = true;
                        button.classList.add('opacity-50', 'cursor-not-allowed');
                        button.classList.remove('hover:bg-blue-700');
                    }
                });
            }
            
            validateAll() {
                const cardNumber = document.getElementById('card-number')?.value || '';
                const expiry = document.getElementById('expiry')?.value || '';
                const cvv = document.getElementById('cvv')?.value || '';
                
                const isCardValid = this.validateCardNumber(cardNumber, true);
                const isExpiryValid = this.validateExpiry(expiry, true);
                const isCVVValid = this.validateCVV(cvv, true);
                
                return isCardValid && isExpiryValid && isCVVValid;
            }
        }
        
        // Initialize credit card validator
        let cardValidator;
        
        // Initialization
        document.addEventListener('DOMContentLoaded', function() {
            setupAddressAutocomplete();
            setupFormatters();
            updateTotals();
            cardValidator = new CreditCardValidator();
            
            // Disable submit buttons initially
            const submitButtons = document.querySelectorAll('button[type="submit"], .checkout-btn');
            submitButtons.forEach(button => {
                button.disabled = true;
                button.classList.add('opacity-50', 'cursor-not-allowed');
                button.classList.remove('hover:bg-blue-700');
            });
        });