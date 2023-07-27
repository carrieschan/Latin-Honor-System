var birthMonthSelect = document.querySelector('select[name="birthmonth"]');
var birthDateSelect = document.querySelector('select[name="birthdate"]');
var birthYearSelect = document.querySelector('select[name="birthyear"]');
var courseSelect = document.getElementById('course');
var months = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];
var courses = ["DICT", "BSIT"];
var courseSelect = document.getElementById('course');
var dates = Array.from({
    length: 31
}, (_, i) => i + 1);
var startYear = 1900;
var endYear = 2013;
var years = Array.from({
    length: endYear - startYear + 1
}, (_, i) => endYear - i);

function populateSelect(selectElement, options) {
    options.forEach(function (option) {
        var optionElement = document.createElement('option');
        optionElement.value = option;
        optionElement.text = option;
        selectElement.appendChild(optionElement);
    });
}

populateSelect(courseSelect, courses);
populateSelect(birthMonthSelect, months);
populateSelect(birthDateSelect, dates);
populateSelect(birthYearSelect, years);

var passwordInput = document.getElementById("password1");
var confirmPasswordInput = document.getElementById("password");

confirmPasswordInput.addEventListener("input", function () {
    var password = passwordInput.value;
    var confirmPassword = confirmPasswordInput.value;

    if (password !== confirmPassword) {
        confirmPasswordInput.setCustomValidity("Passwords do not match");
    } else {
        confirmPasswordInput.setCustomValidity("");
    }
});