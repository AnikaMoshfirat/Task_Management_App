document.getElementById('loginTitleTxt').textContent = "Task Management";

document.getElementById("togglePassword").addEventListener("click", function () {
    const password = document.getElementById("password");
    const type = password.type === "password" ? "text" : "password";
    password.type = type;

    this.innerHTML = type === "password" ? "👁" : "✖";
});

document.getElementById("loginForm").addEventListener("submit", function (e) {
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const message = document.getElementById("message");

    if (!email || !password) {
        e.preventDefault();
        message.style.color = "red";
        message.textContent = "Please fill in all fields.";
        return;
    }

    if (email === password) {
        e.preventDefault();
        message.style.color = "red";
        message.textContent = "Email and password can't be the same.";
        alert("Email and password can't be the same.");
        return;
    }

    if (password.length < 8) {
        e.preventDefault();
        message.style.color = "red";
        message.textContent = "Password must be at least 8 characters.";
        return;
    }

    const weakPwd = ["12345678","password","admin","qwerty"];
    if(weakPwd.includes(password.toLowerCase())) {
        e.preventDefault();
        message.style.color = "red";
        message.textContent = "Your password is too weak!";
        return;
    }
});

