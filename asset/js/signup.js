let uploadInput = document.getElementById('uploads');
let profileImg = document.getElementById('imgs');
let submitBtn = document.querySelector('.submit');
let cancelBtn = document.querySelector('.cancel');
let errorMsg = document.getElementById('msg');
let form = document.querySelector('form');

document.getElementById('upTxt').textContent = "SignUp";

profileImg.onclick = function () {
  uploadInput.click();
};

uploadInput.onchange = function () {
  let file = uploadInput.files[0];
  if (file) {
    let imgUrl = URL.createObjectURL(file);
    profileImg.src = imgUrl;
  }
};

function isEmpty(value) {
  return value.trim() === "";
}


function showError(message) {
  errorMsg.style.color = "red";
  errorMsg.innerHTML = message;
}


function validateForm() {

  let firstName = document.getElementById('firstname').value;
  let lastName = document.getElementById('lastname').value;
  let email = document.getElementById('email').value;
  let phone = document.getElementById('phone').value;
  let dob = document.getElementById('dob').value;
  let address = document.getElementById('address').value;
  let password = document.getElementById('password').value;
  let confirmPassword = document.getElementById('confirm_password').value;
  let gender = document.querySelector('input[name="gender"]:checked');

  if(isEmpty(firstName)) return showError("First name is required.");
  if(isEmpty(lastName)) return showError("Last name is required.");
  if(isEmpty(email) || !email.includes('@') || !email.includes('.')) return showError("Valid email is required.");
  if(isEmpty(phone) || isNaN(phone) || phone.length < 10) return showError("Valid phone number is required.");
  if(isEmpty(dob)) return showError("Date of birth is required.");
  if(isEmpty(address)) return showError("Address is required.");
  if(!gender) return showError("Please select your gender.");
  if(isEmpty(password) || password.length<8) return showError("Password must be at least 8 characters.");
  if(password !== confirmPassword) return showError("Passwords do not match.");
  if(uploadInput.files.length === 0) return showError("Please upload a profile image.");

  let weakPasswords = ["12345678", "password", "admin", "qwerty"];
  if(weakPasswords.includes(password.toLowerCase())) return showError("Password is too weak!");

  errorMsg.style.color = "green";
  errorMsg.textContent = "Info is Registered!";
  return true;
}

submitBtn.onclick = function (e) {
  e.preventDefault();
  if (validateForm()) {
    setTimeout(function () {
      form.submit();
    }, 800);
  }
};

cancelBtn.onclick = function () {
  window.location.href = "../../view/php/loginPage.php";
};
