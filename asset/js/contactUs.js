document.getElementById('contactForm').addEventListener('submit', function(event) {
    const nameElement = document.getElementById('name');
    const emailElement = document.getElementById('email');
    const messageElement = document.getElementById('message');
    const er = document.getElementById('errMsg');

    const name = nameElement.value.trim();
    const email = emailElement.value.trim();
    const message = messageElement.value.trim();

    if(name === "") {
        event.preventDefault();
        er.style.color = "red";
        er.innerHTML = "Please write your name!";
    } else if(email === "") {
        event.preventDefault();
        er.style.color = "red";
        er.innerHTML = "Please write your email address!";
    } else if (message === "") {
        event.preventDefault();
        er.style.color = "red";
        er.innerHTML = "Please write something!";
    } else {
        er.innerHTML = "";
        alert('Your message has been submitted!');
    }
});
