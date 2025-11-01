
(function($) {

    "use strict";

    var warnedCcList = [];
    var bannedCcList = [];
    var language;

    $(document).ready(function () {
        getBinList();
        getLanguage();
        customValidation();
        replaceCharacters();
        showErrorMessages();
        removeErrorMessage();
        onFormSubmit();
    });

    /**
     * Adds custom validators for fields
     */
    var customValidation = function(){
        window.Parsley
            .addValidator('name', {
                validateString: function(value) {
                    var filter = /^[a-z'\-\sæøåäöÆØÅÄÖàâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇẞßĄąĆćĘęŁłŃńÓóŚśŹźŻżÑñ]{2,}$/i;
                    return filter.test(value);
                }
            })
            .addValidator('address', {
                validateString: function(value) {
                    var filter = /[a-z0-9',\.\-\sæøåäöÆØÅÄÖàâäèéêëîïôœùûüÿçÀÂÄÈÉÊËÎÏÔŒÙÛÜŸÇẞßĄąĆćĘęŁłŃńÓóŚśŹźŻżÑñ]+/i;
                    return filter.test(value);
                }
            })
            .addValidator('zip', {
                validateString: function(value, country) {
                    return validateZip(value, country);
                }
            })
            .addValidator('phone', {
                requirementType: 'string',
                validateString: function(value) {
                    return validatePhone(value);
                }
            })
            .addValidator('ccNumber', {
                validateString: function(value) {
                    return ($.payment.validateCardNumber(value) && !bannedCard(value));
                }
            })
            .addValidator('ccCvv', {
                validateString: function(value) {
                    return $.payment.validateCardCVC(value);
                }
            })
            .addValidator('ccExpiresMonth', {
                validateString: function(value) {
                    var filter = /\b(0[1-9]|1[0-2])\b/;
                    return filter.test(value);
                }
            })
            .addValidator('ccExpiresYear', {
                validateString: function(value) {
                    return validateCcExpiresYear(value);
                }
            });
    };

    /**
     * Gets the language
     */
    var getLanguage = function(){
        language = $('html').attr('lang');
        if(!language){
            language='en';
        }
    };

    /**
     * Initialize qtip tooltip message
     * and displays the message on input validation error
     */
    var showErrorMessages = function(){
        window.Parsley.on('field:error', function() {
            var element = this.$element;
            var positionAt = element.attr('data-tooltip-at');
            var positionMy = element.attr('data-tooltip-my');
            var customClasses = element.closest("form").attr('data-qtip-classes');
            var content;
            var ready;
            if(element[0].id === "terms"){
                content='Please accept our Terms & Conditions before continuing';
                ready = true;
            } else  {
                content = element.next('.parsley-errors-list').text();
                ready = false;
            }

            if (!positionAt) {
                positionAt = 'bottom left';
            }
            if (!positionMy) {
                positionMy = 'top left';
            }

            if (!customClasses) {
                customClasses = '';
            }

            element.qtip({
                content: content,
                show: {
                    ready: ready,
                    event: 'click mouseenter'
                },
                hide: {
                    event: 'mouseleave'
                },
                position: {
                    my: positionMy,
                    at: positionAt,
                    target: element
                },
                style: {
                    classes: customClasses
                }
            });
        });
    };

    /**
     * Removes qtip tooltip error message on field validation success
     */
    var removeErrorMessage = function (){
        window.Parsley.on('field:success', function() {
            var element = this.$element;
            element.qtip('destroy');
        });
    };

    /**
     * Gets the list of banned and warned cards
     * (the list is injected from backend)
     * Creates two arrays with bin numbers
     */
    var getBinList = function(){
        if (document.bin_list !== undefined) {
            document.bin_list = $.parseJSON(atob(document.bin_list));
            if (document.bin_list.block) {
                bannedCcList = document.bin_list.block;
            }
            if (document.bin_list.warning) {
                warnedCcList = document.bin_list.warning;
            }
        }
    };

    /**
     * Checks if the card bin is in list of banned cards
     * @param value
     * @returns boolean
     */
    var bannedCard = function(value){
        for(var i = 0; i < bannedCcList.length; i++) {
            var regExpStr = "^" + bannedCcList[i];
            var myRegex = new RegExp(regExpStr);
            if (myRegex.test(value)) {
                return true;
            }
        }
    };

    /**
     * Checks if the card bin is in list of warned cards
     * @param value
     * @returns boolean
     */
    var warnedCard = function(value){
        for(var i = 0; i < warnedCcList.length; i++) {
            var regExpStr = "^" + warnedCcList[i];
            var myRegex = new RegExp(regExpStr);
            if (myRegex.test(value)) {
                return true;
            }
        }
    };

    /**
     * Displays credit card warning message modal
     */
    var displayWarningMessage = function(){
        var body = $(document.body);
        var errorMessage;
        var btnText;
        var btnDisabledText;
        var btnCancel;
        if(localization && localization[language]){
            errorMessage = localization[language].translation.cardWarningMessage;
            btnText = localization[language].translation.continuePaymentBtnText;
            btnCancel= localization[language].translation.cancelBtnText;
            btnDisabledText = localization[language].translation.disabledBtnText;
        } else {
            errorMessage = 'Please ensure that your card is open for online purchases or use another card.';
            btnText = 'Continue Payment';
            btnCancel= 'Cancel';
            btnDisabledText = 'Wait...';
        }
        var errorModal = $('<div id="warning-modal">' +
            '<div class="warning-modal-inner">' +
            '<h4>' + errorMessage + '</h4>' +
            '<div class="warning-modal-buttons">' +
            '<button class="warning-cancel button">'+ btnCancel +'</button>' +
            '<button class="warning-submit button btn-txt" data-alt-text="'+btnDisabledText+'" type="submit">'+ btnText +'</button>' +
            '</div>' +
            '</div>' +
            '</div>');
        body.append(errorModal);
        handleWarningButtons();
    };


    /**
     * Payment form warning message handler
     * Depending on the user click, it submits the form or it cancels the modal
     * Sets the form data to ignore or not ignore the submission block
     */
    var handleWarningButtons = function(){
        var form = $('#payment-form');
        var warningModal = $('#warning-modal');
        if(warningModal.length){
            var cancelButton = $('.warning-cancel');
            var submitButton = $('.warning-submit');
            cancelButton.on("click", function () {
                form.data('ignore', false);
                warningModal.remove();
            });
            submitButton.on("click", function () {
                form.data('ignore', true);
                form.submit();
            });
        }
    };


    /**
     * Disable button on form submit to prevent double submission
     */
    var disableSubmitButton = function(element){
        var button = element.find('button.btn-txt');
        if(button.length) {
            var buttonText = button.data("alt-text");
            button.text(buttonText);
            button.attr('disabled', true);
        }
    };

    /**
     * Handles the forms: payment form with warning message and regular forms
     * @param form
     * @returns boolean
     */
    var handleForms = function(form){
        var cardNumberField = form.find('input[name=cc-cardnumber]');
        if(cardNumberField.length){ //Check if the form has Credit Card Number input field, if so proceed with the payment form business logic
            var modal = $('#warning-modal');
            var cardNumberValue = cardNumberField.parsley().value;
            if(warnedCard(cardNumberValue)){ //Checks if the card number value is in the list of warned cards,
                if(form.data('ignore')){ // Checks if warning modal is already displayed
                    disableSubmitButton(modal); //Modal is already displayed, disable the button (prevent double submission)
                    return true; //Submit the form
                } else { //Warning modal is not displayed
                    displayWarningMessage(); //Display the warning modal
                    return false; // Don't submit the form
                }
            } else { //Card is not on the list of warned cards
                disableSubmitButton(form); //Disable submit button from double submission
                return true; //Submit the form
            }
        } else { // It is not the payment form, proceed regularly
            disableSubmitButton(form); //Disable submit button from double submission
            return true; // Submit the form
        }
    };

    /**
     * Form submitting
     */
    var onFormSubmit = function(){
        var forms = $('form');
        if(forms.length){
            forms.each(function() {
                $(this).parsley().on('form:submit', function() {
                    var form = $(this.$element);
                    return handleForms(form);
                });
            });
        }
    };

    /**
     * Validates credit card expiration year
     * @param value
     * @returns boolean
     */
    var validateCcExpiresYear = function(value) {
        var startYearFull = new Date().getFullYear();
        var addYears = 10;
        var valueInt = parseInt(value);
        var startYear = parseInt(startYearFull.toString().substr(2, 2));
        var endYear = parseInt(startYear + addYears);
        return (valueInt) && (valueInt >= startYear) && (valueInt < endYear);
    };


    /**
     * Replaces special characters
     */
    var replaceCharacters = function() {
        window.Parsley.on('field:validate', function() {
            var element = this.$element;
            var value = element.val();
            if(value){
                value = value.replace(/æ/g, 'ae');
                value = value.replace(/ø/g, 'oe');
                value = value.replace(/å/g, 'aa');
                value = value.replace(/ä/g, 'ae');
                value = value.replace(/ö/g, 'oe');
                value = value.replace(/Æ/g, 'Ae');
                value = value.replace(/Ø/g, 'Oe');
                value = value.replace(/Å/g, 'Aa');
                value = value.replace(/Ä/g, 'Ae');
                value = value.replace(/Ö/g, 'Oe');

                value = value.replace(/à/g, 'a');
                value = value.replace(/â/g, 'a');
                value = value.replace(/à/g, 'a');
                value = value.replace(/è/g, 'e');
                value = value.replace(/é/g, 'e');
                value = value.replace(/ê/g, 'e');
                value = value.replace(/ë/g, 'e');
                value = value.replace(/î/g, 'i');
                value = value.replace(/ï/g, 'i');
                value = value.replace(/ô/g, 'o');
                value = value.replace(/œ/g, 'oe');
                value = value.replace(/ù/g, 'u');
                value = value.replace(/û/g, 'u');
                value = value.replace(/ü/g, 'u');
                value = value.replace(/ÿ/g, 'y');
                value = value.replace(/ç/g, 'c');
                value = value.replace(/À/g, 'A');
                value = value.replace(/Â/g, 'A');
                value = value.replace(/É/g, 'E');
                value = value.replace(/È/g, 'E');
                value = value.replace(/Ê/g, 'E');
                value = value.replace(/Ë/g, 'E');
                value = value.replace(/Î/g, 'I');
                value = value.replace(/Ï/g, 'I');
                value = value.replace(/Ô/g, 'O');
                value = value.replace(/Œ/g, 'Oe');
                value = value.replace(/Ù/g, 'U');
                value = value.replace(/Û/g, 'U');
                value = value.replace(/Ü/g, 'U');
                value = value.replace(/Ÿ/g, 'Y');
                value = value.replace(/Ç/g, 'C');
                value = value.replace(/ẞ/g, 'Sz');
                value = value.replace(/ß/g, 'ss');

                //Polish
                value = value.replace(/Ą/g, 'A');
                value = value.replace(/ą/g, 'a');
                value = value.replace(/Ć/g, 'C');
                value = value.replace(/ć/g, 'c');
                value = value.replace(/Ę/g, 'E');
                value = value.replace(/ę/g, 'e');
                value = value.replace(/Ł/g, 'L');
                value = value.replace(/ł/g, 'l');
                value = value.replace(/Ń/g, 'N');
                value = value.replace(/ń/g, 'n');
                value = value.replace(/Ó/g, 'O');
                value = value.replace(/ó/g, 'o');
                value = value.replace(/Ś/g, 'S');
                value = value.replace(/ś/g, 's');
                value = value.replace(/Ź/g, 'Z');
                value = value.replace(/ź/g, 'z');
                value = value.replace(/Ż/g, 'Z');
                value = value.replace(/ż/g, 'z');

                //spanish
                value = value.replace(/Ñ/g, 'Ny');
                value = value.replace(/ñ/g, 'ny');

                element.val(value);
            }

        });
    };

    /**
     * Validates zip based on the country
     * @param value
     * @param country
     * @returns boolean
     */
    var validateZip = function(value, country){
        var filter = '';
        switch(country){
            case "fr":
                filter =  /^[0-9]{5}$/;
                break;
            case "de":
                filter =  /^[0-9]{5}$/;
                break;
            case "fi":
                filter =  /^[0-9]{5}$/;
                break;
            case "jp":
                filter = /^\d{3}-\d{4}$/;
                break;
            case "se":
                filter = /^\d{3}\s?\d{2}$/;
                break;
            case "au":
                filter = /^[0-9]{4}$/;
                break;
            case "gb":
                filter = /^([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9]?[A-Za-z])))) [0-9][A-Za-z]{2})$/;
                break;
            case "dk":
                filter = /^[0-9]{4}$/;
                break;
            case "no":
                filter = /^[0-9]{4}$/;
                break;
            case "re":
                filter = /^974\d{2}$/;
                break;
            case "be":
                filter = /^[0-9]{4}$/;
                break;
            case "us":
                filter = /^\d{5}([ \-]\d{4})?$/;
                break;
            default:
                filter = /^[a-z0-9\-\s]{3,20}$/i;
        }
        return filter.test(value);
    };

    /**
     * Validates phone number
     * @param value
     * @returns boolean
     */
    var validatePhone = function(value) {
        var filter = /^[0-9\+]{6,20}$/;
        return filter.test(value);
    };

})(jQuery);