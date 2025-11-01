
"use strict";

/**
 * Localization for Parsley validation messages
 */


Parsley.addMessages('en', { //This language code needs to match the country of the page
    defaultMessage: "This value seems to be invalid.",
    type: {
        email:        "Email address seems to be invalid",
    },
    name: "Please check the input, no special characters are allowed",
    address: "Please check the address, no special characters are allowed",
    zip: "Please check your zip code, seems to be invalid",
    phone:"Please check your phone number, it should be at least 6 digits in format (xxxxxx or +xxxxxx)",
    ccNumber: "Invalid credit card number - please check that you have entered the credit card number correctly, or try again with another card",
    ccCvv: "Please check your CVV number, 3 digits number",
    ccExpiresMonth: "The expire month is invalid - please check the entered expiration date (MM/YY)",
    ccExpiresYear: "The expire year is invalid - please check the entered expiration date (MM/YY)",
    country: "Please select the country",
    terms: "Please accept our Terms & Conditions before continuing",
    subscription: "Subscription",
    username: "Username",
    password: "Password",
    required: "This field is required",
    minlength: "This value is too short. It should have %s characters or more",
    maxlength: "This value is too long. It should have %s characters or fewer",
    length: "This value length is invalid. It should be between %s and %s characters long",
});
Parsley.setLocale('en'); //This language code needs to match the country of the page

/**
 * Localization for custom messages
 */

var localization = {
    en: { //This language code needs to match the country of the page
        translation: {
            cardWarningMessage: "Please ensure that you card is open for online purchases or use another card",
            continuePaymentBtnText: "Continue Payment",
            cancelBtnText: "Cancel",
            disabledBtnText: "Please wait..."
        }
    }
};
