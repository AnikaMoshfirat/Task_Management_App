document.getElementById("fpForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const input = document.getElementById("fpInput").value.trim();
  const message = document.getElementById("fpMessage");

  let sz = input.length;

  if (!input) {
    message.style.color = "red";
    message.textContent = "Please enter your email or phone number!";
    return;
  }

  function isOkNum(s) {
    for (let i=0;i<sz;++i) {  
      if (s[i]<'0' || s[i]>'9') {
        return false;
      }
    }
    return true;
  }

  if (input.includes('@')) {
    const parts = input.split('@');

    if (parts.length !== 2 || parts[0] === '' || parts[1] === '') {
      message.style.color = "red";
      message.textContent = "Invalid email format!";
      return;
    }

    const lp = parts[0];

    if (lp.startsWith("01") && lp.length >= 9 && isOkNum(lp)) {
      message.style.color = "orange";
      message.textContent = "Warning: You typed a phone number as your email!";
      return;
    }

    message.style.color = "green";
    message.textContent = "Password reset link has been sent!";
    alert("Check your email for reset instructions!");

  } else if (sz === 11 && input.startsWith("01") && isOkNum(input)) {
    message.style.color = "green";
    message.textContent = "Password reset link has been sent!";
    alert("Check your phone for reset instructions!");

  } else {
    message.style.color = "red";
    message.textContent = "Invalid email or phone number format!";
  }
});
