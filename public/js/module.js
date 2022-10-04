// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.10.0/firebase-app.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.10.0/firebase-analytics.js";
import {
    getAuth,
    RecaptchaVerifier,
    signInWithPhoneNumber,
} from "https://www.gstatic.com/firebasejs/9.10.0/firebase-auth.js";

// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyBRbwV9F4XD66UiMn7mO3i8lJmsww50aUs",
    authDomain: "laravel-phone-no-auth.firebaseapp.com",
    projectId: "laravel-phone-no-auth",
    storageBucket: "laravel-phone-no-auth.appspot.com",
    messagingSenderId: "829400206034",
    appId: "1:829400206034:web:7ece2451506430163dbb0b",
    measurementId: "G-6Z9HCFJ3JS",
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
const auth = getAuth(app);

window.recaptchaVerifier = new RecaptchaVerifier(
    "recaptcha-container",
    {},
    auth
);

const appVerifier = window.recaptchaVerifier;

$("#sendOTP").on("click", function () {
    var number = $("#number").val();

    signInWithPhoneNumber(auth, number, appVerifier)
        .then((confirmationResult) => {
            // SMS sent. Prompt user to type the code from the message, then sign the
            // user in with confirmationResult.confirm(code).
            window.confirmationResult = confirmationResult;
            // ...
            coderesult = confirmationResult;
            console.log(coderesult);
            $("#successAuth").text("Message sent");
            $("#successAuth").show();
        })
        .catch((error) => {
            $("#error").text(error.message);
            $("#error").show();
        });
});

$("#verify").on("click", function () {
    var code = $("#verification").val();
    coderesult
        .confirm(code)
        .then(function (result) {
            var user = result.user;
            console.log(user);
            $("#successOtpAuth").text("Auth is successful");
            $("#successOtpAuth").show();
        })
        .catch(function (error) {
            $("#error").text(error.message);
            $("#error").show();
        });
});

// window.onload = function () {
//     render();
// };
// function render() {
//     window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(
//         "recaptcha-container"
//     );
//     recaptchaVerifier.render();
// }
// function sendOTP() {
//     var number = $("#number").val();
//     firebase
//         .auth()
//         .signInWithPhoneNumber(number, window.recaptchaVerifier)
//         .then(function (confirmationResult) {
//             window.confirmationResult = confirmationResult;
//             coderesult = confirmationResult;
//             console.log(coderesult);
//             $("#successAuth").text("Message sent");
//             $("#successAuth").show();
//         })
//         .catch(function (error) {
//             $("#error").text(error.message);
//             $("#error").show();
//         });
// }
// function verify() {
//     var code = $("#verification").val();
//     coderesult
//         .confirm(code)
//         .then(function (result) {
//             var user = result.user;
//             console.log(user);
//             $("#successOtpAuth").text("Auth is successful");
//             $("#successOtpAuth").show();
//         })
//         .catch(function (error) {
//             $("#error").text(error.message);
//             $("#error").show();
//         });
// }
